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


