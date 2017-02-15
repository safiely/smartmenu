<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/edit_product_check_form/'.$product->id, array('id'=>'edit_product_form', 'enctype'=>'multipart/form-data'))?>
<div class="tile">
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                        Cette page vous permet de modifier les informations d'un produit.
                        <a href="/manager/help#prod" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label>Catégorie</label>
                    <br />
                    <select name="category" class="selectpicker" id="select_category" data-hide-disabled="true">
                        <?
                        foreach($categories as $cat_id=>$cat) {
                            $selected = ($cat_id==$product->cat_id) ? 'selected="selected"' : '';
                            $prices_cat = (count($cat['prices_cat'])>0) ? '1' : '0' ;
                        ?>
                        <option value='<?=$cat_id?>' <?=$selected?> data-prices-cat='<?=$prices_cat?>' ><?=$cat['name']?></option>
                        <? } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Nom du produit</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-pizza"></i></span>
                        <input type="text" name="name" id="name" value="<?=set_value('name', $product->name)?>" class="form-control" placeholder="ex : Spaghetti bolognaise" maxlength=128 />
                    </div>
                    <?=form_error('name')?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Composition</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-cutlery"></i></span>
                        <input type="text" name="composition" value="<?=set_value('composition', $product->composition)?>" class="form-control" placeholder="La composition ou la description de votre produit" />
                    </div>
                    <?=form_error('composition')?>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                <div class="form-group">
                    <label>Prix</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <!--Prix unique--->
                    <div class="unique_price">
                        <div class="input-group">
                            <span class="input-group-addon last"><i class="zmdi zmdi-money"></i></span>
                            <input type="text" id="unique_price_value" name="price" value="<? if(is_array($product->price)) { echo set_value('price', 0); } else { echo set_value('price', $product->price); } ?>" class="form-control" placeholder="ex : 9,5" />
                        </div>
                        <?=form_error('price')?>
                    </div>
                    <!--Catégorie de produit-->
                    <?
                    foreach($categories as $cat_id=>$cat) {
                        if(count($cat['prices_cat'])>0) { ?>
                            <div class="prices_category prices_category_<?=$cat_id?>">
                            <? foreach($cat['prices_cat'] as $k => $prices) {
                                $value = (isset($product->price[$k]->price)) ? $product->price[$k]->price : 0;
                                ?>
                                <div class="input-group">
                                    <span class="input-group-addon last" style="width:50%;"><?=$prices->name?></span>                                    
                                    <input type="text" name="prices_category[<?=$cat_id?>][<?=$prices->id?>]" value="<?=set_value('prices_category['.$cat_id.']['.$prices->id.']', $value)?>" class="form-control prices_cat_<?=$cat_id?>_value prices_cat_values" pattern="^(\d+(?:[\.,][\d]{1,2})?)$" />
                                    <span class="input-group-addon"><i class="zmdi zmdi-money"></i></span>
                                </div>
                                <?=form_error('prices_category[][]')?>
                            <? } ?>
                            <a href="/manager/edit_prices_categories/<?=$product->cat_id?>">Modifier les catégories de prix</a>
                            </div>
                        <? }
                    }
                    ?>
                    <input type="hidden" name="prices_categories" id="prices_categories" value="" />
                </div>
            </div>
        </div>
        <hr />
        <? if($mod_suggest == 1) { ?>
        <div class="row">
            <div class="col-lg-12 p-t-10 p-b-10">
                <div class="toggle-switch">                    
                    <input id="suggest" type="checkbox" hidden="hidden" name="suggest" <? if($product->suggest==1) echo 'checked';?> >
                    <label for="suggest" class="ts-helper"></label>
                    <label for="suggest" class="ts-label m-l-5">
                    Mettre ce produit en avant
                    </label>
                    <span class="toggle_switch_helper">
                        <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> Vous permet de rendre ce produit plus visible pour vos clients.
                    </span>
                </div>
            </div>
        </div>
        <? } ?>
        <div class="row">
            <div class="col-lg-12 p-t-10 p-b-10">
                <div class="toggle-switch">
                    <input id="not_in_card" type="checkbox" hidden="hidden" name="not_in_card" <? if($product->not_in_card==1) echo 'checked';?> >
                    <label for="not_in_card" class="ts-helper"></label>
                    <label for="not_in_card" class="ts-label m-l-5">
                    Ne pas proposer ce produit à la carte
                    </label>
                    <span class="toggle_switch_helper">
                        <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> Produit non-vendu à la carte.
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 p-t-10 p-b-10">
                <div class="toggle-switch">
                    <input id="sold_out" type="checkbox" hidden="hidden" name="sold_out" <? if($product->sold_out==1) echo 'checked';?> >
                    <label for="sold_out" class="ts-helper"></label>
                    <label for="sold_out" class="ts-label m-l-5">
                    Rupture de stock
                    </label>
                    <span class="toggle_switch_helper">
                        <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> Produit en rupture de stock.
                    </span>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Image du produit</label>                
                    <? if(!empty($product->image)) { ?>
                    <img style="max-width:100%;display:block;" src="<?=base_url('/uploads/products/'.$product->image)?>"></img>
                    <? } else { ?>
                    <p>
                        <em>
                        Aucune image n'est associée à ce produit.
                        </em>
                    </p>
                    <? } ?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 m-t-5-xs">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                        <div>
                            <span class="btn btn-info btn-file">
                                <? if(!empty($product->image)) { ?>
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
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Enregistrer les modifications</button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                <button type="button" class="btn btn-warning btn-sm m-t-10 delete_product" data-id="<?=$product->id?>" data-cat-id="<?=$product->cat_id?>">Supprimer ce produit</button>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>
<button class='btn btn-success add_product_button' data-cat-id="<?=$product->cat_id?>">
    <i class="zmdi zmdi-pizza zmdi-hc-fw"></i>
    <span>Ajouter un nouveau produit</span>
</button>
