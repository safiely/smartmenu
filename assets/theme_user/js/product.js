$(document).ready(function(){
    
    $('.product_order').on('click',
        function(){
            var prod_id = $(this).data('id');
            var prices_cat = $(this).data('prices-cat');
            var note = '';
            var prices_cat_id = 0;
            var price = 0;
            var est_id = $(this).data('est-id');
            
            if(prices_cat==1) {
                prices_cat_id = $('input[name="prices_categories"]:checked').val();
                if($('#note_text_field').val()!='') {
                    note = $('#prices_cat_name_'+prices_cat_id).html()+', '+$('#note_text_field').val();
                } else {
                    note = $('#prices_cat_name_'+prices_cat_id).html();
                }
                price = $('#prices_cat_price_'+prices_cat_id).data('price');
            } else {
                note = $('#note_text_field').val();
            }
            
            var post = {};
            post.prod_id = prod_id;
            post.note = note;
            post.price = price;
            post.est_id = est_id;
            
            $.ajax({
                data: post,
                method: 'POST',
                url: '/user/add_product_order',
                complete: function(jqXHR,textStatus){
                    product_added_in_order();
                }
            });
        }
    );
    
    function product_added_in_order(){
        $("#confirmOrder").popup( "close" );
        $('.order_button').css('display', 'block');
        new $.nd2Toast({
            message : "<i class='zmdi zmdi-shopping-cart'></i> Produit ajouté à votre commande.",
            ttl : 2000
        });
    }
    
    
    $('.product_selected').on('click',
        function(){
            var prod_id = $(this).data('id');
            $('#prepare_order_'+prod_id).removeClass('ui-disabled');
        }
    );
    
    function prepare_order(){
        var products_to_select = $('.product_selected');
        if (products_to_select.length==0) {
            $('.add_command_button').removeClass('ui-disabled');
        }
    }
    prepare_order();
    
});