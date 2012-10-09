var codigo = 0;
$(document).ready(function(){

    $('#myModal').hide();
    //$('#myModal').css('width','580px');
    
 /*   $('#tabla').dataTable({
"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
"sPaginationType": "bootstrap"
    });*/
        
    configModal = function(id){
        codigo = id;
        $('.modal').css({'width':'560px','margin':'-250px 0 0 -280px'});
        $.ajax({
            url: urls.siteUrl + '/admin/mvc/operacion/ajax/form',
            data:{id:id},
            type:'post',
            success: function(result) {
                $('.modal-body').empty().html(result);
            }
        })
        $('#myModal').show();
    }
    
    nuevo = function() {
        $('#modalTitle').empty().html('Nuevo registro');
        configModal(0);
    }
    
    editar = function(id){
        $('#modalTitle').empty().html('Editar registro');
        configModal(id);
    }
    
    elimina = function(id){
        if (confirm('¿Está seguro que desea eliminar registro?')) {
             $.ajax({
            url: urls.siteUrl + '/admin/mvc/operacion/ajax/delete',
            data:{id:id},
            type:'post',
            success: function(result) {
                location.reload();
            }
        })
        }
         
    }
    
    verRecursos = function (id) {
        $('#modalTitle').empty().html('Lista de recursos');
        //Generar tabla con recursos
        $('.modal-body').empty().html("Prueba");
        $('.modal').css({'width':'800px','margin':'-250px 0 0 -380px'});
        $('#myModal').show();

    }
    
    $('#btnGuardar').click(function(){
        $.ajax({
            url: urls.siteUrl + '/admin/mvc/operacion/ajax/validar',
            data: $('#form').serialize(),
            type:'post',
            success: function(result) {
               if(validarCampos(result)){
                   $.ajax({
                       url: urls.siteUrl + '/admin/mvc/operacion/ajax/save/id/'+ codigo,
                       data: $("#form").serialize(),
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