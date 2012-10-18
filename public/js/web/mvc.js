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
        $('.modal').css({'width':'570px','margin':'-250px 0 0 -280px'});
        $.ajax({
            url: urls.siteUrl + '/admin/mvc/operacion/ajax/form',
            data:{id:id},
            type:'post',
            success: function(result) {
                $('.modal-body').empty().html(result);
            }
        })
        
        $('#btnEliminar').hide();
        $('#btnGuardar').show();
        
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
        
        codigo = id;
        $('#modalTitle').empty().html('Mensaje del sistema');
        $('.modal-body').empty().html('¿Está seguro que desea eliminar registro?');
        $('.modal').css({'width':'380px','margin':'-250px 0 0 -200px'});
        
        $('#btnEliminar').show();
        $('#btnGuardar').hide();
        
        $('#myModal').show();
         
    }
    
    verRecursos = function (id) {
        $('#modalTitle').empty().html('Lista de recursos');
        $.ajax({
            url: urls.siteUrl + '/admin/recurso/listado/ajax/listado/id_rol/' + id,
            type: 'post',
            dataType: 'json',
            success: function(result) {
                
                tablaRecurso(result);
                
            }
            
        })

    }
    
    seleccionaTodos = function() {
    //$("#title-table-checkbox .title-table-checkbox").click(function() {
        alert('Falta programar');
		var checkedStatus = $("#title-table-checkbox").checked;
		var checkbox = $("#myModal").parents('.widget-box').find('tr td:first-child input:checkbox');		
		checkbox.each(function() {
			$("#title-table-checkbox").checked = checkedStatus;
			if (checkedStatus == $("#title-table-checkbox").checked) {
				$("#title-table-checkbox").closest('.checker > span').removeClass('checked');
			}
			if ($("#title-table-checkbox").checked) {
				$("#title-table-checkbox").closest('.checker > span').addClass('checked');
			}
		});
    };
    
    tablaRecurso = function(data) {
        
        $('.modal-body').empty();
        html = '';
        html += '<div class="widget-box">';
        html += '<div class="widget-title">';	
        html += '<h5>Recursos</h5>';
        html += '</div>';
        html += '<div class="widget-content nopadding">';
        html += '<table id="tablaRecurso" class="table table-condensed table-bordered  with-check">';
        html += '<thead>';
        html += '<tr><th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" onclick=seleccionaTodos() /></th><th>Nombre</th><th>Descripción</th><th>Estado</th><th>Url</th></tr>';
        html += '</thead>';
        html += '<tbody>';
        
        $.each(data, function(key,obj) {
                    estado = 'checkmark.png';
                    html += '<tr>';
                    html += '<td><input type="checkbox" /></td>';
                    //html += '<td>' + obj['id'] + '</td>';
                    html += '<td>' + obj['nombre'] + '</td>';
                    accion = obj['accion'];
                    if (obj['accion'] == '' || obj['accion'] == null) {
                        accion = '';
                    }
                    html += '<td>' + accion + '</td>';
                    
                    if (obj['estado'] == 0) {
                        estado = 'error.png';
                    }
                    
                    html += '<td width=8%><span style=display:none>';
                    html += obj['cbo_estado'] + '</span><img src='  + urls.siteUrl + '/img/' + estado + ' width=20%></td>';
                    url = obj['url'];
                    if (obj['url'] == '' || obj['url'] == null) {
                        url = '';
                    }
                    html += '<td>' + url + '</td>';
                    html += '</tr>';
 
        })
        
        html += '</tbody>';
        html += '</table>';
        html += '</div>';
        html += '</div>';
        
        $('.modal-body').append(html);
        $('#tablaRecurso').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"sDom": '<""l>t<"F"fp>'
	});
        $('.modal').css({'width':'950px','margin':'-250px 0 0 -420px'});
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
                            location.reload();
                       }
                   });
               }
            }
        })
        
    })
    
    $('#btnEliminar').click(function(){
        
        
       // $.post();
        
        $.ajax({
            url: urls.siteUrl + '/admin/mvc/operacion/ajax/delete',
            data:{id:codigo},
            //data: $("#form").serialize(),
            success: function(result){
              //  $('.modal-footer').prepend('<a class="alert" data-dismiss="alert" href="#">Registro grabado. &times;</a>');
                location.reload();
            }
        });
        
    })
  
})