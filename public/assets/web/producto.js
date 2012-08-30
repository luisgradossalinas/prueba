var codigo = 0;
$(document).ready(function(){

    $('#myModal').hide();
    $('#tablaProducto').dataTable( {
		"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap"
	} );
    
    
    $('#btnNuevo').click(function(){
        //Carga cuerpo de modal
        $.ajax({
            url: urls.siteUrl + '/producto/operacion/ajax/form',
            success: function(result) {
                $('.modal-body').empty().html(result);
            }
        })
    })
    
    $('#btnGuardar').click(function(){
        $.ajax({
            url: urls.siteUrl + '/producto/operacion/ajax/validar',
            data: $('#form-producto').serialize(),
            type:'post',
            success: function(result) {
               if(validarCampos(result)){
                   $.ajax({
                       url: urls.siteUrl + '/producto/operacion/ajax/save/id/'+ codigo,
                       data: $("#form-producto").serialize(),
                       success: function(result){
                           $('.modal-footer').prepend('<a class="alert" data-dismiss="alert" href="#">Registro grabado. &times;</a>');
                            location.reload();
                       }    
                   });
               }
            }
        })  
    })
  
})


