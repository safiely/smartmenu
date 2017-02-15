<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<!--[if IE 9 ]><html class="ie9"><![endif]-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="format-detection" content="telephone=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="UTF-8">
        <meta name="description" content="<?=$description?>">
        <meta name="keywords" content="<?=$keywords?>">
        <title>Smartmenu.fr | <?=$title?></title>
	<link rel="icon" type="image/png" href="/assets/common/img/favicon.png" />
        <? foreach($css as $file){ ?><link href="<?=$file?>" rel="stylesheet"><? } ?>
	
	<!--[if lt IE 9]>
	<script src="/assets/theme_home/js/html5shiv.js"></script>
	<script src="/assets/theme_home/js/respond.min.js"></script>
	<![endif]-->
    </head>

    <body>
	<div class="navbar navbar-default navbar-fixed-top">
	    <div class="container <? if($pro==false) echo "container-users"; ?>">
			<div class="navbar-header <? if($pro==false) echo "navbar-users"; ?>">
				<a href="/" class="navbar-brand">
				    <img class="logo_header" src="<?=base_url('assets/theme_manager/img/smartmenu-logo-350px.png');?>">
				</a>
			    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			    <span class="icon-bar"></span>
			    </button>
			</div>
			<div style="height: 1px;" aria-expanded="false" class="navbar-collapse collapse" id="navbar-main">
			    <ul class="nav navbar-nav navbar-right">
				<? if($pro==true) { ?>
				    <li id='pros'><a href="/home/pros">Produit</a></li>
				    <li id='demos'><a href="/home/demos">Démonstrations</a></li>
				    <li id='prices'><a href="/home/prices">Prix</a></li>
				    <li id='contact'><a href="/home/contact">Contactez-nous</a></li>
				    <li id='registration'><a href="/home/registration">ESSAYEZ MAINTENANT</a></li>
				    <li id='login'><a href="/home/login">CONNEXION</a></li>
				<? } ?>
			    </ul>
			</div>
	    </div>
	</div>
	    
	    
	
	<div class="container <? if($pro==false) echo "container-users"; ?>">
	    <? if(isset($debug)) echo"<div><b style='color:red;'>DEBUG :</b> <br /><pre>$debug</pre></div>"; ?>
	    <? echo $output; ?>
	<footer>
	    <div class="row">
		<div class="col-xs-12">
		    <p>
		    <? if($pro==true) { ?>
		    <a href="<?=base_url()?>">Retour accueil</a>
		    <? } else { ?>
		    <a href="/home/pros">Espace pros</a>
		    <? } ?>
		    <span class="pull-right"><a href="/home/legal">smartmenu.fr &copy; <?=date('Y')?></a></span>
		    </p>
		</div>
	    </div>
	</footer>
	</div>
	
        <? foreach($js as $file){ ?><script type="text/javascript" src="<?=$file?>"></script><? } ?>
	<script>
	    <?if(!empty($active_page)){ ?>
	    $('#<?=$active_page?>').addClass('active');
	    <? } ?>
	</script>
    </body>
</html>