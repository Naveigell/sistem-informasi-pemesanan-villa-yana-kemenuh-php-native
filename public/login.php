<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login — Stisla</title>

    <?php require_once '../server.php'; ?>
    <?php require_once 'layout/customer/style.php'; ?>
</head>

<body>
<div id="app">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                    <div class="card card-primary">
                        <div class="card-header"><h4>Login</h4></div>

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

                            <form method="POST" action="<?= $routes['auth.login.store']; ?>">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required="" autofocus="">
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required="">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
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
<?php require_once 'layout/customer/script.php'; ?>

</body></html>