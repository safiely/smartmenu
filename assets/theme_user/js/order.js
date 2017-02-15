$(document).ready(function(){
    
    $('div.row.product_ordered').on('click',
        function(){
            var prod_id = $(this).data('id');
            var prod_name = $('#product_name_'+prod_id).html();
            var cat_id = $(this).data('cat-id');
            var cat_product_id = $(this).data('product-id');
            var est_id = $(this).data('est-id');
            
            $('#see_product_from_order').prop('href','/user/product/'+prod_id+'/order?est_id='+est_id);
            $('#remove_product_from_order').prop('href','/user/remove_product_order/'+cat_id+'/'+cat_product_id+'?est_id='+est_id);
            $('#toast_title').html(prod_name);
            
            if($(this).hasClass('in_menu')) {
                location.href='/user/product/'+prod_id+'/order?est_id='+est_id;
            } else {
                $('.see_product').css('display', 'inline-block');
                $('a#edit_order_button').click();    
            }
        }
    );
    
    
    
    $('div.row.menu_ordered').on('click',
        function(){
            var menu_id = $(this).data('menu-id');
            var menu_rank = $(this).data('menu-rank');
            var menu_name = $('#menu_name_'+menu_id).html();
            var est_id = $(this).data('est-id');
             
            $('.see_product').css('display', 'none');
            $('#remove_product_from_order').prop('href','/user/remove_menu_order/'+menu_rank+'?est_id='+est_id);
            $('#toast_title').html(menu_name);
            $('a#edit_order_button').click(); 
        }
    );
    
    
    if(document.getElementById('product_removed')!=null) {
        new $.nd2Toast({
            message : "Produit retiré de votre commande.",
            ttl : 2000
        });
    }
    
    if(document.getElementById('menu_added_to_order')!=null) {
        new $.nd2Toast({
            message : "<i class='zmdi zmdi-shopping-cart'></i> Menu ajouté à votre commande.",
            ttl : 2000
        });
        $('#order_button').css('display', 'block');
    }
    
    
    
    
});
