/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function _ajax_request(url, data, callback, type, method) {
    if (jQuery.isFunction(data)) {
        callback = data;
        data = {};
    }
    return jQuery.ajax({
        type: method,
        url: url,
        data: data,
        success: callback,
        dataType: type
        });
}

jQuery.extend({
    put: function(url, data, callback, type) {
        return _ajax_request(url, data, callback, type, 'PUT');
    },
    delete_: function(url, data, callback, type) {
        return _ajax_request(url, data, callback, type, 'DELETE');
    }
});
(function ($) {
    "use strict";
    
    var Constructor = function (options) {
        this.init('typeaheadjs', options, Constructor.defaults);
    };

    $.fn.editableutils.inherit(Constructor, $.fn.editabletypes.text);

    $.extend(Constructor.prototype, {
        render: function() {
            this.renderClear();
            this.setClass();
            this.setAttr('placeholder');
            this.$input.typeahead(this.options.typeahead);
            
            // copy `input-sm | input-lg` classes to placeholder input
            if($.fn.editableform.engine === 'bs3') {
                if(this.$input.hasClass('input-sm')) {
                    this.$input.siblings('input.tt-hint').addClass('input-sm');
                }
                if(this.$input.hasClass('input-lg')) {
                    this.$input.siblings('input.tt-hint').addClass('input-lg');
                }
            }
        }
    });      

    Constructor.defaults = $.extend({}, $.fn.editabletypes.list.defaults, {
        /**
        @property tpl 
        @default <input type="text">
        **/         
        tpl:'<input type="text">',
        /**
        Configuration of typeahead itself. 
        [Full list of options](https://github.com/twitter/typeahead.js#dataset).
        
        @property typeahead 
        @type object
        @default null
        **/
        typeahead: null,
        /**
        Whether to show `clear` button 
        
        @property clear 
        @type boolean
        @default true        
        **/
        clear: true
    });

    $.fn.editabletypes.typeaheadjs = Constructor;      
    
}(window.jQuery));

    var content = $('body'), 
        url_anterior = '',  
        marginTop = 0,
        original = window.location,
        new_height = 0,
        load_page = [],
        to_msg;
    function addMsg(msg, type_alert){
    	if(typeof type_alert === 'boolean'){
            type_alert = type_alert?'error':'success';
    	}
    	if(typeof type_alert === 'undefined'){
            type_alert = 'info';
    	}
    	if(typeof msg !== 'undefined'){
            var m = $('<div class="span2 alert alert-'+(type_alert)+' msg-json animate out"><button type="button" class="close" data-dismiss="alert">×</button>'+msg+'</div>');
            $(m).bind('closed.bs.alert', function () {
                if($('#mensajes').children().length <= 1)
                    hideMsg();
            });
            $('#mensajes').prepend(m);
            setTimeout(function(){
                m.find('.close').click();
            },30*1000);
            showMsg(m);
    	}
    	showMsg();
    }
    function showMsg(m){
        if(typeof $(m) !== 'undefined' && $(m).hasClass('alert'))
            $(m).removeClass('out').addClass('animate in');
        else{
            $('#mensajes').removeClass('out').addClass('animate in');
        }
    }
    function hideMsg(m){
        if(typeof m !== 'undefined'){
            $(m).removeClass('in').addClass('out');
//            $(m).find('.close').click();
        }
        else
            $('#mensajes').removeClass('in').addClass('out');
    }
    
    /*
     * Arregla Ajax
     */
    function arreglaAjax(){
        if(Modernizr.fontface){
            $('button.glyphicon').text('');
        }
        $('.mensajes').children().appendTo('#mensajes');
        if($('form.inputBig').length){
            $('form.inputBig').find('input, textarea, select').addClass('input-lg');
        }
        if($('form.inputFull').length){
            $('form.inputFull')
                    .find('input, textarea, select')
                    .addClass('col-lg-10 col-md-10 col-lg-offset-1 col-md-offset-1');
        }
        if($('#mensajes').length){
            $('#mensajes')
                .addClass('animate in')
                .children()
                    .addClass('animate in')
                .end()
                .find('.close').on('click', function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).parent()
                        .removeClass('in')
                        .addClass('out');
                    var alert = $(this).parent();
                    setTimeout(function(){alert.remove()}, 500);
                }).end().find('a').addClass('alert-link');
        }
        
        $('label').each(function(){
            var id = $(this).attr('for'), placeholder = $(this).text().replace(':','');
            id = $(this).attr('for');
            $('input#'+id+':not([type="checkbox"]), textarea#'+id)
                    .attr('placeholder',placeholder)
                    .tooltip({
                        placement:  "right",
                        trigger:    "focus",
                        title:      placeholder,
                        container:  'body',
                    });
        });
        $('input:not([type="checkbox"]), textarea').each(function(){
            if(typeof $(this).parent().attr('id') !== 'undefined'){
                if($(this).parent().attr('id').indexOf('time') || $(this).parent().attr('id').indexOf('date')){
                    $(this).parent().parent().addClass('form-inline');
                    $(this).parent().addClass('form-group');
                    $(this).css({width:'auto'});
                }
            }
            $(this).addClass('form-control');
        });
        $('button,input:button,input:submit,input:reset').each(function(){
            $(this).removeClass('form-control');
            $(this).addClass('btn');
            var text = $(this).text().length > 0?$(this).text().toLowerCase():'', 
                type = typeof $(this).attr('type') !== 'undefined'?$(this).attr('type').toLowerCase():'', 
                value = typeof $(this).attr('value') !== 'undefined'?$(this).attr('value').toLowerCase():'';
            if(typeof $(this).attr('type') !== 'undefined'){
                if(type.indexOf('submit') >= 0){
                    if(text.indexOf('borrar')  >= 0 || text.indexOf('delete') >= 0){
                        $(this).addClass('btn-danger');
                    }
                    else if(text.indexOf('create') >= 0  || text.indexOf('guardar') >= 0 || text.indexOf('actualizar') >= 0 || text.indexOf('update') >= 0 || value.indexOf('update') >= 0 || value.indexOf('guardar') >= 0 || value.indexOf('actualizar') >= 0 || value.indexOf('create') >= 0)
                        $(this).addClass('btn-success');
                }
                else if(type.indexOf('reset') >= 0 || text.indexOf('limpiar') >= 0)
                    $(this).addClass('btn-warning');
            }
            $(this).parents('form').addClass('animate in');
        });
        if(!Modernizr.input.placeholder){
            $('[placeholder]')
                .focus(function() { 
                   var input = $(this); 
                   if (input.val() === input.attr('placeholder')) { 
                       input.val(''); 
                       input.removeClass('placeholder'); 
                  } 
                })
                .blur(function() { 
                     var input = $(this); 
                     if (input.val() === '' || input.val() === input.attr('placeholder')) { 
                         input.addClass('placeholder'); 
                         input.val(input.attr('placeholder')); 
                     } 
                })
                .blur(); 
                $('[placeholder]').parents('form').submit(function() {
                    $(this).find('[placeholder]').each(function() { 
                    var input = $(this); 
                    if (input.val() === input.attr('placeholder')) { 
                       input.val(''); 
                    } 
                });
            });
        }else{
            $('label').each(function(){
                id = $(this).attr('for');
                if($('input#'+id+':not([type="checkbox"]), textarea#'+id).length){
                    $(this).hide();
                }
            });
        };
    }
    
    function formAjax(id){
        if(typeof id === 'undefined'){
            id = 'body';
        }
        $(id).find('form').each(function(){
            var este = $(this);
            este.on('submit', function(e){
                var metodo = este.find('input[name="_method"]').attr('value');
                var data = este.serializeArray();
                console.log(metodo)
                if(typeof metodo === 'undefined')
                    metodo = 'POST';
//                if(metodo === 'PUT' || metodo === 'DELETE'){
//                    data._method = metodo;
//                    metodo = 'POST';
//                }
                e.preventDefault();
                e.stopPropagation();
                $.ajax({
                    type: metodo,
                    url: este.attr('action'),
                    data: data,
                    dataType: "json",
                    cache: false
                }).done(function( response ) {
                    $('#mTitle').html(response.title);
                    $('#mBody').html(response.body);
                    if(response.datos)
                        validaDataName(response.datos);
                    armarModal(response);
                }).fail(function() {
                    console.log( "error formAjax" );
                }).always(function() {
                    console.log( "complete" );
                });
            });
        });
    }
    /*SUCCESS Y ERROR*/
