$(document).ready(function(){
    
    tinymce.init({
        selector: '#presentation',
        language : 'fr_FR',
        height: 500,
        theme: 'modern',
        plugins: [
          'advlist autolink lists link charmap print preview hr anchor pagebreak',
          'searchreplace wordcount visualblocks visualchars code fullscreen',
          'insertdatetime media nonbreaking save table directionality',
          'emoticons paste textcolor colorpicker textpattern imagetools bdesk_photo'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify outdent indent | forecolor backcolor | bullist numlist | emoticons link bdesk_photo media | preview',  
        image_advtab: true,
        content_css: [
          '/assets/theme_user/css/font-awesome.min.css',
          '/assets/theme_user/vendor/jquerymobile/jquery.mobile.min.css',
          '/assets/theme_user/css/nativedroid2.css',
          '/assets/theme_user/css/style.css'
        ],
        removed_menuitems: 'newdocument',
        browser_spellcheck: true,
        contextmenu: false
    });
    
    
    
   
    if(document.getElementById('presentation_modified')!=null) {
        notify('top', 'right', '', 'success', 'animated fadeIn', 'animated fadeOut', '', 'Votre présentation a bien été modifiée.');
    }
    
    $('.background_image').on('click', function(){
        $('.background_image').removeClass('selected');
        $(this).addClass('selected');
        $('#background_image').val($(this).data('file'));
    });
    
    $('#no_image').on('click',
        function(){
            var display = ($(this).prop('checked')) ? 'none' : 'inline';
            $('.background_image').css('display', display);
            $('#background_image').val('');
        }
    );
    
    var file_input_width = parseInt($('div.fileinput .fileinput-preview').css('width'));
    var file_input_height = (file_input_width>300) ? 300 : file_input_width;
    $('div.fileinput .fileinput-preview').css('height', file_input_height);
    $('.fileinput-new').on('click',
        function(){
            $('.fileinput .fileinput-preview').css('display', 'block');
        }
    );
    
    
});