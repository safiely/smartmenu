$(document).ready(function(){
    
	/*
    $('.see_product').on('click',
        function(){
            var prod_id = $(this).data('id');
            var menu_id = $(this).data('menu');
            var est_id = $(this).data('est-id');
            location.href="/user/product/"+prod_id+"/menu_"+menu_id+"?est_id="+est_id;
        }
    );
    
    
    $('.select_a_product').on('click',
        function(){
            var compo_id = $(this).prop('name');
            var product_name = $(this).data('name');
            var prod_id = $(this).val();
            
            $('#compo_'+compo_id+'_selection').html(product_name);
            $('#compo_'+compo_id+'_ordered').val(prod_id);
            $('#compo_'+compo_id+'_note').prop('name', 'note['+prod_id+']');
            $('#compo_'+compo_id+'_note').removeAttr('disabled');
            $('#compo_'+compo_id+'_note').parent().removeClass('ui-state-disabled');
            
            var order_construction = $('.order_construction');
            
            for (var i = 0; i < order_construction.length; i++) {
                var val = order_construction[i].value;
                order_possible = (val!="") ? true : false;
                if (order_possible == false) {
                    break;
                }
            }
            
            if (order_possible == true) {
                $('#order_menu').removeClass('ui-disabled');
            } else {
                if(!$('#order_menu').hasClass('ui-disabled')) {
                    $('#order_menu').addClass('ui-disabled');    
                }
            }
            
        }
    );
    
    
    function check_order_construction(){
        var order_construction = $('.order_construction');
        for (var i = 0; i < order_construction.length; i++) {
            var val = order_construction[i].value;
            order_possible = (val!="") ? true : false;
            if (order_possible == false) {
                break;
            }
        }
        
        if (order_possible == true) {
            $('#order_menu').removeClass('ui-disabled');
        } else {
            if(!$('#order_menu').hasClass('ui-disabled')) {
                $('#order_menu').addClass('ui-disabled');    
            }
        }
    }
    check_order_construction();
    
    
    $('#order_menu').on('click',
        function(){
            $('#form_order').submit();
        }
    );
    */
    
});