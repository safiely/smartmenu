<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-xs-12">
            <h1>Inscription</h1>
	    <p class="lead" style="margin-bottom:0px;">
		Pour créer un compte, il vous suffit de renseigner votre e-mail et un mot de passe.
	    </p>
	    <p>
		Vous recevrez un email d'activation à l'adresse e-mail que vous avez indiquée afin de confirmer
	    votre inscription.
	    </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
	    <span style="color:red;"><?=$message?></span>
	    <?=form_open('home/registration_check_form')?>
	    <div class="form-group text-left">
		    <label for="email">Votre email</label>
		    <input type="email" class="form-control" name="email" id="email" value="<?=set_value('email')?>" />
		    <?=form_error('email')?>
	    </div>
	    <div class="form-group text-left">
		    <label for="password">Mot de passe</label>
		    <input type="password" class="form-control" name="password" value="<?=set_value('password')?>" />
		    <i>6 à 12 caractères alpha-numérique</i>
		    <?=form_error('password')?>
	    </div>
	    <div class="form-group text-left">
		    <label for="passwordConfirm">Confirmation de votre mot de passe</label>
		    <input type="password" class="form-control" name="passwordConfirm" value="<?=set_value('passwordConfirm')?>" />
		    <?=form_error('passwordConfirm')?>
	    </div>
	    <div class="clearfix"></div>
	    <button type="submit" class="btn btn-success">Inscription</button>
	    <br />
	    <br />
    </div>
</diV>
<div class="row last">
    <div class="col-xs-12">
	    <span class=red><b>Important : </b></span> certains logiciels de messagerie (ex : Hotmail, Outlook,...) ont des politiques
	    anti-spam arbitraires et opaques. N'oubliez pas de vérifier votre dossier "spam" si vous ne recevez pas ce mail dans votre
	    boîte de réception habituelle. Merci.
	    <hr />
	    <a href="/home/login">Vous possédez déjà un compte ? Connectez-vous ici.</a>
	    <?=form_close()?>
    </div>
</div>