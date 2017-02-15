
$(document).ready(function(){
   
   
   
    if(document.getElementById('datas_modified')!=null) {
      notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Vos informations ont bien été mises à jour.');
    }
    
    
    if(document.getElementById('existing_url')!=null) {
        sweetAlertInitialize();
        swal({   
            title: "Adresse web d'accès à votre carte déjà prise.",
            text: "L\'adresse web que vous avez indiquée est déjà utilisée par un autre utilisateur. Veuillez en choisir une autre.",
            type: "error",
            showCancelButton: false,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "OK"
        });
    }
    
    
    $('input#est_url').on('keyup',
        function(){
            $('img#qrcode').css('display', 'none');
            var url = $(this).val();
            url = url.toLowerCase();
            url = url.replace(/\ /g,'');
            url = url.replace(/\'/g,'');
            url = no_accent(url);
            $(this).val(url);
        }
          );
    
    $('input#name').on('keyup',
        function(){
            var url_helper = $('#url_helper').val();
            if (url_helper == '1') {
                var name = $(this).val();
                var url = name;
                url = url.toLowerCase();
                url = url.replace(/\ /g,'');
                url = url.replace(/\'/g,'');
                url = no_accent(url);
                $('#est_url').val(url);
            }
        }
    );
    
    function no_accent(my_string) {
        var new_string = "";
        var pattern_accent = new Array("é", "è", "ê", "ë", "ç", "à", "â", "ä", "î", "ï", "ù", "ô", "ó", "ö");
        var pattern_replace_accent = new Array("e", "e", "e", "e", "c", "a", "a", "a", "i", "i", "u", "o", "o", "o");
        if (my_string && my_string!= "") {
                new_string = preg_replace(pattern_accent, pattern_replace_accent, my_string);
        }
        return new_string;
    }
    
    function preg_replace(array_pattern, array_pattern_replace, my_string)  {
        var new_string = String (my_string);
        for (i=0; i<array_pattern.length; i++) {
                var reg_exp= RegExp(array_pattern[i], "gi");
                var val_to_replace = array_pattern_replace[i];
                new_string = new_string.replace (reg_exp, val_to_replace);
        }
        return new_string;
    }

    
});