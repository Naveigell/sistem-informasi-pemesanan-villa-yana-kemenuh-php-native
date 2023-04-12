<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Lupa Password — Stisla</title>

    <?php require_once '../../server.php'; ?>
    <?php require_once '../layout/customer/style.php'; ?>
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                    <div class="card card-primary">
                        <div class="card-header"><h4>Reset Password</h4></div>

                        <div class="card-body">

                            <?php if (\Lib\Session\Session::has("errors")): ?>
                                <div class="alert alert-danger">
                                    <ul class="p-0 m-0 pl-1">
                                        <?php foreach (\Lib\Session\Session::get("errors") as $key => $value): ?>
                                            <li><?= $value; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php \Lib\Session\Session::forget("errors"); ?>
                            <?php endif; ?>

                            <?php if (\Lib\Session\Session::has("success")): ?>
                                <div class="alert alert-success">
                                    <ul class="p-0 m-0 pl-1">
                                        <?php foreach (\Lib\Session\Session::get("success") as $key => $value): ?>
                                            <li><?= $value; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php \Lib\Session\Session::forget("success"); ?>
                            <?php endif; ?>

                            <form method="POST" action="<?= route('auth.reset_password.store') . '?' . http_build_query($_GET); ?>">
                                <?php foreach ($_GET as $key => $query): ?>
                                    <input type="hidden" name="<?= $key; ?>" value="<?= $query; ?>">
                                <?php endforeach; ?>
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input id="password" type="password" class="form-control" data-indicator="pwindicator" name="password" tabindex="2">
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">Konfirmasi Password Baru</label>
                                    <input id="password-confirm" type="password" class="form-control" name="confirm_password" tabindex="2">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Reset Password
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- General JS Scripts -->
<?php require_once '../layout/customer/script.php'; ?>

</body></html>