//success: function(data, config) {
//    if(data && data.id) {  //record created, response like {"id": 2}
//        //set pk
//        $(this).editable('option', 'pk', data.id);
//        //remove unsaved class
//        $(this).removeClass('editable-unsaved');
//        //show messages
//        var msg = 'New user created! Now editables submit individually.';
//        $('#msg').addClass('alert-success').removeClass('alert-error').html(msg).show();
//        $('#save-btn').hide(); 
//        $(this).off('save.newuser');                     
//    } else if(data && data.errors){ 
//        //server-side validation error, response like {"errors": {"username": "username already exist"} }
//        config.error.call(this, data.errors);
//    }               
//},
//error: function(errors) {
//    var msg = '';
//    if(errors && errors.responseText) { //ajax error, errors = xhr object
//        msg = errors.responseText;
//    } else { //validation error (client-side or server-side)
//        $.each(errors, function(k, v) { msg += k+": "+v+"<br>"; });
//    } 
//    $('#msg').removeClass('alert-success').addClass('alert-error').html(msg).show();
//}
            /*SUCCESS Y ERROR*/
            
    /* addXEditable
     * Mostrar siguiente editable----
        automatically show next editable
            $(este).on('save.newuser', function(){
                var that = this;
                setTimeout(function() {
                    $(that).closest('tr').next().find('.myeditable').editable('show');
            }, 200);
        });----
     * Hacer username requerido----
        $('#new_username').editable('option', 'validate', function(v) {
            if(!v) return 'Required field!';
        });
     * Botón Reset----
     *   $('#reset-btn').click(function() {
     *       $('.myeditable').editable('setValue', null)  //clear values
     *           .editable('option', 'pk', null)          //clear pk
     *           .removeClass('editable-unsaved');        //remove bold css
     *       $('#save-btn').show();
     *       $('#msg').hide();                
     *   });
     * 
     * @param jquery|string este Objeto JQuery o Nombre del objeto dónde aplicar el xeditable
     * @returns {undefined}
     */
    function addXEditable(este){
        var datos = {
            /*si es textarea*/
            rows: 3,
            onblur:   'cancel',
//            source: '/groups',
            ajaxOptions: {
                type: 'put',
                dataType: 'json'
            },
            params: function(params) {
                return getParamsXEditable(params, este);
            },
            success: function(response, val) {
                if(response.status == 'error') 
                    return response.msg; //msg will be shown in editable form
                var msgs = new Array(), ok = true;
                if(typeof response.value !== 'undefined'){
                    $(este).text(response.value);
                }
                //Mensajes
                if(typeof response.msgs !== 'undefined'){
                    msgs = response.msgs;
                }else if(typeof response.values !== 'undefined' && typeof response.values.msgs !== 'undefined'){
                    msgs = response.values.msgs;
                }
                //Datos
                if(typeof response.datos !== 'undefined'){
                    var datos = response.datos;
                }else if(typeof response.values !== 'undefined' && typeof response.values.datos !== 'undefined'){
                    datos = response.values.datos;
                }
                if(typeof datos !== 'undefined'){
                    validaDataName(datos, getClase(este.attr('class')));
                }
                if(typeof response.id !== 'undefined'){
                    console.log(response.id);
                    este.attr('data-pk',response.id);
                    este.editable('option', 'pk', response.id);
                }
                for(var i in msgs){
                    if(typeof msgs[i]['tipo'] === 'undefined')
                        msgs[i]['tipo'] = 'warning';
                    if(typeof msgs[i]['msg'] !== 'undefined')
                        addMsg(msgs[i]['msg'], msgs[i]['tipo']);
                    if(msgs[i]['tipo'] === 'danger')
                        ok = false;
                }
                if(ok){
//                    console.log(val);
//                    console.log(datos);
                }
                return ok;
            }
        };
        if(este.attr('data-type') === 'typeaheadjs'){
            var prefetch = typeof este.attr('data-prefetch') !== 'undefined'?este.attr('data-prefetch').replace('"',''):{},
                datosTypeahead = {
                    name: este.attr('data-entity-name') + '_' + este.attr('data-name'),
                    prefetch: {
                        url: prefetch,
                        ttl: '0'
                    },
                    limit:  10,
                    template: function(item) {
                        if(typeof item.datos.usuario !== 'undefined'){
                            var entidad = item.datos, usuario = entidad.usuario, 
                                lugar = entidad.lugar,
                                ret = '<h5>'+usuario.nombre + (typeof usuario.apellido !== 'undefined'?' '+usuario.apellido+' ':'') + ' NIT.' + usuario.doc_id+'</h5>';
                            if(este.attr('data-name') === 'lugar' && typeof lugar['nombre'] !== 'undefined')
                                ret += '<p>'+lugar.nombre+', '+lugar.pais.nombre+'</p>';
                            else if(typeof entidad[este.attr('data-name')] === 'undefined'){
                                if(este.attr('data-name') !== 'nombre' && este.attr('data-name') !== 'docId' && typeof entidad[este.attr('data-name')] !== 'undefined'){
                                    ret += '<p>'+usuario[este.attr('data-name')]+'</p>';
                                }
                            }else if(typeof entidad[este.attr('data-name')] !== 'undefined')
                                ret += '<p>'+entidad[este.attr('data-name')]+'</p>';
                            return ret;
                        }
                        else if(item.datos.tipo){
                            var formato = item.datos, 
                                ret = '<h5>' + formato.tipo.nombre + '</h5> <h6>' + formato.fullNombre + '</h6>';
                            return ret;
                        }
                        else if(este.attr('data-name') === 'moneda'){
                            var moneda = item.datos, 
                                ret = '<h5>' + moneda.abreviacion + '</h5> <h6>' + moneda.nombre + '</h6>';
                            return ret;
                        }
                        else if(este.attr('data-entity-name') === 'vehiculo' || este.attr('data-entity-name') === 'unidadCarga' || este.attr('data-entity-name') === 'otraUnidadCarga'){
                            var vehiculo = item.datos, 
                                ret = '<h5>' + vehiculo.placa + '</h5> <h6>' + (typeof vehiculo.numeroSerieChasis === 'undefined'?vehiculo.marca:vehiculo.numeroSerieChasis) + '</h6>';
                            if(typeof vehiculo.placa === 'undefined'){
                                ret = '<h5>' + vehiculo.nombre + '</h5>';
                            }
                            else if(typeof vehiculo[este.attr('data-name')] !== 'undefined' && este.attr('data-name') !== 'placa' && este.attr('data-name') !== 'chasis'){
                                if(este.attr('data-name') === 'pais')
                                    ret += '<p>' + vehiculo['pais'].nombre + '</p>';
                                else
                                    ret += '<p>' + vehiculo[este.attr('data-name')] + '</p>';
                            }
                            return ret;
                        }
                        return '<h5>' + item.value + '</h5>'; 
                    }
                };
            if(typeof este.attr('data-multiple') !== 'undefined'){
                datosTypeahead =$.extend(datosTypeahead,{
                    updater: function(item) {
                        return this.$element.val().replace(/[^,]*$/,'')+item+',';
                    },
                    matcher: function (item) {
                      var tquery = extractor(this.query);
                      if(!tquery) return false;
                      return ~item.toLowerCase().indexOf(tquery.toLowerCase());
                    },
                    highlighter: function (item) {

                      var query = extractor(this.query).replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&');
                      return item.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
                        return '<strong>' + match + '</strong>';
                      });
                    }
                });
            }
            if(localStorage){
                localStorage.clear();
            }
            $.extend(datos, {
                typeahead: datosTypeahead
            });
        }
        $(este).editable(datos);
    }
    function extractor(query) {
        var result = /([^,]+)$/.exec(query);
        if(result && result[1])
            return result[1].trim();
        return '';
    }
    /*
     * 
     */
    function getParamsXEditable(params, este){
        if(typeof este.attr('data-entity-name') !== 'undefined')
            params.entity = este.attr('data-entity-name');
        if(typeof este.attr('data-entity-bundle') !== 'undefined')
            params.bundle = este.attr('data-entity-bundle');
        if(este.hasClass(este.attr('class').replace(/( ?xeditable ?)|( ?fin ?)|( ?editable-click ?)|( ?editable-open ?)|( ?editable ?)/g,''))){
            params.save = este.attr('class').replace(/( ?xeditable ?)|( ?fin ?)|( ?editable-click ?)|( ?editable-open ?)|( ?editable ?)/g,'');
        }
        else
            params.save = false;
        return params;
    }
    
    /*Popover
     * 
     * @param string popoverClass Nombre de la Clase para hacer popover
     */
    function popover(popoverClass){
        if(!popoverClass)
            popoverClass = '.popover-class';
        $(popoverClass).each(function(){
                $(this).find('.popover-trigger').each(function(i,v){
                var trigger = $(this).children();
                var popover = $(this).siblings('.popover-context');
                trigger.attr('title', popover.find('.title').html());
                trigger.attr('data-content', popover.find('.content').html());
                trigger.attr('data-toggle', 'popover');

                trigger.popover({
                        trigger:	"manual",
                        html:		true,
                        placement:i>2?'left':'right'
                });
                trigger.on({
                        mouseover: function(e){
                                trigger.popover('show');
                                trigger.siblings('.popover').addClass('span6');
                                trigger.popover('show');
                                e.preventDefault();
                        },
                        mouseout: function(e){
                                trigger.popover('hide');
                                e.preventDefault();
                        }
                });
            });
        });
    }
    
    /*
     * Get Total Width
     * 
     * @param obj      Objeto Jquery   Objeto a calcular el width
     * @param width    Boolean         Si suma el ancho
     * @param pading   Boolean         Si suma el padding
     * @param margin   Boolean         Si suma el margin
     */
    function getTotalWidth(obj, width, padding, margin){
        var w = 0;
        if(width === undefined || width){
            w += obj.width();
        }
        if(padding === undefined || padding){
            w += parseInt(obj.css('padding-left'))+parseInt(obj.css('padding-right'));
        }
        if(margin === undefined || margin){
            w += parseInt(obj.css('margin-left'))+parseInt(obj.css('margin-right'));
        }
        return w;
    }
    
    function imgIsometrico(){
        var w = $('.img-isometrico').parent().width();
        $('.img-isometrico img').width(w);
        $('.img-isometrico img').height(w*0.75);
    }
    
    function validateNoVacio(value){
        return value.search(/^$/) >= 0 || value.search(/^ $/) >= 0?false:true;
    }
    function validateLetras(value){
        return value.search(/^[\-\Da-zA-z\s]+$/) >= 0?true:false;
    }
    function validateNumeros(value){
        return value.search(/^[\-0-9\s]+$/) >= 0?true:false;
    }
    function validateConectores(value){
        return value.search(/^[\s.,:;\-\_\{\}\(\)\[\]´´+*¿¡'\?=\/\\&%$#"\¡!|@<>°]+$/) >= 0?true:false;
    }
    function validateNumerosLetras(value){
        return value.search(/^[\-\d\w\s]+$/) >= 0?true:false;
    }
    function validateNumerosConectores(value){
        return value.search(/^[0-9\s.,:;\-\_\{\}\(\)\[\]´´+*¿¡'\?=\/\\&%$#"\¡!|@<>°]+$/) >= 0?true:false;
    }
    function validateLetrasConectores(value){
        return value.search(/^[\Da-zA-z\s.,:;\-\_\{\}\(\)\[\]´´+*¿¡'\?=\/\\&%$#"\¡!|@<>°]+$/) >= 0?true:false;
    }
    function validateNumerosLetrasConectores(value){
        return value.search(/^([\D\d\w\s.,:;\-\_\{\}\(\)\[\]´´+*¿¡'\?=\/\\&%$#"\¡!|@<>°])+$/) >= 0?true:false;
    }
    function validateEmail(value){
        return value.search(/(^$|^.*@.*\..*$)/) >= 0?true:false;
    }
    
    function loadModal(id){
        if(typeof id === 'undefined')
            id = '#Modal';
        $(id).modal({
            show:  false
         });
    }
    
    function validaDataName(datos,clase){
        if(typeof clase === 'undefined' || clase.indexOf('remitente') > -1 || clase.indexOf('destinatario') > -1)
            clase = '';
        else
            clase = '.'+clase;
        for(var name in datos){
            if(datos[name] !== 'null'){
                var d = $(clase+'[data-name="'+name+'"]'), val = '';
                if(name.indexOf('total') > -1){
                    clase = '';
                    var d = $('[data-name="'+name+'"]'), 
                        x = name.replace('totalP','p').replace('totalV','v'), 
                        val = 0;
                    $('[data-name="'+x+'"]').each(function(){
                        val += $(this).text()*1;
                    });
                    d.text(val.toFixed(4));
                }
                else if(
                    name.indexOf('peso') > -1 || (name.indexOf('volumen') > -1 && datos[name] > 0) ||
                    name.indexOf('gastoRemitente') > -1 || name.indexOf('gastoDestinatario') > -1
                ){
                    val = datos[name];
                    d.text(val);
                }
            }
        }
    }
    
    function getClase(clase){
        return clase.replace(/btn|-primary|-default|xeditable|editable-open|editable-click|editable|agregar|guardar|eliminar|reset|-warning|-danger|-success|animate|^in[^\S]|\sin[^\S]|in$|^out[^\S]|\sout|out$|pull-right|pull-left|\s/g, '')
    }
    
    function armarModal(response){
        cleanModal();
        if(typeof response.body !== 'undefined' && typeof response.title !== 'undefined'){
            var modal = $('#Modal')
            $('#mTitle').html(response.title);
            $('#mBody').html(response.body);
            arreglaAjax();
            if($('#mBody').find('btn').length > 0 || $('#mBody').find('input').length > 0){
                $('#mBody').find('.btn, input:button, input:submit, input:reset, button').each(function(){
                    var este = $(this), btn = $('<div></div>').attr('class', este.attr('class')), action = 'guardar';
                    console.log(este.text())
                    if(este.text().toLowerCase().indexOf('delete') >= 0){
                        btn.text('Borrar');
                        action = 'borrar';
                    }else if(este.text().toLowerCase().indexOf('Update') >= 0){
                        btn.text('Actualizar')
                    }else if(este.text().toLowerCase().indexOf('Create') >= 0){
                        btn.text('Crear')
                    }else{
                        btn.text('Guardar');
                    }
                    btn.addClass('btn-add-foot-modal');
//                    btn.text(este.text());
                    este.hide()
                    btn.on('click',function(){
                        este.click();
//                        modal.find('.close.btn').click();
                    });
                    $('#mFooter > .btn-group').prepend(btn);
                });
            }
            if(typeof response.ajaxForm === 'undefined'){
                formAjax('#mBody');
            }
            $('select').select2();
            modal.modal('show');
            modal.on('hidden.bs.modal', function (e) {
                cleanModal();
            });
        }
    }
    function cleanModal(modal){
        if(typeof modal === 'undefined'){
            modal = '';
        }
        $('#mTitle').html('Titulo');
        $('#mBody').html('...');
        $('#mFooter').find('.btn-add-foot-modal').remove();
    }