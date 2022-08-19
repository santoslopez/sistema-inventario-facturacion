
// Metodo eliminar implementado con datatable y ajax para no recargar la pagina

function eliminarDatos(nameActivarBotonEliminar,nombreDataTable,urlQueryEliminar,mensajeEliminacionExitosa,mensajeEliminacionIncorrecta,mensajeTituloBoton,mensajeConfirmarBoton){
    $(document).on('click', nameActivarBotonEliminar, function(event) {
    var tabla = $(nombreDataTable).DataTable();
    event.preventDefault();
    
    //por default tiene que ser id el valor que va en: $(this).data('id');
    var codigoObtenidoFila = $(this).data('id');
    
    Swal.fire({
        title: mensajeTituloBoton,
        text: "La eliminación del dato no se puede recuperar.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: mensajeConfirmarBoton
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
               url:urlQueryEliminar,
               data:{
                    id:codigoObtenidoFila
               },
               type: "post",
               success: function (data1){
                    var valorJson = JSON.parse(data1);
                    var status = valorJson.status;
                    if(status=="success"){
                        tabla.ajax.reload();
                        Swal.fire(
                            mensajeEliminacionExitosa,
                            'La información se borro.',
                            'success'
                        )
                    }else{
                        Swal.fire(
                            mensajeEliminacionIncorrecta,
                            'La información no se pudo eliminar. Se produjo un error.',
                            'warning'
                        )                                }
               }

            });

        }
    })
});   
}    


// Utilizado para registrar usuario: registro success o fallido
