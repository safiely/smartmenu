
$(document).ready(function(){
   
    
    $('#name').focus();
    
    $('.edit_category').click(function(){
        var id = $(this).data('id');
        location.href="/manager/edit_category/"+id;
    });
   
    $('.delete_category').click(function(){
        var id = $(this).data('id');
        swal({   
            title: "Supprimer cette catégorie ?",
            text: "Aucun produit ou menu ne doit être associé à cette catégorie pour pouvoir la supprimer.",
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler"
        }, function(){   
            location.href="/manager/delete_category/"+id;
        });
    });
    
    $('.ascend, .descend').on('click', function(){
        var id = $(this).data('id');
        var rank = $(this).data('rank');
        
        if($(this).hasClass('ascend')) {
            var go = 'up';
        } else if($(this).hasClass('descend')) {
            var go = 'down';
        }
        location.href="/manager/modify_category_rank/"+id+"/"+go;
    });
    
    if(document.getElementById('products_existing_in_category')!=null) {        
        sweetAlertInitialize();
        cat_id = $('#products_existing_in_category').data('cat-id');
        swal({   
            title: "Impossible de supprimer cette catégorie.",
            text: "Il existe encore des produits associés à cette catégorie. Veuillez les supprimer avant de pouvoir supprimer cette catégorie.",
            type: "error",
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Aller à la page produits",
            cancelButtonText: "OK"
        }, function(){   
            location.href="/manager/products_by_cat/"+cat_id;
        });
    }
    
    if(document.getElementById('category_existing_in_compo')!=null) {        
        sweetAlertInitialize();
        swal({   
            title: "Impossible de supprimer cette catégorie.",
            text: "Avant de supprimer cette catégorie, assurez vous qu'elle ne soit pas proposé dans un ou plusieurs de vos menus.",
            type: "error",
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Aller à la page des menus",
            cancelButtonText: "OK"
        }, function(){   
            location.href="/manager/menus";
        });
    }
    
    if(document.getElementById('category_already_exists')!=null) {        
        sweetAlertInitialize();
        swal({   
            title: "Ce nom de catégorie est déjà pris.",
            text: "Vous essayer de créer une catégorie ayant le même nom qu'une catégorie déjà existante dans votre carte. Merci de nommer votre nouvelle catégorie différement.",
            type: "error",
            showCancelButton: false,   
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "OK"
        });
    }
    
    
    if(document.getElementById('category_added')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre catégorie a bien été créée.');
    }
    
    if(document.getElementById('category_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre catégorie a bien été modifiée.');
    }
    
    if(document.getElementById('category_rank_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'L\'ordre d\'affichage de vos catégories a bien été modifié.');
    }
    
    if(document.getElementById('category_deleted')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre catégorie a bien été supprimée.');
    }
    
    
    $('.category_image').on('click', function(){
        $('.category_image').removeClass('selected');
        $(this).addClass('selected');
        $('#category_image').val($(this).data('file'));
    });
    
    
    /*
     *PRICES CATEGORIES
     */
    
    /*
    
    
    if(document.getElementById('prices_category_added')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre catégorie de prix a bien été créée.');
    }
    
    $('.ascend_prices_cat, .descend_prices_cat').on('click', function(){
        var id = $(this).data('id');
        var rank = $(this).data('rank');
        var cat_id = $(this).data('cat-id');
        
        if($(this).hasClass('ascend_prices_cat')) {
            var go = 'up';
        } else if($(this).hasClass('descend_prices_cat')) {
            var go = 'down';
        }
        location.href="/manager/modify_prices_category_rank/"+id+"/"+cat_id+"/"+go;
    });
    
    if(document.getElementById('prices_category_rank_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'L\'ordre d\'affichage de vos catégories de prix a bien été modifié.');
    }
    
    
    $('.edit_prices_category_name').on('click',
        function(){
            var prices_cat_id = $(this).data('id');
            var name = $('#'+prices_cat_id).val();
            var post =  {};
            post.prices_cat_id = prices_cat_id;
            post.name = name;
            
            $.ajax({
                url: '/manager/edit_prices_category_name',
                data: post,
                method: 'POST',
                complete: function(jqXHR,textStatus){
                    prices_category_name_modified();
                }
            });
        }
    );
    
    function prices_category_name_modified(){
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Information modifiée.');
    }
    
    
    $('.delete_prices_category').click(function(){
        var prices_cat_id = $(this).data('id');
        sweetAlertInitialize();
        swal({   
            title: "Supprimer cette catégorie de prix ?",
            text: "En supprimant cette catégorie de prix, vous allez supprimer tous les prix concernés par celle-ci.",
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler"
        }, function(){
            location.href="/manager/delete_prices_category/"+prices_cat_id;
        });
    });
    
    if(document.getElementById('prices_category_deleted')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Les catégories de prix de votre catégorie ont bien été modifiées.');
    }
    
    */
    $('#no_image').on('click',
        function(){
            var display = ($(this).prop('checked')) ? 'none' : 'inline';
            $('.category_image').css('display', display);
            $('#category_image_help_text').css('display', display);
            var value = ($(this).prop('checked')) ? '0' : '1-plate.png';
            $('#category_image').val(value);
        }
    );

    
});