<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reset Password - Stan Catalog</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>/assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-custom">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-12 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-5 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2"><?=lang('Auth.resetYourPassword')?></h1>
                                        <?= view('Myth\Auth\Views\_message_block') ?>
                                        <p class="mb-4">
                                            <?=lang('Auth.enterCodeEmailPassword')?>
                                        </p>
                                    </div>
                                    <form class="user" action="<?= route_to('reset-password') ?>" method="post">
                                        <?= csrf_field() ?>
                                        
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user <?php if(session('errors.token')) : ?>is-invalid<?php endif ?>"
                                                name="token" placeholder="<?=lang('Auth.token')?>" value="<?= old('token', $token ?? '') ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.token') ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user <?php if(session('errors.email')) : ?>is-invalid<?php endif ?>"
                                                name="email" aria-describedby="emailHelp" placeholder="<?=lang('Auth.email')?>" value="<?= old('email') ?>">
                                            <div class="invalid-feedback">
                                                <?= session('errors.email') ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="password" class="form-control form-control-user <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>"
                                                    name="password" placeholder="<?=lang('Auth.password')?>" autocomplete="off">
                                                <div class="invalid-feedback">
                                                    <?= session('errors.password') ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="password" class="form-control form-control-user <?php if(session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                                                    name="pass_confirm" placeholder="<?=lang('Auth.repeatPassword')?>" autocomplete="off">
                                                <div class="invalid-feedback">
                                                    <?= session('errors.pass_confirm') ?>
                                                </div>
                                            </div>
                                        </div>

                                        <br>

                                        <button type="submit" class="btn btn-primary btn-user btn-block"><?=lang('Auth.resetPassword')?></button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <p>
                                            <?php if ($config->allowRegistration) : ?>
                                                <a class="small" href="<?= route_to('register') ?>"><?=lang('Auth.needAnAccount')?></a>
                                                <br>
                                            <?php endif; ?>
                                            <a class="small" href="<?= route_to('login') ?>"><?=lang('Auth.alreadyRegistered')?>  <?=lang('Auth.signIn')?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>