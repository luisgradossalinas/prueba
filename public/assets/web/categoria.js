$(document).ready(function(){

    $('#myModal').hide();
    
    $('#tablaCategoria').dataTable( {
		"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap"
	} );
        
    nuevoRegistro = function(){
        $('#modalTitle').empty().html('Nueva categoría');
        $.ajax({
            url: urls.siteUrl + '/categoria/form',
            success: function(result) {
                $('.modal-body').empty().html(result);
            }
        })
    }
    
    $('#btnNuevo').click(function(){
        nuevoRegistro();
    })
    
    editarCategoria = function(id){
        $('#modalTitle').empty().html('Editar categoría');
        $.ajax({
            url: urls.siteUrl + '/categoria/form',
            data:{id:id},
            type:'post',
            success: function(result) {
                $('.modal-body').empty().html(result);
            }
        })   
        $('#myModal').show();
    }
    
    $('#btnGuardar').click(function(){
        $.ajax({
            url: urls.siteUrl + '/categoria/nuevo/ajax/save',
            data: $('#form-categoria').serialize(),
            type:'post',
            dataType:'json',
            success: function(result) {
                $('.modal-footer').prepend('<a class="alert" data-dismiss="alert" href="#">Registro grabado. &times;</a>');
                location.reload();
                
            }
        })  
        
        
        
    })
  
})


