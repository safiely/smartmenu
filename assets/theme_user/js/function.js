
$(document).ready(function(){
    	
	$('#loading_smartmenu').remove();
	
    $.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
        options.async = true;
    });
    
    /*

    function adapt_left_panel_position() {
    	console.log('ok ok ok ');
        var screen_width = $('body').width();    
        var main_width = $('.ui-content.main_content').width()+40; 
        var margin = parseInt(screen_width-main_width);
        if (margin>200) {
        	console.log('1');
        	console.log($('div[data-role=panel]'));
            $('div[data-role="panel"]').panel();
            $('div[data-role="panel"]').panel('open');
            $('div[data-role="panel"]').css('width',margin+7);
            $('div[data-role="panel"]').removeClass('ui-panel-closed');
            $('.ui-panel-dismiss').removeClass('ui-panel-dismiss-open');
            $('div[data-role="header"].main_header, div[data-role="footer"]').css('width', main_width);
            $('div[data-role="popup"]').css('margin-left', $('#leftpanel').width());
            $('.see_card_button').css('display', 'none');
            /*
            var nav = $('#categories').prop('href').split('#');
            if(nav[1] == 'leftpanel'){
                $('#categories').prop('href','#');
            }*/
    
    /*
        } else {
        	console.log('2');
        	console.log($('div[data-role=panel]')[0]);
            $('div[data-role="panel"]').panel();
            $('div[data-role="panel"]').panel('close');
            $('div[data-role="header"].main_header, div[data-role="footer"]').css('width', 'auto');
            $('div[data-role="popup"]').css('margin-left', 'auto');
            $('.see_card_button').css('display', 'inline-block');
            //$('#categories').prop('href', '#leftpanel');
        }
    }
    adapt_left_panel_position();
   
    
    $(window).resize(adapt_left_panel_position);
*/
    
    //Check if it's a mobile device, or not...
    window.isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (window.isMobile.Android() || window.isMobile.BlackBerry() || window.isMobile.iOS() || window.isMobile.Opera() || window.isMobile.Windows());
        }
    };
    
    
    
});
        