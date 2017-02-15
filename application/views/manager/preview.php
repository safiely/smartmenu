<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<html>
    <head>
        <title><?=$name?>, <?=$sizes['version']?></title>
        <script type="text/javascript" src="/assets/theme_manager/vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="/assets/theme_home/js/demo.js"></script>
        <link href="/assets/theme_home/css/demo.css" rel="stylesheet">
        <script>
            function switch_sizes(){
                var width = $('#iframe_content').width();
                var height = $('#iframe_content').height();
                
                $('#iframe_content').width(height);
                $('#iframe_content').height(width);
                
                if($('#iframe_content').width() > $('#iframe_content').height()) {
                    console.log('landscape');
                    $('.div-bottom').css('height', $('.div-bottom').height()-25);
                    $('.div-right').css('width', $('.div-right').width()+25);
                } else {
                    console.log('portrait');
                    $('.div-bottom').css('height', $('.div-bottom').height()+25);
                    $('.div-right').css('width', $('.div-right').width()-25);
                }
                
                
                $('.div-left').height($('#iframe_content').height());
                $('.div-right').height($('#iframe_content').height());
                $('.div-top').width($('#iframe_content').width()+$('.div-left').width()+$('.div-right').width());
                $('.div-bottom').width($('#iframe_content').width()+$('.div-left').width()+$('.div-right').width());
            }
        </script>
        <style>
            body{
                background-image: url('/assets/theme_home/img/demo-100.png');
            }            
            .infos{
                border-bottom:solid 1px lightGrey;
                background-color: white;
                margin-bottom:10px;
            }
            .infos span{
                vertical-align:top;
            }
        </style>
    </head>
    <body>
            <div class='infos'>
                <img class="logo_header" src="/assets/theme_manager/img/smartmenu-logo-350px.png">
                <span>
                Démonstration (<?=$sizes['version']?>)
                <button onClick="switch_sizes();">PIVOTER L'ÉCRAN</button>
                </span>
            </div>
            <div class="div-top"></div>
            <div class="div-left"></div>
            <iframe id="iframe_content" src="<?=$url?>" width="<?=$sizes['width']?>" height="<?=$sizes['height']?>" frameborder="0" class="preview_iframe"></iframe>    
            <div class="div-right"></div>
            <div class="div-bottom"></div>
    </body>
</html>