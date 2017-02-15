<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
    <html lang="fr">
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
        <meta charset="UTF-8">
        <meta name="description" content="Description a faire">
        <title><?=$title?></title>
        <link rel="icon" type="image/png" href="/assets/common/img/favicon.png" />
        <? foreach($css as $file){ ?><link href="<?=$file?>" rel="stylesheet"><? } ?>
    </head>
    <body>
        <header id="header" class="clearfix" data-spy="affix" data-offset-top="65">
            <ul class="header-inner">
                <!-- Logo -->
                <li class="logo">
                    <a href="/manager"><img style="width:100%;" src="<?=base_url('assets/theme_manager/img/smartmenu-logo-350px.png');?>" alt=""></a>
                    <div id="menu-trigger"><i class="zmdi zmdi-menu"></i></div>
                </li>
                <li class="main_header">
                    <h2 class="main_header_title"><?=$header?></h2>
                </li>
            </ul>
        </header>
        <aside id="sidebar">
            <ul class="side-menu">
                <?
                $display_maintenance = ($maintenance==0) ? 'none' : 'block';
                ?>
                <li id="maintenance_info" style="display:<?=$display_maintenance?>;">
                    <a href="/manager/">
                        <i class="zmdi zmdi-wrench"></i>
                        <span class="c-deeporange">
                            <strong>Maintenance activée</strong>
                        </span>
                    </a>
                </li>
                <li id="menu_dashboard">
                    <a href="/manager">
                        <i class="zmdi zmdi-home"></i>
                        <span>Tableau de bord</span>
                    </a>
                </li>
                <li id="menu_establishment">
                    <a href="/manager/establishment">
                        <i class="zmdi zmdi-store"></i>
                        <span>Établissement</span>
                    </a>
                </li>   
                <li id="menu_customisation">
                    <a href="/manager/customisation">
                        <i class="zmdi zmdi-brush"></i>
                        <span>Personnalisation</span>
                    </a>
                </li>
                <li id="menu-categories" class="sm-sub">
                    <a href="#">
                        <i class="zmdi zmdi-library"></i>
                        <span>Catégories<span class="hidden-sm hidden-md"> de produits</span></span>                        
                    </a>
                    <ul id="menu_categories">
                        <li id="menu_add_categories">
                            <a href="/manager/add_category">Ajouter une catégorie de produits</a>
                        </li>
                        <li id="menu_edit_categories">
                            <a href="/manager/categories">Vos catégories de produits</a>
                        </li>
                    </ul>
                </li>
                <li id="menu-products" class="sm-sub">
                    <a href="#">
                        <i class="zmdi zmdi-pizza"></i>
                        <span>Produits</span>                        
                    </a>
                    <ul id="menu_product">
                        <li id="menu_add_product"><a href="/manager/add_product">Ajouter un produit</a></li>
                        <?
                        foreach($cat_list as $cat_id => $cat){
                            echo "<li id='menu_cat_$cat_id'><a href='/manager/products_by_cat/$cat_id'>",$cat['name'],'</a></li>';
                        }
                        ?>
                    </ul>
                </li>                
                <li id="menu-modules" class="sm-sub">
                    <a href="#">
                        <i class="zmdi zmdi-widgets"></i>
                        <span>Modules</span>                        
                    </a>
                    <ul id="menu_modules">
                        <li id="menu_modules_selection"><a href="/manager/modules">Gérer mes modules</a></li>
                        <?
                        if($modules->social){
                            echo "<li id='mod_social'><a href='/manager/mod_social'>Réseaux sociaux</a></li>";
                        }

                        if($modules->menus){
                            echo "<li id='mod_menus'><a href='/manager/menus'>Menu et formules</a></li>";
                        }
                        
                        if($modules->prices_cat){
                        	echo "<li id='mod_prices_cat'><a href='/manager/prices_categories'>Quantités</a></li>";
                        }
                        
                        if($modules->suggest){
                        	echo "<li id='mod_suggest'><a href='/manager/suggestions'>Suggestions</a></li>";
                        }
                        
                        ?>

                    </ul>
                </li>   
                <li>
                    <a href="/manager/help" id="menu_help">
                        <i class="zmdi zmdi-help"></i>
                        <span>Aide
                        </span>
                    </a>
                </li>
                <li>
                    <a href="/home/logout/<?=$sub_id?>">
                        <i class="zmdi zmdi-power"></i>
                        <span>
                            Déconnexion
                        </span>
                    </a>
                </li>
            </ul>
        </aside>
        <section id="content">
            <div class="container">
                <?
                if(isset($debug)) echo"<div><b style='color:red;'>DEBUG :</b> <br /><pre>$debug</pre></div>";
                
                echo $output;
                
                if(isset($errors) && !empty($errors)) {
                    echo $errors;
                }
                
                if(isset($success) && !empty($success)) {
                    echo $success;
                }
                
                if(isset($notifications) && !empty($notifications)) {
                    echo $notifications;
                }
                
                if($datas_missing==true){
                    echo '<div class="hidden" id="datas_missing"></div>';
                }                
                ?>
            </div>
        </section>
        
        <footer id="footer">
            smartmenu.fr © <?=date('Y')?>
        </footer>
        
        
        
        <!-- VOIR SI JE LE GARDE ?? -->
        <!-- Older IE Warning Message -->
        <!--[if lt IE 9]>
            <div class="ie-warning">
                <h1 class="c-white">Warning!!</h1>
                <p>You are using an outdated version of Internet Explorer, please upgrade <br/>to any of the following web browsers to access this website.</p>
                <div class="iew-container">
                    <ul class="iew-download">
                        <li>
                            <a href="http://www.google.com/chrome/">
                                <img src="img/browsers/chrome.png" alt="">
                                <div>Chrome</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.mozilla.org/en-US/firefox/new/">
                                <img src="img/browsers/firefox.png" alt="">
                                <div>Firefox</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://www.opera.com">
                                <img src="img/browsers/opera.png" alt="">
                                <div>Opera</div>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.apple.com/safari/">
                                <img src="img/browsers/safari.png" alt="">
                                <div>Safari</div>
                            </a>
                        </li>
                        <li>
                            <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                                <img src="img/browsers/ie.png" alt="">
                                <div>IE (New)</div>
                            </a>
                        </li>
                    </ul>
                </div>
                <p>Sorry for the inconvenience!</p>
            </div>   
        <![endif]-->
        
        
        
        <? foreach($js as $file){ ?><script type="text/javascript" src="<?=$file?>"></script><? } ?>
        
        
        <!-- APP : Mettre ça dans un fichier générique à tout le manager. Voir comment je fais pour gérer ce mélange php/js tres moche -->
        <script>
        
        //Surbrillance menu actif
        $('#<?=$active_menu?>').addClass('active');
        
        
        //Affiche arboressence dans sous menu
        <? if(!empty($toggle_menu)) { ?>
        if ($('#sidebar').css('width') == '240px') {
            $('#<?=$toggle_menu?>').slideToggle(1);
            $('#<?=$toggle_menu?>').toggleClass('toggled');
        }
        <? } ?>
        
        
        //Affichage wizzard lors de la premiere connexion et si infos importantes manquantes
        if(document.getElementById('datas_missing')!=null) {
            sweetAlertInitialize();
            swal({   
                title: "Assistant de démarrage",
                text: "Avant de configurer votre carte, vous devez renseigner certaines informations nécéssaires sur votre établissement.\nLes champs marqués d'une étoile rouge sont obligatoires.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4CAF50",
                confirmButtonText: "Configurer l'établissement",
                cancelButtonText: "Voir l'assistant"
            },
                function(isConfirm) {
                    if (isConfirm) {
                        location.href="/manager/establishment";
                    } else {
                        location.href="/manager/help";
                    }
                }
            );
        }
        </script>
    </body>
</html>