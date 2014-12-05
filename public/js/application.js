/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var application = {
  topMenuRegister : function() {
    $(document).ready(function(){
        hideFields();
        $('#driverCheckBox').on('click', function(){
            var checkboxOnline = $("#driverCheck");
            if( !checkboxOnline.prop("checked") ){
                checkboxOnline.prop("checked",true);
                showFields();
            } else {
                checkboxOnline.prop("checked", false);
                hideFields();
            }
        });
        
        
        $('#dialogRegister').dialog({
            autoOpen: false, 
            width: 400,
            height: 600,
            closeOnEscape: true,
            beforeclose: function (event, ui) { event.stopPropagation(); return false; },
            close: function (event, ui){
                event.stopPropagation();
                return false; 
            },
            open: function (){
                $("input").blur();
                $('#driverLicense').datepicker({ dateFormat: 'dd.mm.yy', maxDate: 'dateToday'});
                
            },
            dialogClass: 'registerFormDialog',
            position:{my: 'top', at: 'top+20'},
            resize: true,
            resizable: false,
            draggable: false,
            modal: true
        });
        
        $('#register').on('click', function(){
            $('#dialogRegister').dialog('open');
        });
        
        $('#successInfo').dialog({
            autoOpen: false,
            closeOnEscape: true,
            beforeclose: function (event, ui) { return false; },
            width: 300,
            height: 150,
            close: function (event, ui){
                event.stopPropagation();
                $('#dialogRegister').dialog('close');
            },
            resizable: false,
            draggable: false,
            modal: true 
        }); 
        
    });
    
  }, 
  registerFormSubmit : function (){
    $(document).ready(function(){
        $('#registerInfo').submit(function(){
            var dataPost = $(this).serializeArray();
            
            $.ajax({
                type: 'POST',
                url: '/index/register',
                data: { dataPost: dataPost },
                dataType: 'json',
                async: false, 
                cache: false,
                success: function(data){ //returned json object => errors or 0 for ok
                    $('input').css('border', '1px solid rgba(204, 204, 204, 0.1)');
                    
                    if(data !== 0){
                        $.each(data, function(index,json){
                            $('input[name="'+index+'"]').css('border', '1px solid #C43F40');
                            //highlight fields that have not passed validation
                        });
                    } else {
                        $('input').css('border', '1px solid rgba(204, 204, 204, 0.1)');
                        $('textarea').css('border', '1px solid rgba(204, 204, 204, 0.1)');
                        $('#successInfo').dialog('open');
                    }
                }
            });
            return false;
        });
    });
  }
};

function showFields(){
    $('#carModel').css('opacity', '1');
    $('#carModel').removeAttr('disabled');
    $('label[for="carModel"]').css('opacity', '1');

    $('#carMake').css('opacity', '1');
    $('#carMake').removeAttr('disabled');
    $('label[for="carMake"]').css('opacity', '1');

    $('#driverLicense').css('opacity', '1');
    $('#driverLicense').removeAttr('disabled');
    $('label[for="driverLicense"]').css('opacity', '1');
}

function hideFields(){
    $('#carModel').css('opacity', '0.25');
    $('#carModel').attr('disabled', 'disabled');
    $('label[for="carModel"]').css('opacity', '0.25');

    $('#carMake').css('opacity', '0.25');
    $('#carMake').attr('disabled', 'disabled');
    $('label[for="carMake"]').css('opacity', '0.25');

    $('#driverLicense').css('opacity', '0.25');
    $('#driverLicense').attr('disabled', 'disabled');
    $('label[for="driverLicense"]').css('opacity', '0.25');
}