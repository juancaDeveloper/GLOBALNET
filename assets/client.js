$(document).on("click", "#añadirCliente", function(e){
    e.preventDefault();
  
    var nombre = $("#nombre").val();
    var tipo_cliente_id = $("#tipo_cliente_id").val();
    var tipo_documento_id = $("#tipo_documento_id").val();
    var num_documento = $("#num_documento").val();
    var telefono = $("#telefono").val();
    var direccion = $("#direccion").val();
    var estado =$("#estado").val();
  
    if (nombre == "" || tipo_cliente_id == "" || tipo_documento_id=="" || num_documento == "" || telefono == "" || direccion == "" || estado == "") {
      alert("Campos requeridos");
    }else{
      $.ajax({
  
        url: baseurl + "Clientes/insert",
        type: "post",
        dataType: "json",
        data: {
          nombre : nombre,
          tipo_cliente_id : tipo_cliente_id,
          tipo_documento_id : tipo_documento_id,
          num_documento : num_documento,
          telefono : telefono,
          direccion : direccion,
          estado : estado
        },
        success: function(data){
  
  
          
          if (data.responce == "success") {
            $('#recorrido1').DataTable().destroy();
            mostrar();
            
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
  
  function mostrar(){
    $.ajax({
        url: baseurl + "Clientes/mostrar",
  
      type: "post",
      dataType: "json",
      success: function(data){
        if (data.responce == "success") {
  
            var i = "1";
              $('#recorrido1').DataTable( {
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
                      { "data": "tipocliente" },
                      { "data": "tipodocumento" },
                      { "data": "num_documento" },
                      { "data": "telefono" },
                      { "data": "direccion" },
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
  
  mostrar();
  
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
            url: baseurl + "Clientes/delete",
            type: "post",
            dataType: "json",
            data: {
              del_id: del_id
            },
            success: function(data){
              if (data.responce == "success") {
                  $('#recorrido1').DataTable().destroy();
                  mostrar();
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
  
      url: baseurl + "Clientes/edit",
      
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
            $("#edit_tipo_cliente_id").val(data.post.tipo_cliente_id);
            $("#edit_tipo_documento_id").val(data.post.tipo_documento_id);
            $("#edit_num_documento").val(data.post.num_documento);
            $("#edit_telefono").val(data.post.telefono);
            $("#edit_direccion").val(data.post.direccion);
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
    var edit_tipo_cliente_id = $("#edit_tipo_cliente_id").val();
    var edit_tipo_documento_id = $("#edit_tipo_documento_id").val();
    var edit_num_documento = $("#edit_num_documento").val();
    var edit_telefono = $("#edit_telefono").val();
    var edit_direccion = $("#edit_direccion").val();
    var edit_estado = $("#edit_estado").val();
  
    if (edit_record_id == "" || edit_nombre == "" || edit_tipo_cliente_id == "" || edit_tipo_documento_id == "" || edit_num_documento == "" || edit_telefono == "" || edit_direccion == "" || edit_estado == "") {
      alert("Los campos son requeridos :v");
    }else{
      $.ajax({
        url: baseurl + "Clientes/update",
        
        type: "post",
        dataType: "json",
        data: {
          edit_record_id: edit_record_id,
          edit_nombre: edit_nombre,
          edit_tipo_cliente_id: edit_tipo_cliente_id,
          edit_tipo_documento_id: edit_tipo_documento_id,
          edit_num_documento: edit_num_documento,
          edit_telefono:edit_telefono,
          edit_direccion: edit_direccion,
          edit_estado: edit_estado
        },
        success: function(data){
          if (data.responce == "success") {
            $('#recorrido1').DataTable().destroy();
            mostrar();
            $('#edit_modal').modal('hide');
            toastr["success"](data.message);
          }else{
            toastr["error"](data.message);
          }
        }
      });
  
    }
  
  });