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
        if(
            id.indexOf('formato_nombre') !== false
            || id.indexOf('formato_numero') !== false
        ){
            este.editable('option', 'validate', function(v) {
                if(!v) 
                    return 'Campo Requerido!';
            });
        }
    }).on('save.campo', function(){
        var that = $(this);
        setTimeout(function() {
            var obj = editable_object[editable_index[that.attr('id')]+1];
            if(typeof obj !== 'undefined')
                obj.editable('show');
        }, 200);
    });
    
    $('.guardar-formato').on('click',function(){
        
    });
    $('#save-btn').click(function() {
        var este = $(this)
        $('.formato_crear').editable('submit', {
             url: este.attr('href'), 
             ajaxOptions: {
                 dataType: 'json'
             },           
             success: function(data, config) {
                 if(data && data.id) {
                     //set pk
                     $(this).editable('option', 'pk', data.id);
                     //remove unsaved class
                     $(this).removeClass('editable-unsaved');
                     //show messages
                     var msg = 'New user created! Now editables submit individually.';
                     $('#msg').addClass('alert-success').removeClass('alert-error').html(msg).show();
                     $('#save-btn').hide(); 
                     $(this).off('save.newuser');                     
                 } else if(data && data.errors){ 
                     //server-side validation error, response like {"errors": {"username": "username already exist"} }
                     config.error.call(this, data.errors);
                 }               
             },
             error: function(errors) {
                 var msg = '';
                 if(errors && errors.responseText) { //ajax error, errors = xhr object
                     msg = errors.responseText;
                 } else { //validation error (client-side or server-side)
                     $.each(errors, function(k, v) { msg += k+": "+v+"<br>"; });
                 } 
                 $('#msg').removeClass('alert-success').addClass('alert-error').html(msg).show();
             }
         });
     });
});