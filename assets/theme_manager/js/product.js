
$(document).ready(function(){
    
    
    //Onlaod
    $('#name').focus();
    
    //Set the prices categories if the selected category got it
    if($("#select_category option:selected").data('prices-cat')=='1'){
        var cat_id = $("#select_category option:selected").val();
        $('.unique_price').css('display','none');
        $('.prices_category_'+cat_id).css('display', 'block');
        $('#prices_categories').val('1');
    } else {
        $('.unique_price').css('display','block');
        $('#prices_categories').val('0');
    }
    
    
    
    
    
    $('#select_category').on('change',
        function(){
            $('#name').focus();
            $('.prices_category').css('display', 'none');
            
            //Price definition...
            if($('.prices_cat_values').length>0) {
                var prices = new Array();
                for(var i=0; i<$('.prices_cat_values').length; i++) {
                    prices[i] = $('.prices_cat_values')[i].value;
                }
                prices[i] = $('#unique_price_value').val();
                var price = Math.max.apply(null, prices);
            } else {
                var price = $('#unique_price_value').val();
            }
            
            //Reset fields
            if($("#select_category option:selected").data('prices-cat')=='1') {
                var cat_id = $("#select_category option:selected").val();
                $('.unique_price').css('display','none');
                $('.prices_cat_'+cat_id+'_value').val($('#unique_price_value').val());
                $('.prices_category_'+cat_id).css('display', 'block');
                $('#prices_categories').val('1');
            } else {
                $('.unique_price').css('display','block');
                $('#unique_price_value').val(price);
                $('#prices_categories').val('0');
            }
        }
    );
    
    
    
    
    
    
    $('.edit_product').click(
        function(){
            var id = $(this).data('id');
            location.href="/manager/edit_product/"+id;
        }
    );
   
    $('.delete_product').click(
        function(){
            var id = $(this).data('id');
            var cat_id = $(this).data('cat-id');
            swal({   
                title: "Supprimer ce produit ?",
                text: "Vous êtes sur le point de supprimer ce produit de votre carte.",
                type: "warning",   
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Supprimer",
                cancelButtonText: "Annuler"
            }, function(){   
                location.href="/manager/delete_product/"+id+"/"+cat_id;
            });
        }
    );
    
    $('.ascend, .descend').on('click',
        function(){
            var id = $(this).data('id');
            var rank = $(this).data('rank');
            
            if($(this).hasClass('ascend')) {
                var go = 'up';
            } else if($(this).hasClass('descend')) {
                var go = 'down';
            }
            location.href="/manager/modify_product_rank/"+id+"/"+go;
        }
    );
    
    $('.add_product_button').click(
        function(){
            var cat_id = $(this).data('cat-id');
            location.href="/manager/add_product/"+cat_id;
        }
    );
    
    
    if(document.getElementById('upload_image_problem')!=null) {
        notify('top', 'right', '', 'danger', 'animated fadeIn', 'animated fadeOut', '', 'L\'image du produit n\'a pas pu être enregistrée.');
    }
    
    if(document.getElementById('no_price_for_this_product')!=null) {
        notify('top', 'right', '', 'danger', 'animated fadeIn', 'animated fadeOut', '', 'Vous n\'avez pas défini de prix pour ce produit.');
    }
   
   
    if(document.getElementById('product_added')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre produit a bien été ajouté.');
    }
    
    if(document.getElementById('product_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre produit a bien été modifié.');
    }
    
    if(document.getElementById('product_rank_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'L\'ordre d\'affichage de vos produits a bien été modifié.');
    }
   
    if(document.getElementById('product_deleted')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre produit a bien été supprimé.');
    }
    
    if(document.getElementById('there_is_no_category')!=null) {
        sweetAlertInitialize();
        swal({   
            title: "Aucune catégorie existante.",
            text: "Avant d'ajouter des produits à votre carte, vous devez créer au moins une catégorie.",
            type: "warning",   
            showCancelButton: false,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "OK",
        }, function(){   
            location.href="/manager/categories";
        });
    }
    
    
    $('thead.toggle_products').on('click',
        function(){
            var cat_id = $(this).data('id');
            var arrow = $('#develop_'+cat_id);
            
            $('#thead_'+cat_id).toggle();
            $('#tbody_'+cat_id).toggle();
            
            if(arrow.hasClass('zmdi-long-arrow-up')) {
                arrow.removeClass('zmdi-long-arrow-up');
                arrow.addClass('zmdi-long-arrow-down');
            } else {
                arrow.addClass('zmdi-long-arrow-up');
                arrow.removeClass('zmdi-long-arrow-down');
            }
        }
    );
    
    if(document.getElementById('products_in_compo')!=null) {
        sweetAlertInitialize();
        swal({   
            title: "Ce produit est présent dans vos menus.",
            text: "Avant de supprimer ce produit, assurez vous qu'il ne soit pas proposé dans un ou plusieurs de vos menus.",
            type: "warning",
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Aller à la page des menus",
            cancelButtonText: "OK"
        }, function(){   
            location.href="/manager/menus";
        });
    }
    
    var file_input_width = parseInt($('div.fileinput .fileinput-preview').css('width'));
    var file_input_height = (file_input_width>400) ? 400 : file_input_width;
    $('div.fileinput .fileinput-preview').css('height', file_input_height);
    $('.fileinput-new').on('click',
        function(){
            $('.fileinput .fileinput-preview').css('display', 'block');
        }
    );
    
});