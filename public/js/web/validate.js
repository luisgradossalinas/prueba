function validarCampos(json){
    
    $("ul.error").remove();
    if(json == 'true'){
        return true;
    }
    $.each($.parseJSON(json), function(key,obj) {
        var errores = '';
        $.each(obj, function(error, mensaje){
            errores+= '<li class="'+error+'">'+mensaje+'</li>';
        });
        $('#'+key).after('<ul class="error">'+errores+'</ul>');
    });
    return false;
}