<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/mod_social_check_form')?>
<div class="tile">
    <div class="t-body tb-padding">        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label>Facebook (identifiant de Page Facebook)</label>
                    <div class="input-group" data-trigger="hover" data-toggle="popover" data-placement="left" data-content="L'identifiant de Page Facebook se trouve dans : Facebook > Paramètres > Informations sur la page > Identifiant de Page Facebook" data-original-title="Identifiant de Page Facebook">
                        <span class="input-group-addon last"><i class="zmdi zmdi-facebook-box"></i></span>
                        <input type="text" name="facebook" value="<?=set_value('facebook', $facebook)?>" class="form-control" placeholder="Le lien vers votre page Facebook" />
                    </div>
                    <?=form_error('facebook')?>
                </div>
            </div>        
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label>Twitter</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-twitter-box"></i></span>
                        <input type="text" name="twitter" value="<?=set_value('twitter', $twitter)?>" class="form-control" placeholder="Le lien vers votre page Twitter" />
                    </div>
                    <?=form_error('twitter')?>
                </div>
            </div>       
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label>Instagram</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-instagram"></i></span>
                        <input type="text" name="instagram" value="<?=set_value('instagram', $instagram)?>" class="form-control" placeholder="Le lien vers votre page Instagram" />
                    </div>
                    <?=form_error('instagram')?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Enregistrer les informations des réseaux sociaux</button>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>