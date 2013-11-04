/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

    var content = $('body'), 
        url_anterior = '',  
        marginTop = 0,
        original = window.location,
        new_height = 0,
        load_page = [],
        to_msg;
    function clearTimeMsg(){
    	window.clearTimeout(to_msg);
    }
    function startTimeMsg(time){
    	clearTimeMsg();
    	if(typeof time === 'undefined'){
    		time = 6;
    	}
    	to_msg = setTimeout(function(){
    		$(".mensajes .alert").slideUp();
    		$(".mensajes").stop().animate({opacity: 0}, function(){
		    	$(".mensajes .alert").remove();
		    });
	    },time*1000);
    }
    function addMsg(msg, type_alert){
    	clearTimeMsg();
    	if(typeof type_alert === 'boolean'){
    		type_alert = type_alert?'error':'success';
    	}
    	if(typeof type_alert === 'undefined'){
    		type_alert = 'info';
    	}
    	if(typeof msg !== 'undefined'){
    		var m = $('<span class="span2 alert alert-'+(type_alert)+' msg-json"><button type="button" class="close" data-dismiss="alert">×</button>'+msg+'</span>').hide();
    		$('.mensajes').append(m);
    	}
    	showMsg();
    }
    function showMsg(){
    	$('.mensajes').css({display: 'block'}).stop().animate({opacity: 1, 'margin-top': 0}, function(){
    		$(".mensajes .alert").slideDown('slow');
    	});
    	startTimeMsg();
    }
    function hideMsg(){
    	$('.mensajes').stop().animate({opacity: 0, 'margin-top': '-140px'}, function(){
    		$(".mensajes").css({display: 'none'});
    		$(".mensajes .alert").remove();
    	});
    }
    
    /*
     * Arregla Placeholder
     */
    function arreglaAjax(){
        if(Modernizr.fontface){
            $('button.glyphicon').text('')
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
                    .attr('placeholder',placeholder);
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
        }
    }
    
    /*
     * Popover
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
     * obj      Objeto Jquery   Objeto a calcular el width
     * width    Boolean         Si suma el ancho
     * pading   Boolean         Si suma el padding
     * margin   Boolean         Si suma el margin
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
    /*
     * Get Total Width
     */
    /*
     * Imagen Isometrica
     */
    function imgIsometrico(){
        var w = $('.img-isometrico').parent().width();
        $('.img-isometrico img').width(w);
        $('.img-isometrico img').height(w*0.75);
    }
    /*
     * Imagen Isometrica
     */