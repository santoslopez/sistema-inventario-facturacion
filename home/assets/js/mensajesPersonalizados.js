/** 
 * Archivo mensajesPersonalizados.js
 * 
 * Permite personalizar el mensaje que el usuario recibe cuando quiere
 * eliminar algun dato, la personalizacion se puede dar cambiando el texto que se muestra al usuario
 * al darle click en eliminar contenido o cambiar el mensaje para confirmar la eliminacion, etc.
 * 
 * **/

 function mensajeEliminarContenido(nombreBoton,mensajeTitulo,mensajeTexto,nombreIcono,mensajeConfirmacion){
	$(nombreBoton).on('click',function(e){
		e.preventDefault();
		const href = $(this).attr('href');

		/*Sweet alert 2 */
		Swal.fire({
			title: mensajeTitulo,
			text: mensajeTexto,
			icon: nombreIcono,
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: mensajeConfirmacion,
		}).then((result) => {
			  /*if (result.isConfirmed) {
			    Swal.fire(
			      'Deleted!',
			      'Your file has been deleted.',
			      'success'
			    )
			  }*/
			if (result.value) {
			  document.location.href = href;
			 }
		})
		/* Fin sweet alert 2*/
	});
}
