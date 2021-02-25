$(document).on("click", "#añadirProducto", function(e){
    e.preventDefault();
  
    var nombre = $("#nombre").val();
    var codigo = $("#codigo").val();
    var descripcion = $("#descripcion").val();
    var precio = $("#precio").val();
    var stock = $("#stock").val();
    var categoria_id = $("#categoria_id").val();
    var estado = $("#estado").val();
    
    if (nombre == "" || codigo == "" || descripcion == "" || precio=="" || stock == "" || categoria_id == "" || estado == ""  ) {
      alert("Campos requeridos");
    }else{
      $.ajax({
  
        url: baseurl + "Productos/insert",
        type: "post",
        dataType: "json",
        data: {
          nombre : nombre,
          codigo : codigo,
          descripcion : descripcion,
          precio : precio,
          stock : stock,
          categoria_id :categoria_id,
          estado : estado
          
        },
        success: function(data){
  
  
          
          if (data.responce == "success") {
            $('#recorrido2').DataTable().destroy();
            mostrarProductos();
            
            toastr["success"](data.message);
            
            $('#exampleModal').modal('hide');
  
          }else{
            toastr["error"](data.message);
          }
  
        }
      });
  
      $("#form")[0].reset();
  
    }
  
  });
  
  // Fetch Records
  
  function mostrarProductos(){
    $.ajax({
        url: baseurl + "Productos/mostrarProductos",
  
      type: "post",
      dataType: "json",
      success: function(data){
        if (data.responce == "success") {
  
            var i = "1";
              $('#recorrido2').DataTable( {
                  "data": data.posts,
                  "responsive": true,
                  dom: 
                      "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                      "<'row'<'col-sm-12'tr>>" +
                      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                  buttons: [
                      'copy', 'excel', 'pdf'
                  ],
                  "columns": [
                      { "render": function(){
                        return a = i++;
                      } },
                      { "data": "nombre" },
                      { "data": "codigo" },
                      { "data": "descripcion" },
                      { "data": "precio" },
                      { "data": "stock" },
                      { "data": "categoria" },
                      { "data": "estado" },
                     
                      { "render": function ( data, type, row, meta ) {
                        var a = `
                                <a href="#" value="${row.id}" id="del" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                <a href="#" value="${row.id}" id="editar" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
                        `;
                        return a;
                      } }
                  ]
              } );                
          }else{
            toastr["error"](data.message);
          }
  
      }
    });
  
  }
  
  mostrarProductos();
  
  // Delete Record
  
  $(document).on("click", "#del", function(e){
    e.preventDefault();
  
    var del_id = $(this).attr("value");
  
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger mr-2'
      },
      buttonsStyling: false
    })
  
    swalWithBootstrapButtons.fire({
      title: 'Estas Seguro?',
      text: "¡No podrás revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Si, Eliminar!',
      cancelButtonText: 'No, cancelar!',
      reverseButtons: true
    }).then((result) => {
      if (result.value) {
  
          $.ajax({
            url: baseurl + "Productos/delete",
            type: "post",
            dataType: "json",
            data: {
              del_id: del_id
            },
            success: function(data){
              if (data.responce == "success") {
                  $('#recorrido2').DataTable().destroy();
                  mostrarProductos();
                  swalWithBootstrapButtons.fire(
                    'Eliminado!',
                    'Tu Registro se elimino permanentemente.',
                    'success'
                  );
              }else{
                  swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'Tu archivo imaginario está a salvo :)',
                    'error'
                  );
              }
  
            }
          });
  
  
        
      } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
          'Cancelado',
          'Tu archivo imaginario está a salvo :)',
          'error'
        )
      }
    });
  
  });
  
  // Edit Record
  
  $(document).on("click", "#editar", function(e){
    e.preventDefault();
  
    var edit_id = $(this).attr("value");
  
    $.ajax({
  
      url: baseurl + "Productos/edit",
      
      type: "post",
      dataType: "json",
      data: {
        edit_id: edit_id
      },
      success: function(data){
        if (data.responce == "success") {
            $('#edit_modal').modal('show');
            $("#edit_record_id").val(data.post.id);
            $("#edit_nombre").val(data.post.nombre);
            $("#edit_descripcion").val(data.post.descripcion);
            $("#edit_precio").val(data.post.precio);
            $("#edit_stock").val(data.post.stock);
            $("#edit_categoria").val(data.post.categoria_id);
            $("#edit_estado").val(data.post.estado);
          
          }else{
            toastr["error"](data.message);
          }
      }
    });
  
  });
  
  // Update Record
  
  $(document).on("click", "#modificar", function(e){
    e.preventDefault();
  
    var edit_record_id = $("#edit_record_id").val();
    var edit_nombre = $("#edit_nombre").val();
    var edit_descripcion = $("#edit_descripcion").val();
    var edit_precio = $("#edit_precio").val();
    var edit_stock = $("#edit_stock").val();
    var edit_categoria_id = $("#edit_categoria").val();
    var edit_estado = $("#edit_estado").val();
  
    if (edit_record_id == "" || edit_nombre == "" || edit_descripcion == "" || edit_precio == "" || edit_stock == "" || edit_categoria_id == "" || edit_estado == "") {
      alert("Los campos son requeridos :v");
    }else{
      $.ajax({
        url: baseurl + "Productos/update",
        
        type: "post",
        dataType: "json",
        data: {
          edit_record_id: edit_record_id,
          edit_nombre: edit_nombre,
          edit_descripcion: edit_descripcion,
          edit_precio: edit_precio,
          edit_stock: edit_stock,
          edit_categoria_id: edit_categoria_id,
          edit_estado: edit_estado
        },
        success: function(data){
          if (data.responce == "success") {
            $('#recorrido2').DataTable().destroy();
            mostrarProductos();
            $('#edit_modal').modal('hide');
            toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }
        }
      });
  
    }
  
  });