<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/customisation_check_form', array('enctype'=>'multipart/form-data', 'id' => 'form_customisation'))?>
<div class="tile">
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                        La fonction "Aperçu de votre carte" vous permet d'avoir un rendu sur différents supports.
                        <a href="/manager/help#custom" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="form-group">
                    <label>Aperçu de votre carte</label>
                    <br />
                    <div class="preview_buttons">
                        <a href='/manager/preview/user' target="_blank" type="button" class="btn btn-info btn-sm">Aperçu sur votre écran</a>
                    </div>
                    <div class="preview_buttons">
                        <a href='/manager/preview/mobile' target="_blank" type="button" class="btn btn-info btn-sm hidden-xs">Aperçu smartphone</a>
                    </div>
                    <div class="preview_buttons">
                        <a href='/manager/preview/tablet' target="_blank" type="button" class="btn btn-info btn-sm hidden-xs hidden-sm">Aperçu tablette</a>
                    </div>
                    <div style="clear:left;"></div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                        Téléchargez votre logo, il s'affichera automatiquement dans différents endroits de votre carte.
                        <a href="/manager/help#custom" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                <div class="form-group">
                    <label>Logo de votre établissement</label>
                    <? if(!empty($customisation->logo)) { ?>           
                    <img class="image_view_establishment" src="<?=base_url("/uploads/logos/".$customisation->logo)?>?t=<?=time()?>"></img>
                    <? } else { ?>
                    <p>
                        <em>
                        Aucun logo défini.
                        </em>
                    </p>
                    <? } ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                        <div>
                            <span class="btn btn-info btn-file">
                                <? if(!empty($customisation->logo)) { ?>
                                <span class="fileinput-new">Changer d'image</span>
                                <? } else { ?>
                                <span class="fileinput-new">Ajouter une image</span>
                                <? } ?>
                                <span class="fileinput-exists">Changer</span>
                                <input type="file" name="logo" value="" />
                            </span>
                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Supprimer</a>
                            <?
                            if(isset($logo_error)){
                               foreach($logo_error as $k){
                                    echo "<div class='has-error'><small class='help-block'>$k</small></div>";
                               }
                            }
                            ?>
                            <div class='has-warning'>
                                <small class='help-block'>
                                Votre image doit faire moins de 8Mo.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-info btn-sm">Enregistrer votre logo</button>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                        Décrivez votre établissement, donnez les informations telles que les horaires
                        d'ouverture, ce qui vous démarque des autres,...
                        Cette présentation sera la page d'accueil de votre carte.
                        <a href="/manager/help#custom" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                <div class="form-group">
                    <label>Présentation de votre établissement</label>
                    <textarea name="presentation" id="presentation"><?=$customisation->presentation?></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-info btn-sm">Enregistrer la présentation</button>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 m-t-20">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                        Modifier l'image de fond de votre carte pour mieux refléter l'image de votre établissement. Notez que ces images sont des motifs qui sont répétés
                        pour remplir entièrement les dimensions de l'écran.
                        <a href="/manager/help#custom" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Image de fond de votre carte</label>
                    <br />
                    <div class="toggle-switch m-t-10 m-b-10">
                        <input id="no_image" type="checkbox" hidden="hidden" name="no_image" <? if(empty($customisation->background_image)) echo 'checked="checked"'; ?> >
                        <label for="no_image" class="ts-helper"></label>
                        <label for="no_image" class="ts-label m-l-5">
                        Ne pas utiliser d'image (le fond de votre carte sera blanc par défaut).
                        </label>
                    </div>
                    <br />
                    <?
                    $display = (empty($customisation->background_image)) ? 'display:none;' : 'display:inline;';
                    foreach($img_background_default as $k => $file){
                        $sel = ($customisation->background_image == $file) ? 'selected' : '';
                        echo "<img class='background_image $sel' src='$img_background_default_path/$file' data-file='$file' style='$display' />";
                    } ?>
                    <input type="hidden" name="image" id="background_image" value="<?=$img_background_default[0]?>" />                    
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-info btn-sm hec-save">Enregistrer l'image de fond</button>
            </div>
        </div>
        
    </div>
</div>
<?=form_close()?>