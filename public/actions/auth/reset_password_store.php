<?php

use Lib\Session\Session;

require_once '../../../server.php';

$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

$token = $_GET['token'];

if ($password != $confirmPassword) {
    Session::put("errors", [
        "password" => "Password dan confirm password tidak sama",
    ]);

    redirect($routes['auth.reset_password.index']);
}

$passwordReset = \App\Models\PasswordReset::instance()->raw("SELECT * FROM password_resets WHERE token = ?", [$token])->fetch(PDO::FETCH_OBJ);

if (!$passwordReset) {
    die("Error - token salah");
}

$user = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id = ?", [$passwordReset->user_id])->fetch(PDO::FETCH_OBJ);

if (!$user) {
    die("Error - user tidak ditemukan");
}

\App\Models\User::instance()->raw("UPDATE users SET password = ? WHERE id = ?", [md5($password), $user->id])->execute();
\App\Models\PasswordReset::instance()->raw("DELETE FROM password_resets WHERE user_id = ?", [$user->id])->execute();

?>
<!doctype html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal/minimal.css" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    Swal.fire(
        'Password berhasil diubah',
        'Kamu akan diarahkan ke halaman login',
        'success'
    ).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        window.location.href = '<?= route('auth.login.index'); ?>'
    })
</script>
</body>
</html>
