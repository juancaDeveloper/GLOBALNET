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
          <h3 class="card-title">Modulo administracion de Productos</h3>

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
            Añadir Producto
          </button>

          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Añadir Producto</h5>
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
                      <label for="">Código</label>
                      <input type="number" id="codigo" class="form-control">
                    </div>


                    <div class="form-group">
                      <label for="">descripcion</label>
                      <input type="text" id="descripcion" class="form-control">
                    </div>
                    <div class="form-group">
                      <label for="">Precio</label>
                      <input type="text" id="precio" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="">Stock</label>
                      <input type="text" id="stock" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="">Categoria</label>
                      <select name="categoria" id="categoria_id" class="form-control">

                      <?php foreach($categorias as $categoria):?>
                        <option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre ?></option>

                      <?php endforeach;?>
                      
                      ?>
                      </select>
                    </div>

                    <div class="form-group">
                      <label for="">Estado</label>
                      <input type="text" id="estado" class="form-control">
                    </div>

                    

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-primary" id="añadirProducto">Registrar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 mt-4">
          <div class="table-responsive">
            <table class="table" id="recorrido2">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Código</th>
                  <th>Descripción</th>
                  <th>Precio</th>
                  <th>Stock</th>
                  <th>Categoria</th>
                  <th>Estado</th>
                  <th>Acción</th>
                  
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
            <h5 class="modal-title" id="exampleModalLabel">Editar Productos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Edit Record Form -->
            <form action="" method="post" id="edit_form">
              <input type="hidden" id="edit_record_id" name="edit_record_id" value="">
              <div class="form-group">
                <label for="">Nombres</label>
                <input type="text" id="edit_nombre" class="form-control">
              </div>
              <div class="form-group">
                <label for="">Descripcion</label>
                <input type="text" id="edit_descripcion" class="form-control">
              </div>
              <div class="form-group">
                <label for="">Precio</label>
                <input type="text" id="edit_precio" class="form-control">
              </div>

              <div class="form-group">
                <label for="">Stock</label>
                <input type="text" id="edit_stock" class="form-control">
              </div>

             

              <div class="form-group">
                      <label for="">Categoria</label>
                      <select name="categoria" id="edit_categoria" class="form-control">

                      <?php foreach($categorias as $categoria):?>
                        <option value="<?php echo $categoria->id ?>"><?php echo $categoria->nombre ?></option>

                      <?php endforeach;?>
                      
                      ?>
                      </select>
                    </div>

              <div class="form-group">
                <label for="">Estado</label>
                <input type="text" id="edit_estado" class="form-control">
              </div>

             
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