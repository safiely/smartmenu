<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="page-header">
    <div class="row">
        <div class="col-xs-12">
		<h1>Nouveau mot de passe</h1>
		<p class="lead">Pour ré-initaliser votre mot de passe, veuillez saisir votre mail, puis le nouveau mot de passe.</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	    <span style="color:red;"><?=$message?></span>
	    <?=form_open('home/forgotten_password_check_form')?>
	    <div class="form-group text-left">
		    <label for="email">Votre email</label>
		    <input type="email" class="form-control" name="email" value="<?=set_value('email', $mail)?>" />
		    <?=form_error('email')?>
	    </div>
	    <div class="form-group text-left">
		    <label for="password">Nouveau mot de passe</label>
		    <input type="password" class="form-control" name="password" value="<?=set_value('password')?>" />
		    <i>6 à 12 caractères alpha-numérique</i>
		    <?=form_error('password')?>
	    </div>
	    <div class="form-group text-left">
		    <label for="passwordConfirm">Confirmez votre nouveau mot de passe</label>
		    <input type="password" class="form-control" name="passwordConfirm" value="<?=set_value('passwordConfirm')?>" />
		    <?=form_error('passwordConfirm')?>
	    </div>
	    <div class="clearfix"></div>
	    <button type="submit" class="btn btn-primary">Ré-initialiser le mot de passe</button>
	    <?=form_close()?>
    </div>
</div>
<hr />
<div class="row last">
        <div class="col-xs-12">
	    <a href="/home/login">Revenir à la page de connexion</a>
	    
    </div>
</div>
