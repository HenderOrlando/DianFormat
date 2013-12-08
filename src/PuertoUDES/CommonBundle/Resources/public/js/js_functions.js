/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
            var m = $('<div class="span2 alert alert-'+(type_alert)+' msg-json in"><button type="button" class="close" data-dismiss="alert">×</button>'+msg+'</div>');
            $(m).bind('closed.bs.alert', function () {
                if($('#mensajes').children().length <= 1)
                    hideMsg();
            });
            $('#mensajes').append(m);
            showMsg(m);
    	}
    	showMsg();
    }
    function showMsg(m){
        if(typeof $(m) !== 'undefined' && !$(m).hasClass('alert'))
            $(m).removeClass('out').addClass('animate in');
        else
            $('#mensajes').removeClass('out').addClass('animate in');
    }
    function hideMsg(m){
        if(typeof m !== 'undefined'){
            $(m).removeClass('in').addClass('out');
            $(m).find('.close').click();
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
        if($('.mensajes').length){
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
                        title:      placeholder
                    });
        });
        $('input:not([type="checkbox"]), textarea, select').each(function(){
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
        $('.carga-modal').on('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            var este = $(this), modal = $('#Modal');
            $.ajax({
                type: "POST",
                url: este.attr('href'),
                dataType: "json",
                cache: false
            }).done(function( response ) {
                $('#mTitle').html(response.title);
                $('#mBody').html(response.body);
                arreglaAjax();
                formAjax('#mBody');
                modal.modal('show');
                modal.on('hidden.bs.modal', function (e) {
                    $('#mTitle').html('Titulo');
                    $('#mBody').html('...');
                });
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
            });
        });
    }
    
    function formAjax(id){
        if(typeof id === 'undefined'){
            id = 'body';
        }
        var metodo = $('#mBody').find('input[name="_method"]').attr('value');
        if(metodo !== 'PUT')
            metodo = 'POST';
        $(id).find('form').on('submit', function(e){
            e.preventDefault();
            e.stopPropagation();
            var este = $(this);
            $.ajax({
                type: metodo,
                url: este.attr('action'),
                data: este.serializeArray(),
                dataType: "json",
                cache: false
            }).done(function( response ) {
                $('#mTitle').html(response.title);
                $('#mBody').html(response.body);
                if(response.datos)
                    validaDataName(response.datos);
                arreglaAjax();
                formAjax('#mBody');
            }).fail(function() {
                console.log( "error" );
            }).always(function() {
                console.log( "complete" );
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
                if(typeof response.values.datos !== 'undefined'){
                    console.log(response.datos);
                }
                if(response.status == 'error') 
                    return response.msg; //msg will be shown in editable form
                var msgs = new Array();
                if(typeof response.value !== 'undefined'){
                    $(este).text(response.value);
                }
                //Mensajes
                if(typeof response.msgs !== 'undefined'){
                    msgs = response.msgs;
                }else if(typeof response.values.msgs !== 'undefined'){
                    msgs = response.values.msgs;
                }else if(typeof response.msgs !== 'undefined'){
                    msgs = response.msgs;
                }
                //Datos
                if(typeof response.datos !== 'undefined'){
                    var datos = response.datos;
                }else if(typeof response.values.datos !== 'undefined'){
                    datos = response.values.datos;
                }
                if(typeof datos !== 'undefined'){
                    validaDataName(datos);
                }
                if(typeof response.id !== 'undefined'){
                    console.log(response.id);
                    este.attr('data-pk',response.id);
                    este.editable('option', 'pk', response.id);
                }
                for(var i in msgs)
                    if(msgs[i] !== '' && msgs[i] !== ' ')
                        addMsg(msgs[i]['msg'], msgs[i]['tipo']);
            }
        };
        if(este.attr('data-type') === 'typeaheadjs'){
            var prefetch = typeof este.attr('data-prefetch') !== 'undefined'?este.attr('data-prefetch').replace('"',''):{};
            $.extend(datos, {
                typeahead: {
                    name: este.attr('data-name'),
                    prefetch: prefetch,
                    ttl:    5000,
                    template: function(item) {
                        if(este.attr('data-entity-name') === 'usuario'){
                            var entidad = item.datos, usuario = entidad.usuario, lugar = entidad.lugar, ret = '<h5>'+usuario.nombre + ' NIT.' + usuario.doc_id+'</h5>';
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
                        else if(este.attr('data-name') === 'moneda'){
                            var moneda = item.datos, ret = '<h5>' + moneda.abreviacion + '</h5> <h6>' + moneda.nombre + '</h6>';
                            return ret;
                        }
                        return item.value; 
                    } 
                }
            });
        }
        $(este).editable(datos);
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
    
    function validaDataName(datos){
        for(var name in datos){
            if(datos[name] !== 'null'){
                var d = $('[data-name="'+name+'"]'), val = '';
                if(
                    name.indexOf('peso') > -1 || (name.indexOf('volumen') > -1 && datos[name] > 0) ||
                    name.indexOf('gastoRemitente') > -1 || name.indexOf('gastoDestinatario') > -1
                ){
                    val = datos[name];
                    d.text(val);
                }
            }
        }
    }