<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SISTEMA GETEK | Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  
  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css"); ?>">

  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>"> 
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  
  <!-- Theme style -->

  <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/adminlte.min.css"); ?>">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Sistema</b>GNC S.A.C</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Identificate para Iniciar Session</p>

      <?php if($this->session->flashdata("error")):?>

<div class="alert alert-danger">
<p><?php echo $this->session->flashdata("error")?></p>

</div>

<?php endif; ?>

      <form action="<?php echo base_url();?>auth/login" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username"  placeholder="Usuario">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">Olvide la Contraseña</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Registrar</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?php echo base_url("assets/plugins/jquery/jquery.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/dist/js/adminlte.min.js"); ?>"></script>

<!-- AdminLTE App -->


</body>
</html>
