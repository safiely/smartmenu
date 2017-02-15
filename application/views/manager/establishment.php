<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/establishment_check_form', array('enctype'=>'multipart/form-data'))?>
<div class="tile">
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                        Ce formulaire correspond aux informations de base de votre établissement telles que son nom, son adresse, etc...
                        L'adresse web d'accès à votre carte est très importante.
                        <a href="/manager/help#est" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Nom de votre établissement</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-store"></i></span>
                        <input type="text" name="name" id="name" value="<?=set_value('name', $est->name)?>" class="form-control" placeholder="Le nom de votre établissement" />
                    </div>
                    <?=form_error('name')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <label>Adresse web d'accès à votre carte</label>
                <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                <div class="input-group" data-trigger="hover" data-toggle="popover" data-placement="left" data-content="Déterminez l'adresse d'accès à votre carte. Elle sera de la forme <?=base_url()?>votre-etablissement." data-original-title="Adresse d'accès à votre carte pour vos clients.">
                    <span class="input-group-addon last"><i class="zmdi zmdi-smartphone-android"></i></span>
                    <span class="input-group-addon last p-5"><?=domain_name_human()?>/</span>
                    <input type="text" name="url" id="est_url" value="<?=set_value('url', $est->url)?>" class="form-control" placeholder="votreetablissement" />
                    <input type="hidden" id="url_helper" disabled="disabled" value="<?=$url_helper?>" />
                </div>
                <div class='has-warning'>
                    <small class='help-block'>
                    1 à 64 caratères alpha-numériques. Les tirets - et _ sont acceptés.
                    </small>
                </div>
                <? if($est->url == $est->id) { ?>
                Une adresse web par défaut vous a été attribué, vous pouvez la modifier.
                <? } ?>
                <?=form_error('url')?>
                <label>QR Code d'accès à votre carte</label>
                <div>
                <img src="http://chart.apis.google.com/chart?chs=150x150&cht=qr&chld=L|0&chl=<?=$est->qrcode?>" id="qrcode" />
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Numéro et nom de la rue</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-my-location"></i></span>
                        <input type="text" name="adress" value="<?=set_value('adress', $est->adress)?>" class="form-control" placeholder="L'adresse postale de votre établissement" />
                    </div>
                    <?=form_error('adress')?>
                </div>
            </div>        
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Code postal</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-local-post-office"></i></span>
                        <input type="text" name="postal_code" value="<?=set_value('postal_code', $est->postal_code)?>" class="form-control" />
                    </div>
                    <?=form_error('postal_code')?>
                </div>
            </div>       
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Ville</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-city-alt"></i></span>
                        <input type="text" name="city" value="<?=set_value('city', $est->city)?>" class="form-control" />
                    </div>
                    <?=form_error('city')?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                Géolocalisation de votre adresse :
                <?
                if(!empty($est->geo_lat) && floatval($est->geo_lat)>0 && !empty($est->geo_lng) && floatval($est->geo_lng)>0) { 
                    echo '<span style="color:green;">ok</span>';
                } else { 
                    echo '<span style="color:#ff9800;">impossible à géolocaliser</span> (merci de vérifier l\'exactitude de votre adresse)';
                }
                ?>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Téléphone</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-phone"></i></span>
                        <input type="text" name="phone" value="<?=set_value('phone', $est->phone)?>" class="form-control" placeholder="ex : 0561874526" />
                    </div>
                    <?=form_error('phone')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Site web</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-globe-alt"></i></span>
                        <input type="text" name="web_site" value="<?=set_value('web_site', $est->web_site)?>" class="form-control" placeholder="Le site web de votre établissement" />
                    </div>
                    <?=form_error('web_site')?>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Enregistrer les informations établissement</button>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>