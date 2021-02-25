<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | GNC SAC</title>
    <link rel="shortcut icon" href="<?php echo base_url("assets/login/assets/images/logo1.png"); ?>" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700" rel="stylesheet">


    <link rel="stylesheet" href="<?php echo base_url("assets/login/assets/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/login/assets/css/fontawsom-all.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/login/assets/css/style.css"); ?>">




</head>

<body>
    <div class="container-fluid">
        <div class="container">
            <div class="col-xl-10 col-lg-11 login-container">
                <div class="row">
                    <div class="col-lg-7 img-box">
                        <img src="<?php echo base_url("assets/login/assets/images/login-banner.png"); ?>" alt="">

                    </div>
                    <div class="col-lg-5 no-padding">
                        <div class="login-box">

                            <h5><img src="<?php echo base_url("assets/login/assets/images/logo1.png"); ?>" alt=""> Bienvenidos | Login</h5>
                            <?php if ($this->session->flashdata("error")) : ?>

                                <div class="alert alert-danger">
                                    <p><?php echo $this->session->flashdata("error") ?></p>

                                </div>

                            <?php endif; ?>

                            <form action="<?php echo base_url(); ?>auth/login" method="post">
                                <div class="login-row row no-margin">
                                    <label for=""><i class="fas fa-envelope"></i> Usuario</label>
                                    <input type="text" class="form-control form-control-sm" name="username">
                                </div>

                                <div class="login-row row no-margin">
                                    <label for=""><i class="fas fa-unlock-alt"></i>Contraseña</label>
                                    <input type="password" class="form-control form-control-sm" name="password">
                                </div>

                                <!-- <div class="login-row row forrr no-margin">
                               <p> <input type="checkbox"> Remember Me</p>
                               <p><a href="">Forget Password?</a></p>
                            </div> -->

                                <div class="login-row btnroo row no-margin">
                                    <button type="submit" class="btn btn-primary btn-sm"> Ingresar</button>
                                    <!-- <button class="btn btn-light  btn-sm"> Crear Cuenta </button> -->
                                </div>
                            </form>
                            <div class="login-row donroo row no-margin">
                                <p>No tiene una cuenta ? <a href="">Registrarse</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<script src="<?php echo base_url("assets/login/assets/js/jquery-3.2.1.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/login/assets/js/popper.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/login/assets/js/bootstrap.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/login/assets//plugins/scroll-fixed/jquery-scrolltofixed-min.js"); ?>"></script>
<script src="<?php echo base_url("assets/login/assets/js/script.js"); ?>"></script>

</html>