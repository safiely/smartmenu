<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<script>
//Loader during first load of the menu
var loader = '<div style="width:100%; text-align:center;height:100%; background-color:transparent;" id="loading_smartmenu">'+
'<h2><?=$est->name?></h2><br />'+
'<img src="/uploads/logo/thumbails/thumb_<?=$customisation->logo?>" ><br />'+
'<br />Carte en cours de chargement...<br /><br />'+
'<img src="/assets/theme_user/vendor/jquerymobile/images/ajax-loader.gif" />'+
'</div>';
document.write(loader);
</script>


<!DOCTYPE HTML>
<html>
<head>
	<title><?=$title?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Language" content="fr-FR" />
	<link rel="icon" type="image/png" href="/assets/common/img/favicon.png" />
	<? if(!empty($customisation->background_image)) { ?>
	<style>
	body {
		background-image:
			url('/assets/common/img/background/default/<?=$customisation->background_image?>');
	}
	</style>
	<? } ?>
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	
</head>


<body>

	<!-- PANEL-->
	<div data-role="panel" id="<?=$panel_id?>" data-display="overlay" data-position-fixed="true">

		<!-- PANEL HEADER -->
		<a href="/user?est_id=<?=$est->id?>" id="returnHome" data-prefetch data-dom-cache="true">
			<div class='nd2-sidepanel-profile'>
				<img class='profile-background' src="/assets/common/img/panel-background.jpg" />
				<div class="row middle-xs">
                            <? if(!empty($customisation->logo)) { ?>
                            <div class='col-xs-4 center-xs'>
						<div class='box'>
							<img class="profile-thumbnail" src="<?=base_url('uploads/logos/thumbnails/thumb_'.$customisation->logo)?>" />
						</div>
					</div>
					<div class='col-xs-8 title'>
						<div class='box profile-text'>
							<strong><?=$est->name?></strong>
						</div>
					</div>
                            <? } else { ?>
                            <div class='col-xs-12 title'>
						<div class='box profile-text'>
							<strong><?=$est->name?></strong>
						</div>
					</div>
                            <? } ?>
                        </div>
			</div>
		</a>   
		
		<!-- PANEL MENUS --> 
		<? if(count($categories)==0) { ?>
		<div>
			<br /> <br /> La carte de cet établissement n'a pas encore été configurée.
		</div>
		<? } else { ?>
		<div data-role="collapsible-set" data-inset="false" class="main_menu">
			<!--  CATEGORIES -->
			<div data-role="collapsible" data-inset="false" data-collapsed-icon="carat-d" data-expanded-icon="carat-d" data-iconpos="right" data-collapsed="<?=$main_menu['categories']?>">
				<h3>Carte</h3>
				<ul data-role="listview" data-inset="false" data-icon="carat-r">
				<? foreach($categories as $k=>$v) { ?>
					<li><a href="/user/category/<?=$k?>?est_id=<?=$est->id?>" class="categories_navigation" data-prefetch data-dom-cache="true"><?=$v['name']?></a></li>
				<? } ?>
				</ul>
			</div>
			
			<!-- MENUS -->
            <? if($modules->menus && count($menus)>0) { ?>
            <div data-role="collapsible" data-inset="false" data-collapsed-icon="carat-d" data-expanded-icon="carat-d" data-iconpos="right" data-collapsed="<?=$main_menu['menus']?>">
				<h3>Menus</h3>
				<ul data-role="listview" data-inset="false" data-icon="carat-r">
				<? foreach($menus as $k=>$v) { ?>
					<li><a href="/user/menus/<?=$v->id?>?est_id=<?=$est->id?>" class="menus_navigation" data-prefetch data-dom-cache="true"><?=$v->name?></a></li>
				<? } ?>
				</ul>
			</div>
			<? } ?>
			 
		</div>
		<? } ?>
		<div class="back_to_smartmenu">
		<a href="<?=base_url()?>" data-ajax=false>Quitter</a> - smartmenu.fr &copy<?=date('Y');?>
		</div>
	</div>
	<!-- END PANEL -->


	<!-- HEADER -->
	<div data-role="header" data-position="fixed" class="main_header">
		<a id="categories" href="<?=$nav_icon_href?>" class="ui-btn ui-btn-left">
		<?=$nav_icon?>
		</a>
		<h1 class="main_title">
			<a href="#" style="color: inherit; text-decoration: none; white-space: normal;">
        	<?=$header?>
            </a>
		</h1>
		<a href="/user/order?est_id=<?=$est->id?>" class="ui-btn ui-btn-right waves-effect waves-button order_button" id="order_button" style="<? if($order==false) echo "display:none;"; ?>"> <i class="zmdi zmdi-shopping-cart"></i>
		</a>
	</div>


	<!--  CONTENT -->
	<div role="content" class="ui-content main_content" data-inset="false">
	<? if(isset($debug)) { echo "DEBUG : <br />",$debug; } ?>
	<?=$output?>
    <?
	if(isset($toast)&&!empty($toast)){
		echo $toast;
	}
	?>
	</div>


</body>
<!-- ASSETS JS/CSS -->
<? foreach($css as $file){ ?><link href="<?=$file?>" rel="stylesheet"><? } ?>
<? foreach($js as $file){ ?><script type="text/javascript" src="<?=$file?>"></script><? } ?>

</html>