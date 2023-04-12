<?php

namespace Lib\Email;

use PHPMailer\PHPMailer\PHPMailer;

interface Mailable
{
//    public function setFrom($address, $name = '', $auto = true);

    public function addAttachment($path, $name = '', $encoding = PHPMailer::ENCODING_BASE64, $type = '', $disposition = 'attachment');

    public function addAddress($address, $name = '');

    public function addReplyTo($address, $name = '');

    public function addCC($address, $name = '');

    public function addBCC($address, $name = '');
}