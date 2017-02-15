<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/add_category_check_form', array('id'=>'add_category_form'))?>
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
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label>Nom de la catégorie de produits</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-library"></i></span>
                        <input type="text" name="name" id="name" value="<?=set_value('name')?>" class="form-control" placeholder="ex : Nos plats" />
                    </div>
                    <?=form_error('name')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="form-group">
                    <label>Description</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-info-outline"></i></span>
                        <input type="text" name="description" id="description" value="<?=set_value('description')?>" class="form-control" placeholder="ex : Tous nos plats sont servis avec des frites ou de la salade." />
                    </div>
                    <?=form_error('description')?>
                </div>
            </div>            
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Image associée</label>
                    <br />
                    <div class="toggle-switch m-t-10 m-b-10">
                        <input id="no_image" type="checkbox" hidden="hidden" name="no_image" >
                        <label for="no_image" class="ts-helper"></label>
                        <label for="no_image" class="ts-label m-l-5">
                        Ne pas utiliser d'image pour cette catégorie de produits
                        </label>
                    </div>
                    <br />
                    <? foreach($img_cat_default as $k => $file){
                        $sel = ($k=='1') ? 'selected' : '';
                        echo "<img class='category_image $sel' src='$img_cat_default_path/$k-$file' data-file='$k-$file' />";
                    } ?>
                    <input type="hidden" name="image" id="category_image" value="1-plate.png" />
                    <div id="category_image_help_text">
                        <br />
                        Ce sera l'image par défaut utilisée pour cette catégorie de produits.
                        <br />
                        Les produits qui n'ont pas d'image définie utiliseront cette image.
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Créer cette catégorie de produits</button>
                <a name="manage"></a>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>
