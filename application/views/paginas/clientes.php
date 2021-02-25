<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-0">
         <!--  <div class="col-sm-6">
            <h1>Probaremos un crud</h1>
          </div> -->
       <!--    <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Inicio</a></li>
              <li class="breadcrumb-item active">Crud :V</li>
            </ol>
          </div> -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Modulo administracion de Clientes</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        <!--  Iniciar la aplicacion a qui ! -->
         <div class="container">
          <div class="row">
          
      </div>
      <div class="row">
        <div class="col-md-12 mt-2">
          <!-- Add Records Modal -->
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#exampleModal">
            Añadir cliente
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Añadir Cliente</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <!-- Add Records Form -->
                  <form action="" method="post" id="form">
                    <div class="form-group">
                      <label for="">Nombres</label>
                      <input type="text" id="nombre" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="">Tipo Cliente</label>
                      <select name="categoria" id="tipo_cliente_id" class="form-control">

                      <?php foreach($clientes as $cliente):?>
                        <option value="<?php echo $cliente->id ?>"><?php echo $cliente->nombre ?></option>

                      <?php endforeach;?>
                      
                      ?>
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label for="">Tipo de Documento</label>
                      <select name="categoria" id="tipo_documento_id" class="form-control">

                      <?php foreach($documentos as $documento):?>
                        <option value="<?php echo $documento->id ?>"><?php echo $documento->nombre ?></option>

                      <?php endforeach;?>
                      
                      ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="">Número de documento</label>
                      <input type="text" id="num_documento" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="">Telefono</label>
                      <input type="text" id="telefono" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="">Direccion</label>
                      <input type="text" id="direccion" class="form-control">
                    </div>
                    
                    <div class="form-group">
                      <label for="">Estado</label>
                      <input type="number" id="estado" class="form-control">
                    </div>
                 

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary" id="añadirCliente">Registrar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mt-4">
          <div class="table-responsive">
            <table class="table" id="recorrido1">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Tipo de Cliente</th>
                  <th>Tipo de Documento</th>
                  <th>Numero de Documento</th>
                  <th>Telefono</th>
                  <th>Direccion</th>
                  <th>Estado</th>
                  <th>Accion</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Record Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar Clientes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Edit Record Form -->
            <form action="" method="post" id="edit_form">
              <input type="hidden" id="edit_record_id" name="edit_record_id" value="">
              <div class="form-group">
                <label for="">Nombre</label>
                <input type="text" id="edit_nombre" class="form-control">
              </div>

              <div class="form-group">
                      <label for="">Tipo Cliente</label>
                      <select name="categoria" id="edit_tipo_cliente_id" class="form-control">

                      <?php foreach($clientes as $cliente):?>
                        <option value="<?php echo $cliente->id ?>"><?php echo $cliente->nombre ?></option>

                      <?php endforeach;?>
                      
                      ?>
                      </select>
                    </div>

             <div class="form-group">
                      <label for="">Tipo de Documento</label>
                      <select name="categoria" id="edit_tipo_documento_id" class="form-control">

                      <?php foreach($documentos as $documento):?>
                        <option value="<?php echo $documento->id ?>"><?php echo $documento->nombre ?></option>

                      <?php endforeach;?>
                      
                      ?>
                      </select>
                    </div>

              <div class="form-group">
                <label for="">Número de Documento</label>
                <input type="text" id="edit_num_documento" class="form-control">
              </div>
               
              <div class="form-group">
                <label for="">Teléfono</label>
                <input type="text" id="edit_telefono" class="form-control">
              </div>

              <div class="form-group">
                <label for="">Dirección</label>
                <input type="text" id="edit_direccion" class="form-control">
              </div>


              <div class="form-group">
                <label for="">Estado</label>
                <input type="number" id="edit_estado" class="form-control">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" id="modificar">Modificar</button>
          </div>
        </div>
      </div>
    </div>



        

        






        </div>
        <!-- /.card-body -->
        <div class="card-footer">
         pie de pagina 
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>