$(document).on("click", "#añadirCategoria", function(e){
  e.preventDefault();

  var nombre = $("#nombre").val();
  var descripcion = $("#descripcion").val();
  var estado =$("#estado").val();

  if (nombre == "" || descripcion == "" || estado=="") {
    alert("Campos requeridos");
  }else{
    $.ajax({

      url: baseurl + "Categorias/insert",
      type: "post",
      dataType: "json",
      data: {
        nombre : nombre,
        descripcion : descripcion,
        estado : estado
      },
      success: function(data){


        
        if (data.responce == "success") {
          $('#records').DataTable().destroy();
          fetch();
          
          toastr["success"](data.message);
          
          $('#exampleModal').modal('hide');

        }else{
          toastr["error"](data.message);
          $("#valid1").html(data.message);
          
        }

      }
    });

    $("#form")[0].reset();

  }

});

// Fetch Records

function fetch(){
  $.ajax({
      url: baseurl + "Categorias/fetch",

    type: "post",
    dataType: "json",
    success: function(data){
      if (data.responce == "success") {

          var i = "1";
            $('#records').DataTable( {
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
                    { "data": "descripcion" },
                    { "data": "estado" },
                    
                    { "render": function ( data, type, row, meta ) {
                      var a = `
                              <a href="#" value="${row.id}" id="del" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                              <a href="#" value="${row.id}" id="edit" class="btn btn-sm btn-outline-success"><i class="fas fa-edit"></i></a>
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

fetch();

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
          url: baseurl + "Categorias/delete",
          type: "post",
          dataType: "json",
          data: {
            del_id: del_id
          },
          success: function(data){
            if (data.responce == "success") {
                $('#records').DataTable().destroy();
                fetch();
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

$(document).on("click", "#edit", function(e){
  e.preventDefault();

  var edit_id = $(this).attr("value");

  $.ajax({

    url: baseurl + "Categorias/edit",
    
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
          $("#edit_estado").val(data.post.estado);
        }else{
          toastr["error"](data.message);
        }
    }
  });

});

// Update Record

$(document).on("click", "#update", function(e){
  e.preventDefault();

  var edit_record_id = $("#edit_record_id").val();
  var edit_nombre = $("#edit_nombre").val();
  var edit_descripcion = $("#edit_descripcion").val();
  var edit_estado = $("#edit_estado").val();

  if (edit_record_id == "" || edit_nombre == "" || edit_descripcion == "" || edit_estado == "") {
    alert("Both field is required");
  }else{
    $.ajax({
      url: baseurl + "Categorias/update",
      
      type: "post",
      dataType: "json",
      data: {
        edit_record_id: edit_record_id,
        edit_nombre: edit_nombre,
        edit_descripcion: edit_descripcion,
        edit_estado: edit_estado
      },
      success: function(data){
        if (data.responce == "success") {
          $('#records').DataTable().destroy();
          fetch();
          $('#edit_modal').modal('hide');
          toastr["success"](data.message);
        }else{
          toastr["error"](data.message);
        }
      }
    });

  }

});

