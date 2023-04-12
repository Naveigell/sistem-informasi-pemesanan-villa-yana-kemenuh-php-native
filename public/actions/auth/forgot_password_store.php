<?php

use Lib\Session\Session;

require_once '../../../server.php';

try {
    $email = $_POST['email'];
    $user = \App\Models\User::instance()->raw("SELECT * FROM users WHERE email = ? LIMIT 1", [$email])->fetch(PDO::FETCH_OBJ);

    if (!$user) {
        Session::put("errors", [
            "auth" => "Email tidak ditemukan",
        ]);

        redirect($routes['auth.forgot_password.index']);
    }

    $id = $user->id;
    $token = md5($_ENV['APP_KEY']) . md5($user->email) . md5($id);

    \App\Models\PasswordReset::instance()->create([
        "user_id" => $user->id,
        "email" => $email,
        "token" => $token,
    ]);

    $url = route('auth.reset_password.index') . '?' . http_build_query(compact('id', 'token', 'email'));

    $mail = new \Lib\Email\Mail();
    $mail->debug(true);
    $mail->subject("Villa Yana Kemenuh - Reset Password");
    $mail->addAddress($email);
    $mail->view('../../layout/email/forgot_password.php', compact('url'));
    $mail->send();

    Session::put("success", [
        "auth" => "Berhasil mengirim link lupa password, silakan cek email anda",
    ]);

    redirect($routes['auth.forgot_password.index']);
} catch (Exception $exception) {
    die($exception->getMessage());
}