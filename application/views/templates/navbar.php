 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index3.html" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contactos</a>
      </li>
    </ul>

   

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      </li>
      <!-- Notifications Dropdown Menu -->
    
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="<?php echo base_url("assets/img/perfil.png"); ?>" class="user-image img-circle elevation-2" alt="User Image">
          
          <span class="hidden-xs"><?php echo $this->session->userdata("nombre")?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="<?php echo base_url("assets/img/perfil.png"); ?>" class="img-circle elevation-2" alt="User Image">

            <p>
            <?php echo $this->session->userdata("nombre")?>
              <small>Member since Nov. 2012</small>
            </p>
          </li>
          <!-- Menu Body -->
          <!-- <li class="user-body">
            <div class="row">
              <div class="col-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
            <!-- /.row -->
          </li> -->
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Perfil</a>
            <a href="<?php echo base_url();?>auth/logout" class="btn btn-default btn-flat float-right">Salir</a>
           
          </li>
        </ul>
      </li>
      
    </ul>
  </nav>