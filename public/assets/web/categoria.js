var codigo = 0;
$(document).ready(function(){

    $('#myModal').hide();
    $('#myModal').css('width','580px');
    
    $('#tablaCategoria').dataTable({
		"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
		"sPaginationType": "bootstrap"
    });
        
    nuevo = function(){
        codigo = 0;
        $('#modalTitle').empty().html('Nuevo registro');
        $.ajax({
            url: urls.siteUrl + '/categoria/operacion/ajax/form',
            success: function(result) {
                $('.modal-body').empty().html(result);
            }
        })
    }
    
    $('#btnNuevo').click(function(){
        nuevo();
    })
    
    editar = function(id){
        codigo = id;
        $('#modalTitle').empty().html('Editar registro');
        $.ajax({
            url: urls.siteUrl + '/categoria/operacion/ajax/form',
            data:{id:id},
            type:'post',
            success: function(result) {
                $('.modal-body').empty().html(result);
            }
        })   
        $('#myModal').show();
    }
    
    elimina = function(id){
        if (confirm('¿Está seguro que desea eliminar registro?')) {
             $.ajax({
            url: urls.siteUrl + '/categoria/operacion/ajax/delete',
            data:{id:id},
            type:'post',
            success: function(result) {
                location.reload();
            }
        }) 
        }
         
    } 
    
    $('#btnGuardar').click(function(){
        $.ajax({
            url: urls.siteUrl + '/categoria/operacion/ajax/validar',
            data: $('#form-categoria').serialize(),
            type:'post',
            success: function(result) {
               if(validarCampos(result)){
                   $.ajax({
                       url: urls.siteUrl + '/categoria/operacion/ajax/save/id/'+ codigo,
                       data: $("#form-categoria").serialize(),
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


