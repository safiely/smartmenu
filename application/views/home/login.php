<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="page-header">
    <div class="row">
        <div class="col-xs-12">
            <h1>Connexion</h1>
	    <p class="lead">Connectez-vous à votre interface administrateur.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
		<span style="color:red;"><?=$message?></span>
		<?=form_open('home/login_check_form');?>
		<div class="form-group text-left">
			<label>Votre email</label>
			<input type="email" class="form-control" name="email" id="email" value="<?=set_value('email', $mail)?>" />
			<?=form_error('email')?>
		</div>
		<div class="form-group text-left">
			<label>Votre mot de passe</label>
			<input type="password" class="form-control" name="password" />
			<?=form_error('password')?>
		</div>
		<div class="clearfix"></div>
		<button type="submit" class="btn btn-success">Se connecter</button>
		<br />
		<br />
		<a href="/home/forgotten_password">Mot de passe oublié ?</a>
	</div>
    </div>
    <hr />
    <div class="row last">
        <div class="col-xs-12">
		<a href="/home/registration">Vous n'avez pas encore de compte ? Inscrivez vous ici.</a>
		<?=form_close()?>
        </div>
    </div>
</div>
