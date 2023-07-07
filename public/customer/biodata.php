<?php

require_once '../../server.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Layout › Top Navigation — Stisla</title>

    <?php require_once '../layout/customer/style.php'; ?>
    <?php
        $u    = \App\Models\User::instance()->raw("SELECT * FROM users WHERE id = ?", [\Lib\Session\Session::get('user')['id']])->fetch(PDO::FETCH_OBJ);
        $biodata = \App\Models\Biodata::instance()->raw("SELECT * FROM biodatas WHERE user_id = ?", [\Lib\Session\Session::get('user')['id']])->fetch(PDO::FETCH_OBJ);
    ?>
</head>

<body class="layout-3">
<div id="app">
    <div class="main-wrapper container">

        <?php require_once '../layout/customer/header.php'; ?>

        <!-- Main Content -->
        <div class="main-content" style="min-height: 670px;">
            <section class="section">
                <div class="section-body">
                    <h2 class="section-title">Profil</h2>
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <form action="<?= route('customers.profile.store'); ?>" method="post">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Biodata</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="name" value="<?= $u->name; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" name="email" value="<?= $u->email; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" name="address" value="<?= $biodata->address; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nomor Telp</label>
                                            <input type="text" name="phone" value="<?= $biodata->phone; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-6 col-12">
                            <form action="<?= route('customers.profile.password.store'); ?>" method="post">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Ubah Password</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Password Lama</label>
                                            <input type="password" name="old_password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Password Baru</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Ulangi Password Baru</label>
                                            <input type="password" name="repeat_password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Ubah</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Foto Profil</h4>
                                </div>
                                <?php
                                    $user = \Lib\Session\Session::get('user');
                                    $biodata = \App\Models\Biodata::instance()->raw("SELECT * FROM biodatas WHERE user_id = {$user['id']}")->fetchObject();
                                    $avatar = asset('assets/img/avatar/avatar-1.png');

                                    if (file_exists("../uploads/images/biodata/profile/" . $biodata->avatar)) {
                                        $avatar = "../uploads/images/biodata/profile/" . $biodata->avatar;
                                    }
                                ?>
                                <div class="card-body text text-center">
                                    <figure class="avatar avatar-xl" style="width: 200px; height: 200px;">
                                        <img style="width: 200px; height: 200px;" src="<?= $avatar; ?>">
                                    </figure>
                                    <br>
                                    <br>
                                    <button class="btn btn-primary" id="button-avatar">Ganti</button>
                                    <br>
                                    <form action="<?= route('customers.profile.avatar.store'); ?>" id="form" method="post" enctype="multipart/form-data">
                                        <input type="file" name="avatar" id="avatar" style="visibility: hidden;" accept="image/png,image/jpg,image/jpeg">
                                    </form>
                                </div>
                                <script>
                                    document.getElementById('button-avatar').addEventListener('click', function () {
                                        document.getElementById('avatar').click();
                                    });

                                    document.getElementById('avatar').addEventListener('change', function () {
                                        document.getElementById('form').submit();
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php require_once '../layout/customer/footer.php'; ?>

    </div>
</div>

<?php require_once '../layout/customer/script.php'; ?>

</body>
</html>


