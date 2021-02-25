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
                <h3 class="card-title">Modulo administracion de Ventas</h3>

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
                        <div class="col-md-12">
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="">Comprobante:</label>
                                        <select name="comprobantes" id="comprobantes" class="form-control" required>
                                            <option value="">Seleccione...</option>
                                            <option value="1">Boleta</option>
                                            <option value="2">Factura</option>
                                        </select>
                                        <input type="hidden" id="idcomprobante" name="idcomprobante">
                                        <input type="hidden" id="igv">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Serie:</label>
                                        <input type="text" class="form-control" name="serie" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Numero:</label>
                                        <input type="text" class="form-control" id="numero" name="numero" readonly>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="">Cliente:</label>
                                        <div class="input-group">
                                            <input type="hidden" name="idcliente" id="idcliente">
                                            <input type="text" class="form-control" disabled="disabled" id="cliente">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-default"><span class="fa fa-search"></span> Buscar</button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="">Fecha:</label>
                                        <input type="date" class="form-control" name="fecha" required>
                                    </div>


                                </div>
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label for="">Producto:</label>
                                        <input type="text" class="form-control" id="producto">
                                    </div>

                                    <div class="col-md-2">
                                        <label for="">&nbsp;</label>
                                        <button id="btn-agregar" type="button" class="btn btn-success btn-flat btn-block"><span class="fa fa-plus"></span> Agregar</button>
                                    </div>
                                </div>

                                <table id="tbventas" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nombre</th>

                                            <th>Precio</th>
                                            <th>Stock Max.</th>
                                            <th>Cantidad</th>
                                            <th>Importe</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>



                                
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-addon">Subtotal:</span>
                                            <input type="text" class="form-control" placeholder="Username" name="subtotal" readonly="readonly">
                                        </div>
                                    </div>

                                    
                               







                            </form>
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