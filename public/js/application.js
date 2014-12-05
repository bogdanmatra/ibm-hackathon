/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var application = {
  topMenuRegister : function() {
    $(document).ready(function(){
        
        $('#dialogRegister').dialog({
            autoOpen: false, 
            closeOnEscape: true,
            beforeclose: function (event, ui) { event.stopPropagation(); return false; },
            close: function (event, ui){
                event.stopPropagation();
                
//                $('input').css('border', '1px solid rgba(204, 204, 204, 0.1)');
//                $('textarea').css('border', '1px solid rgba(204, 204, 204, 0.1)');
//                
//                $('input').val('');
//                $('textarea').val('');
                return false; 
            },
            open: function (){
//                $("input").blur();
//                var sku = $("#productDetailsView").data('sku');
//                $('input[name="productSku"]').val(sku);
//                populateFormWithSku(sku);
//                $('.specialTo').attr('disabled', 'disabled');
//                
//                $('.specialFrom').datepicker({ 
//                    dateFormat: 'dd.mm.yy', 
//                    minDate: 'dateToday',
//                    onSelect: function(date){
//                        $('.specialTo').datepicker( "option", "minDate", date );
//                        $('.specialTo').removeAttr('disabled');
//                        //minimum date is at least the start date
//                    }
//                });
//                
//                $('.specialTo').datepicker({ dateFormat: 'dd.mm.yy' });
                
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
    });
  }, 
  leftMenu : function (){
    $(document).ready(function(){
        $('.inside').hide();
        
        $('.subnav-item:has(ul)').click(function(){
            if($(this).hasClass('showing')){
                $(this).removeClass('showing');
                $(this).children('ul').hide();
                $(this).children('.text').css('border-bottom', '1px solid #E7E7E7');
                $(this).children().children('em').removeClass('em-active').addClass('em-inactive'); 
            } else {
                $(this).addClass('showing');
                $(this).children().show();
                $(this).children('span').css('border', 'none');
                $(this).children('ul').css('background-color', '#F1EEEE');
                $(this).children().children('em').removeClass('em-inactive').addClass('em-active');   
            }
        });
    });
  },
  switchStore: function(){
    $(document).ready(function(){
        $("select[name='selectStore']").change(function(){
            $.ajax({
                type: 'GET',
                url: '/store/currentstorechange',
                data: { store_id: $(this).val()},
                dataType: 'json',
                async: false, 
                cache: false,
                complete: function(){
                    location.reload(true);
                }
            }); 
        });  
    });
  },
  loading: function(){
    $(document).ready(function(){
      resizeWindow();
      $('*').css("cursor", "default");
      $('#refreshStockButton').click(function(){
          $(this).addClass("Refreshing");
          $('*').css("cursor", "wait");
          launchWindow('#dialog1');
      });
    });
  },
  setActiveMenu: function(){
    $(window).load(function(){
       var test = activePath;
       console.log(test);
       
       $('.text').children('a').each(function(){
           if($(this).attr('href') === '/'+test){
               $(this).parent().css('border-bottom', '1px solid #c34040');
               $(this).siblings('em').removeClass('em-inactive').addClass('em-link'); 
           }
       });
       
       $('.insideItem').children('a').each(function(){
           if($(this).attr('href') === '/'+test){
                var subnav = $(this).parent().parent().parent();
                subnav.addClass('showing');
                subnav.children().show();
                subnav.children('span').css('border', 'none');
                subnav.children('ul').css('background-color', '#F1EEEE');
                $(this).parent().addClass('insideItemActive');
                $(this).css('color', 'white');
                $(this).siblings('em').addClass('insideEmActive');
            }
       });
           
       
    });
  }
};

function launchWindow(id) {	
    var maskHeight = $(document).height();
    var maskWidth = $(window).width();

    $('#mask').css({'width':maskWidth,'height':maskHeight});
    $('#mask').fadeTo("slow",0.0);	

    var winH = $(window).height();
    var winW = $(window).width();

    $(id).css('top',  winH/2 - $(id).height()/2 - 60);
    $(id).css('left', winW/2 - $(id).width()/2);
    $(id).fadeIn(200); 	 
    
}

function resizeWindow(){
    $(window).resize(function () {
        var box = $('#boxes .window');
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
           
        $('#mask').css({'width':maskWidth,'height':maskHeight});

        var winH = $(window).height();
        var winW = $(window).width();
        
        box.css('top',  winH/2 - box.height()/2);
        box.css('left', winW/2 - box.width()/2 );
    });
}