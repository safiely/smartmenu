$(document).ready(function(){
    
    
    /*
     *MENU
     */
    
    $('#name').focus();
    
    if(document.getElementById('menu_added')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre menu a bien été créé.');
    }
    
    $('.ascend, .descend').on('click', function(){
        var id = $(this).data('id');
        var rank = $(this).data('rank');
        
        if($(this).hasClass('ascend')) {
            var go = 'up';
        } else if($(this).hasClass('descend')) {
            var go = 'down';
        }
        location.href="/manager/modify_menu_rank/"+id+"/"+go;
    });
    
    
    
    if(document.getElementById('menu_rank_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'L\'ordre d\'affichage de vos menus a bien été modifié.');
    }
    
    
    $('.edit_menu').click(function(){
        var id = $(this).data('id');
        location.href="/manager/edit_menu/"+id;
    });
    
    
    if(document.getElementById('menu_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre menu a bien été modifié.');
    }
    
    $('.delete_menu').click(function(){
        var id = $(this).data('id');
        swal({   
            title: "Supprimer ce menu ?",
            text: "Aucun produit ou catégorie ne doit être associé à ce menu pour pouvoir le supprimer.",
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Supprimer",
            cancelButtonText: "Annuler"
        }, function(){   
            location.href="/manager/delete_menu/"+id;
        });
    });
    
    if(document.getElementById('menu_deleted')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre menu a bien été supprimé.');
    }
    
    
    if(document.getElementById('composition_existing_in_menu')!=null) {
        var menu_id = $('#composition_existing_in_menu').data('id');
        sweetAlertInitialize();
        swal({   
            title: "Impossible de supprimer ce menu.",
            text: "Il existe encore des produits ou des catégories associés à ce menu. Veuillez les supprimer avant de pouvoir supprimer ce menu.",
            type: "error",
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Voir la composition",
            cancelButtonText: "OK"
        }, function(){   
            location.href="/manager/edit_menu/"+menu_id;
        });
    }
    
    
    
    
    /*
     *COMPOSITION MENU
     */
    
    $('.save_composition').on('click',
        function(){
            var checkboxes = $('.product_selection:checked');
            if(checkboxes.length==0) {
                sweetAlertInitialize();
                swal({   
                    title: "Votre sélection doit contenir au moins un produit.",
                    text: "",
                    type: "error",
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "OK"
                });
            } else {
                $('#form_composition').submit();
            }
        }
    );
    
    $('.product_selection').on('click',
        function(){
            var prod_id = $(this).data('prod-id');
            if($(this).prop('checked') == false) {
                $('button[data-id="prices_cat_select_'+prod_id+'"').css('display', 'none');
            } else {
                if($('button[data-id="prices_cat_select_'+prod_id+'"')) {
                    $('button[data-id="prices_cat_select_'+prod_id+'"').css('display', 'block');
                    $('#prices_cat_select_'+prod_id).removeClass('hide');
                    $('#prices_cat_select_'+prod_id).next().removeClass('hide');
                }
            }
        }
    );
    
    
    
    
    $('.composition_ascend, .composition_descend').on('click', function(){
        var compo_id = $(this).data('id');
        
        if($(this).hasClass('composition_ascend')) {
            var go = 'up';
        } else if($(this).hasClass('composition_descend')) {
            var go = 'down';
        }
        
        location.href="/manager/modify_composition_rank/"+compo_id+"/"+go;
    });
    
    if(document.getElementById('composition_rank_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'L\'ordre d\'affichage de la composition de ce menu a bien été modifié.');
    }
    
    
    $('.edit_composition').click(function(){
        var compo_id = $(this).data('id');
        location.href="/manager/edit_composition/"+compo_id;
    });
    
    if(document.getElementById('composition_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'La composition de votre menu a bien été modifiée.');
    }
    
    $('.delete_composition').click(function(){
        var compo_id = $(this).data('id');
        sweetAlertInitialize();
        swal({   
            title: "Êtes-vous sur de vouloir supprimer cette sélection de votre menu ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "OK",
            cancelButtonText: "Annuler",
            confirmButtonColor: "#DD6B55",            
        }, function(){   
            location.href="/manager/delete_composition/"+compo_id;
        });
        
    });
    
    if(document.getElementById('composition_deleted')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'La composition de votre menu a bien été modifiée.');
    }
    
    
    
    
    
    
    /*
     *SELECTION
     */
    $('#selection_type').on('click',
        function(){
            var checked = $(this).prop('checked');
            if (checked == true) {
                $('#select_cat option[value=0]').prop('selected', true);
                $('.selection_type_list').css('display', 'inline-block');
            } else {
                $('#select_cat option[value=0]').prop('selected', true);
                $('.selection_type_list').css('display', 'none');
            }
            $('#select_cat').selectpicker('refresh');
        }
    );
    
    $('#select_cat').on('change',
        function(){
            if($('#select_cat option:selected').val()!=0 && $('#new_selection_name').val()=='') {
                $('#new_selection_name').val($('#select_cat option:selected').text());
            }
        }
    );
    
    if(document.getElementById('select_cat_for_composition')!=null) {
        sweetAlertInitialize();
        swal({   
            title: "Vous n'avez pas choisi la catégorie de produit associée à cette section.",
            text: "Vous avez décider d'associer cette section à une certaine catégorie de produit, mais vous n'en n'avez sélectionné aucune. Veuillez en choisir une.",
            type: "warning",
            confirmButtonText: "OK",
            confirmButtonColor: "#DD6B55",            
        });
        $('#name').on('focus', function(){
        	$('#new_selection_name').focus();
        	}
        );
        $('#selection_type').click();
        
    }
    
    
});