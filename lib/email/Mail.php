<?php

namespace Lib\Email;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail implements Mailable
{
    private $mail;

    private $subject;

    private $view;

    private $data = [];

    private $debug = false;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        if ($this->debug) {
            $this->mail->SMTPDebug  = SMTP::DEBUG_SERVER;
        }

        $this->mail->isSMTP();
        $this->mail->Host       = $_ENV['MAIL_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['MAIL_USERNAME'];
        $this->mail->Password   = $_ENV['MAIL_PASSWORD'];
        $this->mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $this->mail->Port       = $_ENV['MAIL_PORT'];

        $this->mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
    }

    public function view($view, array $data = [])
    {
        $this->view = trim($view, DIRECTORY_SEPARATOR);
        $this->data = $data;

        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function send()
    {
        ob_start();

        extract($this->data);

        include $this->view;

        $body = ob_get_clean();

        ob_end_flush();

        $this->mail->isHTML();
        $this->mail->Subject = $this->subject;
        $this->mail->Body    = $body;

        $this->mail->send();
    }

    public function debug($debug = false)
    {
        $this->debug = $debug;
    }

    /**
     * @throws Exception
     */
    public function addReplyTo($address, $name = '')
    {
        $this->mail->addReplyTo($address, $name);
    }

    /**
     * @throws Exception
     */
    public function addCC($address, $name = '')
    {
        $this->mail->addCC($address, $name);
    }

    /**
     * @throws Exception
     */
    public function addBCC($address, $name = '')
    {
        $this->mail->addBCC($address, $name);
    }

    /**
     * @throws Exception
     */
    public function addAddress($address, $name = '')
    {
        $this->mail->addAddress($address, $name);
    }

    /**
     * @throws Exception
     */
    public function addAttachment($path, $name = '', $encoding = PHPMailer::ENCODING_BASE64, $type = '', $disposition = 'attachment')
    {
        $this->mail->addAttachment($path, $name, $encoding, $type, $disposition);
    }
}