function validarCampos(json){
    
    $("ul.error").remove();
    if(json == 'true'){
        return true;
    }
    $.each($.parseJSON(json), function(key,obj) {
        var errores = '';
        var len_mensaje = 0;
        $.each(obj, function(error, mensaje){
            
            //errores+= '<li class="'+error+'">'+mensaje+'</li>';
            errores+= '<li style="display: inline;font-size:8pt;width:50px" class="'+error+'">'+mensaje+'</li>';
            //<a  href="'..'/'.$hijo['url'].'" title="'.$hijo['accion'].'" class="tip-bottom">'.$hijo['nombre'].'</a>
            //enlace = '<a href="#" class="tip-bottom" title="' + mensaje + '">Error</a>';
           // errores+= '<li style="display: inline;font-size:8pt" class="'+error+'">'+ errores +'</li>';
           len_mensaje += mensaje.length;
        });
        
        style = '';
        if (len_mensaje < 20) {
            style = 'float: right;';
        }
        
        
        $('#'+key).after('<ul class="error" style="' + style + '">'+errores+'</ul>');
    });
    return false;
}