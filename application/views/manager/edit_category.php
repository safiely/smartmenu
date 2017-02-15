<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tile">
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                            Les catégories de produits vous permettent de classer vos produits par groupes (ex : Entrées, Plats, Desserts, etc...).
                            <a href="/manager/help#cat" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?=form_open('manager/edit_category_check_form/'.$id)?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label>Nom de la catégorie de produits</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-library"></i></span>
                        <input type="text" name="name" value="<?=set_value('name', $name)?>" class="form-control" placeholder="ex : Nos entrées" />
                    </div>
                    <?=form_error('name')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="form-group">
                    <label>Description</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-info-outline"></i></span>
                        <input type="text" name="description" id="description" value="<?=set_value('description', $description)?>" class="form-control" placeholder="ex : Tous nos plats sont servis avec des frites ou de la salade." />
                    </div>
                    <?=form_error('description')?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Image associée</label>
                    <br />
                    <div class="toggle-switch m-t-10 m-b-10">
                        <input id="no_image" type="checkbox" hidden="hidden" name="no_image" <? if($image=='0') echo 'checked'; ?> >
                        <label for="no_image" class="ts-helper"></label>
                        <label for="no_image" class="ts-label m-l-5">
                        Ne pas utiliser d'image pour cette catégorie de produits
                        </label>
                    </div>
                    <br />
                    <? foreach($img_cat_default as $k => $file){
                       $sel = ($file==$image) ? 'selected' : '';
                       $display = ($image=='0') ? 'display:none' : 'display:inline';
                       echo "<img class='category_image $sel' src='$img_cat_default_path/$file' data-file='$file' style='$display' />";
                    } ?>
                    <input type="hidden" name="image" id="category_image" value="<?=$image?>" />
                    <div id="category_image_help_text" style="<? if($image=='0') echo 'display:none;'; ?>" >
                        <br />
                        Ce sera l'image par défaut utilisée pour cette catégorie de produits.
                        <br />
                        Les produits qui n'ont pas encore d'image définie utiliseront cette image.
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Modifier cette catégorie de produits</button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                <button type="button" class='btn btn-warning btn-sm m-t-10 delete_category' data-id="<?=$id?>">Supprimer cette catégorie de produits</button>
            </div>
            <a name="prices_cat"></a>
        </div>
        <?=form_close()?>
    </div>    
</div>