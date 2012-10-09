var codigo = 0;
var sentencia_crud = '';
$(document).ready(function(){

    $('#myModal').hide();
    //$('#myModal').css('width','580px');
    
 /*   $('#tabla').dataTable({
"sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>",
"sPaginationType": "bootstrap"
    });*/
        
    configModal = function(id, ope){
        codigo = id;
        sentencia_crud = ope;
        $('.modal').css({'width':'650px','margin':'-250px 0 0 -280px'});
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
        configModal(0, 'nuevo');
    }
    
    editar = function(id){
        $('#modalTitle').empty().html('Editar registro');
        configModal(id, 'edit');
    }
    
    elimina = function(id){
      /*  if (confirm('¿Está seguro que desea eliminar registro?')) {
             $.ajax({
            url: urls.siteUrl + '/admin/mvc/operacion/ajax/delete',
            data:{id:id},
            type:'post',
            success: function(result) {
                location.reload();
            }
        })
        }*/
        
        
        $('#modalTitle').empty().html('Mensaje del sistema');
        $('.modal-body').empty().html('¿Está seguro que desea eliminar registro?');
        $('.modal').css({'width':'380px','margin':'-250px 0 0 -200px'});
        $('#myModal').show();
         
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
                       url: urls.siteUrl + '/admin/mvc/operacion/ajax/save/scrud/' + sentencia_crud + '/id/'+ codigo,
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