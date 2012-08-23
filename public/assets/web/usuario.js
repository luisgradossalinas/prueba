$(document).ready(function(){

    $('#myModal').hide();
    $('#tablaUsuario').dataTable( {
		"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "Ver _MENU_ registros"
		}
	} );
    
    /*$.extend( $.fn.dataTableExt.oStdClasses, {
    "sWrapper": "dataTables_wrapper form-inline"
    } );*/
    
    $('#btnNuevo').click(function(){
        //Carga cuerpo de modal
        $.ajax({
            url: urls.siteUrl + '/usuario/form',
            success: function(result) {
                $('.modal-body').empty().html(result);
            }
        })
    })
  
})


