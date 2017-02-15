$(document).ready(function(){
    
	
    $('#maintenance').on('click',
        function(){
            $.ajax({
                url: '/manager/switch_maintenance_mode',
                data: '',
                method: 'POST',
                complete: function(jqXHR,textStatus){
                    var responseText = jqXHR.responseText;
                    if(responseText=='enabled') {
                        maintenance_mode_enabled();
                    } else if (responseText=='disabled') {
                        maintenance_mode_disabled();
                    }
                }
            });
        }
    );
    
    
    function maintenance_mode_enabled() {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Le mode maintenance est activé.');
        $('#maintenance_info').css('display', 'block');
        $('#maintenance_warning').css('display', 'inline-block');
    }
    
    function maintenance_mode_disabled() {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Le mode maintenance est désactivé.');
        $('#maintenance_info').css('display', 'none');
        $('#maintenance_warning').css('display', 'none');
    }
    
});