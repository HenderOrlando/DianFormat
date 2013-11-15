/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
var editable_index = new Array(), editable_object = new Array();

$(document).on('ready',function(){
    arreglaAjax();
    $('a.xeditable').each(function(i){
        var este = $(this), id = $(this).attr('id');
        addXEditable(este);
        editable_index[id] = i;
        editable_object[i] = este;
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
                var req = este.attr('data-required').split(','), 
                    msg = '',
                    valido = true, i=0;
                while(i < req.length){
                    if(i > 0)
                        msg += '\n';
                    switch(req[i]){
                        case 'Vacio':// No puede ser vacio
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
                if(msg.length && (msg.search(/^\n+$/) || msg.search(/^[\n\r\t\0\s]+$/))){
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
                    hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-emptytext')+"')"));
                    hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-entity-name')+"')"));
                    var str = este.attr('data-entity-name'),
                        f = str.charAt(0).toUpperCase();
                    hideMsg($("#mensajes .alert:contains('"+f+str.substr(1)+"')"));
                }
            });
        }
    }).on('save.formato', function(){
        var that = $(this);
        hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-emptytext')+"')"));
        hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-entity-name')+"')"));
        var str = $(this).attr('data-entity-name'),
            f = str.charAt(0).toUpperCase();
        hideMsg($("#mensajes .alert:contains('"+f+str.substr(1)+"')"));
        setTimeout(function() {
            var obj = editable_object[editable_index[that.attr('id')]+1];
            if(typeof obj !== 'undefined')
                obj.editable('show');
        }, 200);
    });
    
    $('.reset').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var este = $(this), 
        clase = 'a.'+este.attr('class').replace(/( {0,}btn|-default {0,})|reset {0,}|animate|in|out/g, '');
        $(clase).not('.btn')
            .editable('setValue', '')
            .editable('option', 'pk', '')
            .removeClass('editable-unsaved')
            .each(function(){
                hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-emptytext')+"')"));
                hideMsg($("#mensajes .alert:contains('"+$(this).attr('data-entity-name')+"')"));
                var str = $(this).attr('data-entity-name'),
                    f = str.charAt(0).toUpperCase();
                hideMsg($("#mensajes .alert:contains('"+f+str.substr(1)+"')"));
            });

        $('.guardar').removeClass('out').addClass('in');
        //$('#mensajes').hide();                
    });
    $('.guardar').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var este = $(this), 
        clase = 'a.'+este.attr('class').replace(/( {0,}btn|-primary {0,})|guardar {0,}|animate|in|out/g, '');
        $(clase).not('.btn').editable('submit', {
            url: este.attr('href'), 
            ajaxOptions: {
                type: 'post',
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
                    $(this).editable('option', 'pk', data.id);
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
                    $(clase+'.guardar').parent().removeClass('in').addClass('out');
                    $(this).off('save.formato');
                    este.parent().removeClass('in').addClass('out');
                } else if(data && data.errors){
                    var msg = '', errors = data.errors;
                    if(errors && errors.responseText) {
                        addMsg(errors.responseText, 'danger');
                    }else {
                        $.each(errors, function(k, v) {
                            addMsg(k+": "+v, 'danger');
                        });
                    }
                    if(msg.indexOf('<br>') !== false){
                    var msgs = msg.split('<br>');
                        for(var i in msgs)
                            if(msgs[i] !== '' && msgs[i] !== ' ')
                                addMsg(msgs[i], 'danger');
                    }
                    else
                        addMsg(msg, 'danger');
                    //server-side validation error, response like {"errors": {"username": "username already exist"} }
                    config.error.call(this, data.errors);
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
});