<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Rechercher</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="stylesheet" href="/assets/theme_user/css/font-awesome.min.css" />
        <link rel="stylesheet" href="/assets/theme_user/vendor/jquerymobile/jquery.mobile.min.css" />
        <link rel="stylesheet" href="/assets/theme_user/vendor/waves/waves.min.css" />
        <link rel="stylesheet" href="/assets/theme_user/vendor/wow/animate.css" />
        <link rel="stylesheet" href="/assets/theme_user/css/nativedroid2.css" />
        <style>
        /* Prevent FOUC  ??? */
        /*body { opacity: 0; }*/
        .ui-autocomplete li{
            border-bottom:1px solid grey;
        }
        .nd2-search-result-item span.icon{
            display:none;
        }
        .nd2-search-result-item .term{
            display:inherit;
        }
        </style>
    </head>
    <body class="clr-accent-lime">
        
        <div data-role="page">
            <div data-role="header" data-position="fixed" class="wow fadeIn">
                <h1 class="wow fadeIn" style="margin-left:10px;" data-wow-delay='0.4s'>Rechercher un établissement</h1>
            </div>
            <div role="main" class="ui-content wow fadeIn" data-inset="false" data-wow-delay="0.2s">
                <? if($state=='search') { ?>
                <span class="nd2-title">OOPS !...</span>
                <p>
                    L'adresse que vous avez saisi ne correspond à aucun établissement,
                    merci de refaire votre recherche via la barre de recherche.
                </p>
                    <? if(isset($near)) { ?>
                    <span class="nd2-title">Vous recherchez peut etre :</span>
                    <p>
                        <ul>
                        <? foreach($near as $k=>$est){ ?>
                            <li><a href="/<?=$est['url']?>" data-ajax="false"><?=$est['name']?></a></li>
                        <? } ?>
                        </ul>
                    </p>
                    <? } ?>
                <? } else if($state=='disconnected') { ?>
                <p>Vous avez été déconnecté.</p>
                <? } else if($state=='maintenance') { ?>
                <p>
                    <center>
                    <h3>La carte de cet établissement est en cours de maintenance.</h3>
                    <br />
                    <img src ="/assets/common/img/maintenance.png" />
                    <br />
                    <h3>Merci pour votre compréhension.</h3>
                    </center>
                </p>
                <? } ?>
            </div>
        </div>
        
        <script src="/assets/theme_user/vendor/jquery/jquery-2.1.4.min.js"></script>
        <script src="/assets/theme_user/vendor/jquery-ui/jquery-ui-1.11.4.min.js"></script>
        <script src="/assets/theme_user/vendor/jquerymobile/jquery.mobile-1.4.5.min.js"></script>
        <script src="/assets/theme_user/vendor/waves/waves.min.js"></script>
        <script src="/assets/theme_user/vendor/wow/wow.min.js"></script>
        <script src="/assets/theme_user/js/nativedroid2.js"></script>
        <script src="/assets/theme_user/nd2settings.js"></script>        
        
        <script type="text/javascript">
        // Toast Test
        new $.nd2Search({
            placeholder : "Rechercher",
            defaultIcon : "local-store",
            source : [
            <? foreach($urls as $k => $est) {
                echo '{"label": "',$est->name,' (',$est->city,')", "value": "',$est->url,'"},';
            } ?>
            ],
            fn : function(result) {
                location.href="/"+result;
            }
        });
        </script>
    
    
    </body>
</html>
