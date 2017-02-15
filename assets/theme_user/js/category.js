$(document).ready(function(){

    if(document.getElementById('no_product_in_category')!=null) {
        new $.nd2Toast({
            message : "Aucun produit dans cette catégorie",
            ttl : 2000
        });
    }

    $('.confirmOrder').on('click',
        function(){
            var prod_id = $(this).data('id');
            $('#product_order').data('id', prod_id);
        }
    );
    
    $('#product_order').on('click',
        function(){
            var prod_id = $(this).data('id');
            var note = $('#note_text_field_product').val();
            var price = 0;
            var est_id = $(this).data('est-id');
            
            var post = {};
            post.prod_id = prod_id;
            post.note = note;
            post.price = price;
            post.est_id = est_id;
            
            
            $.ajax({
                data: post,
                method: 'POST',
                url: '/user/add_product_order?est_id='+post.est_id,
                complete: function(jqXHR,textStatus){
                    product_added_in_order();
                }
            });
        }
    );

    
    function product_added_in_order(){
        $("#confirmProductOrder").popup( "close" );
        $('.order_button').css('display', 'block');
        new $.nd2Toast({
            message : "<i class='zmdi zmdi-shopping-cart'></i> Produit ajouté à votre commande.",
            ttl : 2000
        });
    }
    
    

});