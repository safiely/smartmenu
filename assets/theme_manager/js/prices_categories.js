
$(document).ready(function(){
   
    
	$('#prices_category_name').focus();
    
    
    if(document.getElementById('prices_category_added')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'La quantité a bien été créée.');
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
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'La quantité a été modifiée.');
    }
    
    
    $('.delete_prices_category').click(function(){
        var prices_cat_id = $(this).data('id');
        sweetAlertInitialize();
        swal({   
            title: "Supprimer cette quantité ?",
            text: "En supprimant cette quantité vous allez supprimer tous les prix concernés par celle-ci.",
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
    
    /*
    $('#no_image').on('click',
        function(){
            var display = ($(this).prop('checked')) ? 'none' : 'inline';
            $('.category_image').css('display', display);
            $('#category_image_help_text').css('display', display);
            var value = ($(this).prop('checked')) ? '0' : '1-plate.png';
            $('#category_image').val(value);
        }
    );
*/
    
});