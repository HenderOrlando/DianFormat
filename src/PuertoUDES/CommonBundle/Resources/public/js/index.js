/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var editable_index = new Array(), editable_object = new Array();

$(document).on('ready',function(){
    var i_xeditable = -1;
    arreglaAjax();
    agregarXEditable();
    botonResetXEditable();
    botonGuardarXEditable();
    botonEliminarXEditable();
    loadModal();
    function agregarXEditable(xeditable){
        if(typeof xeditable === 'undefined')
            xeditable = 'a.xeditable';
        $(xeditable).each(function(){
            i_xeditable++;
            var este = $(this), id = $(this).attr('id');
            addXEditable(este);
            editable_index[id] = i_xeditable;
            editable_object[i_xeditable] = este;
            if(este.attr('data-type') === 'typeaheadjs'){
                este.editable('option','typeshead',{
                        name: este.attr('data-name'),
                        prefetch: este.attr('data-prefetch'),
                        template: function(item) {
                            return item.tokens[0] + ' (' + item.value + ')'; 
                        } 
                });
            }
            if(typeof este.attr('data-required') !== 'undefined'){
                este.editable('option', 'validate', function(v) {
                    if(typeof v !== 'object'){
                        var req = este.attr('data-required').split(','), 
                            msg = '',
                            valido = true, i=0;
                        while(i < req.length){
                            if(i > 0)
                                msg += '\n';
                            switch(req[i]){
                                case 'Vacio':// Puede ser vacio
                                    valido = !validateNoVacio(v);
                                    if(valido)
                                        return;
                                    break;
                                case 'NoVacio':// No puede ser vacio
                                    valido = validateNoVacio(v);
                                    if(!valido)
                                        msg = 'No puede ser vacío';
                                    break;
                                case 'Letras'://Contiene sólo Letras
                                    valido = validateLetras(v);
                                    if(!valido)
                                        msg += 'Acepta sólo letras y espacio';
                                    break;
                                case 'Numeros'://Contiene sólo Números
                                    valido = validateNumeros(v);
                                    if(!valido)
                                        msg += 'Acepta sólo Números y espacio';
                                    break;
                                case 'Conectores'://Contiene sólo Caracteres especiales permitidos
                                    valido = validateConectores(v);
                                    if(!valido)
                                        msg += 'Acepta caracteres de escritura y espacio';
                                    break;
                                case 'NumerosLetras'://Contiene sólo Números y Letras
                                    valido = validateNumerosLetras(v);
                                    if(!valido)
                                        msg += 'Acepta sólo números, letras y espacio';
                                    break;
                                case 'NumerosConectores'://Contiene sólo Números y caracteres de escritura
                                    valido = validateNumerosConectores(v);
                                    if(!valido)
                                        msg += 'Acepta sólo números, caracteres de escritura y espacio';
                                    break;
                                case 'LetrasConectores'://Contiene sólo Letras y caracteres de escritura
                                    valido = validateLetrasConectores(v);
                                    if(!valido)
                                        msg += 'Acepta sólo letras, caracteres de escritura y espacio';
                                    break;
                                case 'NumerosLetrasConectores'://Contiene sólo Números, Letras y Caracteres especiales permitidos
                                    valido = validateNumerosLetrasConectores(v);
                                    if(!valido)
                                        msg += 'Acepta sólo números, letras, caracteres de escritura y espacio';
                                    break;
                                case 'Email'://Contiene Email
                                    valido = validateConectores(v);
                                    if(!valido)
                                        msg += 'Email no válido';
                                    break;
                                default:
                                    valido = false;
                                    break;
                            }
                            i++;
                        }
                    }
                    if(typeof msg !== "undefined" && msg.length && (msg.search(/^\n+$/) || msg.search(/^[\n\r\t\0\s]+$/))){
                        var name = este.attr('data-emptytext');
                        if(msg.indexOf('\n') !== false){
                            var msgs = msg.split('\n');
                                for(var i in msgs)
                                    if(msgs[i] !== '' && msgs[i] !== ' ')
                                        addMsg(name+': '+msgs[i], 'danger');
                        }
                        else
                            addMsg(name+': '+msg, 'danger');
                        return ' ';
                    }else{
//                        hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-emptytext')+"')"));
//                        hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-entity-name')+"')"));
//                        var str = este.attr('data-entity-name'),
//                            f = str.charAt(0).toUpperCase();
//                        hideMsg($("#mensajes .alert:contains('"+f+str.substr(1)+"')"));
                    }
                    if(typeof v === 'object'){
                        console.log(v)
                        console.log(v.getUTCDate())
                        console.log(v.getUTCFullYear())
                        console.log(v.getUTCMonth())
                        console.log(v.toUTCString())
                    }
                });
            }
        }).on('save.formato', function(){
            var that = $(this);
//            hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-emptytext')+"')"));
//            hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-entity-name')+"')"));
//            var str = $(this).attr('data-entity-name'),
//                f = str.charAt(0).toUpperCase();
//            hideMsg($("#mensajes .alert:contains('"+f+str.substr(1)+"')"));
            setTimeout(function() {
                var obj = editable_object[editable_index[that.attr('id')]+1];
                if(typeof obj !== 'undefined')
                    obj.editable('show');
            }, 200);
        });
    }
    
    function botonGuardarXEditable(guardar){
        if(typeof guardar === 'undefined'){
            guardar = '.guardar';
        }
        $(guardar).click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var este = $(this), 
            clase = 'a.'+getClase(este.attr('class'));
            $(clase).not('.btn').editable('submit', {
                url: este.attr('href'), 
                ajaxOptions: {
                    type: 'PUT',
                    dataType: 'json'
                },
                success: function(data, config) {
                    $(this).each(function(){
                        hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-emptytext')+"')"));
                        hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-entity-name')+"')"));
                        var str = $(this).attr('data-entity-name'),
                            f = str.charAt(0).toUpperCase();
                        hideMsg($("#mensajes .alert:contains('"+f+str.substr(1)+"')"));
                    });
                    if(data && data.id) {
                        $(this).removeClass('editable-unsaved');
                        var success = data.success;
                        if(success && typeof success.msg !== 'undefined') {
                            addMsg(success.msg, success.tipo);
                        } else {
                            $.each(success.msgs, function(k, v) {
                                if(v.msg.search(/[\d\s]/))
                                    addMsg(k+": "+v.msg, v.tipo);
                            });
                        }
                        if(typeof data.url !== 'undefined'){
                            $(clase+'.carga-modal').attr('href',data.url).removeClass('out').addClass('in')
                        }
                        if(data.datos){
                            validaDataName(data.datos, clase);
                        }
                        $(clase+'.guardar').removeClass('in').addClass('out');
                        if(clase.search('carga') > 0 && clase.search('otra') < 0 ){
                            clase = clase+', a.carga-crear';
                            $('a.carga-crear.guardar').parent().removeClass('in').addClass('out');
                        }
                        $(clase).not('.btn')
                                .editable('option', 'pk', data.id);
//                        $(this).off('save.formato');
//                        if(!este.parent().hasClass('no-quitar'))
//                            este.parent().removeClass('in').addClass('out');
                    }else if(data && (data.errors || data.msgs || data.valores.msgs || data.success)){
                        var errors = data.errors;
                        if(errors) {
                            if(errors.responseText)
                                addMsg(errors.responseText, 'danger');
                            else {
                                $.each(errors, function(k, v) {
                                    addMsg(k+": "+v, 'danger');
                                });
                            }
                        }else{
                            var success = data.success;
                            if(typeof success.msg === 'undefined' || typeof success.msgs === 'undefined'){
                                success = data;
                            }
                            if (typeof success.msg === 'undefined' || typeof success.msgs === 'undefined'){
                                success = data.valores;
                            }
                            if(success && typeof success.msg !== 'undefined') {
                                addMsg(success.msg, success.tipo);
                            } else if (typeof success.msgs !== 'undefined'){
                                $.each(success.msgs, function(k, v) {
                                    if(v.msg.search(/[\d\s]/))
                                        addMsg(k+": "+v.msg, v.tipo);
                                });
                            }
                        }
                        config.error.call(this, errors);
                    }               
                },
                error: function(errors) {
                    if(errors && errors.responseText) {
                        if(errors.responseText.search(/[\d\s]/))
                            addMsg(errors.responseText, 'danger');
                    } else {
                        $.each(errors, function(k, v) {
                            if(typeof v === 'string' && v.search(/[\d\s]/))
                                addMsg(k+": "+v, 'danger');
    //                        else
    //                            addMsg(k+": "+v, 'danger');
                        });
                    }
                }
            });
        });
    }
    function botonResetXEditable(reset){
        if(typeof reset === 'undefined')
            reset = '.reset';
        $(reset).click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var este = $(this), 
            clase = 'a.'+getClase(este.attr('class'));
            var obj = $(clase).not('.btn').first(), pk = obj.attr('data-pk');
            $(clase).not('.btn')
                .attr('data-pk',' ')
                .editable('setValue', '')
                .editable('option', 'pk', ' ')
                .removeClass('editable-unsaved')
                .each(function(){
                    hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-emptytext')+"')"));
                    hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-entity-name')+"')"));
                    var str = $(this).attr('data-entity-name'),
                        f = str.charAt(0).toUpperCase();
                    hideMsg($("#mensajes .alert:contains('"+f+str.substr(1)+"')"));
                });
            $(clase+'.guardar').removeClass('out').addClass('in');
            $.ajax({
                type: "DELETE",
                url: este.attr('href'),
                data:{pk: pk, entity: obj.attr('data-entity-name'), bundle: obj.attr('data-entity-bundle')},
                dataType: "json",
                cache: false
            }).done(function( data ) {
//                console.log(data)
                var msgs = data.msgs;
                if(msgs) {
                    if(msgs.responseText)
                        addMsg(msgs.responseText, msgs.tipo);
                    else {
                        $.each(msgs, function(k, v) {
                            addMsg(k+": "+v.msg, v.tipo);
                        });
                    }
                }
                if(data.datos){
                    validaDataName(data.datos, clase);
                }
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
            });
        });
    }
    
    function botonEliminarXEditable(eliminar){
        if(typeof eliminar === 'undefined')
            eliminar = '.eliminar';
        $(eliminar).each(function(){
            var este = $(this),
                classname = getClase(este.attr('class')),
                id = '#'+classname,
                numChildren = $(id).parent().children().length;
            if(numChildren <= 1){
                $(id).parent().children().find('.eliminar').removeClass('in').addClass('out');
            }else{
                $(id).parent().children().find('.eliminar').removeClass('out').addClass('in');
            }
            este.on('click', function(){
                var numChildren = $(id).parent().children().length-1,
                    pk = $('a.'+classname).not('.btn').first().attr('data-pk');
                if(numChildren <= 1){
                    $(id).parent().children().find('.eliminar').removeClass('in').addClass('out');
                }else{
                    $(id).parent().children().find('.eliminar').removeClass('out').addClass('in');
                }
                if(pk !== ' ')
                    este.siblings('.reset').click();
                $(id).animate({opacity: 0, height: 0}, function(){
                    $(id).remove();
                });
            });
        });
    }
    
    /*AGREGAR FILA DE CPIC EN MCI*/
    $('a.agregar-cpic').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var este = $(this);
        este.attr('disabled',true);
        $.ajax({
            type: "POST",
            url: este.attr('href'),
            data:{filas: $('#cpics tbody tr').length},
            dataType: "html",
            cache: false
        }).done(function( response ) {
            $('#cpics tbody').append(response);
            arreglaAjax();
            agregarXEditable($('#cpics tbody').find('a.xeditable'));
            botonResetXEditable($('#cpics tbody').find('.reset'));
//            botonGuardarXEditable($('#cpics tbody').find('.guardar'));
            botonGuardarXEditable($('#cpics tbody').find('.guardar'));
            botonEliminarXEditable($('#cpics tbody').find('.eliminar'));
            este.removeAttr('disabled');
        }).fail(function() {
            console.log( "error" );
        }).always(function() {
            console.log( "complete" );
        });
    });
    $('a.agregar').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        var este = $(this),
            clase = getClase(este.attr('class')),
            id = $('#'+clase),
            numChildren = id.children().length;
        console.log(clase)
        este.attr('disabled',true);
        $.ajax({
            type: "POST",
            url: este.attr('href'),
            data:{filas: numChildren},
            cache: false
        }).done(function( response ) {
            if(typeof response.errors === 'undefined'){
                id.append(response);
                arreglaAjax();
                agregarXEditable(id.find('a.xeditable'));
                botonResetXEditable(id.find('.reset'));
                botonGuardarXEditable(id.find('.guardar'));
                botonEliminarXEditable(id.find('.eliminar'));
            }else{
                var msgs = response.errors;
                if(msgs.responseText)
                    addMsg(msgs.responseText, 'danger');
                else {
                    $.each(msgs, function(k, v) {
                        addMsg(k+": "+v, 'danger');
                    });
                }
            }
            este.removeAttr('disabled');
        }).fail(function() {
            console.log( "error" );
        }).always(function() {
            console.log( "complete" );
        });
    });
});