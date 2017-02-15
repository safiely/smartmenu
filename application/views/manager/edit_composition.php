<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/edit_composition_check_form/'.$composition->compo_id, array('id' => 'form_composition'))?>
<div class="tile">
    <div class="t-header p-b-0">
        <div class="th-title">
            Modifier la section "<?=$composition->compo_name?>" de votre menu "<?=$composition->menu_name?>".
        </div>
    </div>
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                            Sélectionnez les différents produits proposés dans la section de votre menu.
                            Vous pouvez aussi modifier le nom ou la description de cette section.
                            <a href="/manager/help#menu" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label>Nom de la section</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-view-headline"></i></span>
                        <input type="text" name="composition_name" value="<?=set_value('composition_name', $composition->compo_name)?>" class="form-control" />
                    </div>
                    <?=form_error('composition_name')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                <div class="form-group">
                    <label>Informations complémentaires</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-info-outline"></i></span>
                        <input type="text" name="composition_note" value="<?=set_value('composition_note', $composition->compo_note)?>" class="form-control" maxlength="256" placeholder="Informations particulières concernant cette section." />
                    </div>
                    <?=form_error('composition_note')?>
                </div>
            </div>
        </div>
        
        <? if($composition->prices_categories==1) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="form-group">
                    <label>Catégories de prix</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="form-group">
                        <select name="prices_cat" class="selectpicker">
                            <?
                            foreach($prices_categories as $k => $prices_cat) {
                                echo "<option value='",$prices_cat->id,"' ",$prices_cat->selected,">",$prices_cat->name,"</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <? } ?>
        
        <div class="row m-b-20">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                <button type="button" class="btn btn-primary btn-sm m-t-10 save_composition">
                    Enregistrer les modifications
                </button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                <button type="button" class='btn btn-warning btn-sm m-t-10 delete_composition' data-id="<?=$composition->compo_id?>">
                    Supprimer cette section
                </button>
            </div>
        </div>
        
        
        <? if(count($products)>0) { ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label style="font-size:larger;">
                    <? if($composition->prices_categories==1) { ?>
                    Produits que vous proposez dans cette section :
                    <? } else { ?>
                    Sélectionnez les produits que vous souhaitez proposer dans cette section :
                    <? } ?>
                    </label>
                    <? if($linked_cat == '1') { ?>
                        <? foreach($products as $k => $prod) { ?>
                        <div class="checkbox cr-alt m-b-20">
                            <label>
                                <input type="checkbox" name="prod_ids[<?=$prod->id?>]" <?=$prod->checked?> class="product_selection">
                                <i class="input-helper"></i>
                                <?=$prod->name?>
                            </label>
                        </div>
                        <? } ?>
                        <a href="/manager/add_product/<?=$composition->cat_id?>">Ajouter un nouveau produit à cette catégorie</a>
                    <? } else { ?>
                        <br />
                        <? foreach($products as $key => $prods) {
                            $collapse = (isset($products[$key]['selection'])) ? 'in' : '' ;
                            ?>
                        <div class="panel-group" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-collapse">
                                <div class="panel-heading" role="tab" id="heading_<?=$products[$key]['cat_id']?>">
                                    <h4 class="panel-title">
                                        <a class="collapsed" data-toggle="collapse" href="#collapse_<?=$products[$key]['cat_id']?>" aria-expanded="false" aria-controls="collapse_<?=$products[$key]['cat_id']?>">
                                        <?=$products[$key]['cat_name']?>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div id="collapse_<?=$products[$key]['cat_id']?>" class="collapse <?=$collapse?>" role="tabpanel" aria-labelledby="heading_<?=$products[$key]['cat_id']?>">
                                <div class="panel-body">
                            <? foreach($prods as $k => $prod) { ?>
                                <? if(is_int($k)) { ?>
                                    <div class="row m-b-20">
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <div class="checkbox cr-alt m-b-5">
                                                <label>
                                                    <input type="checkbox" name="prod_ids[<?=$prod->id?>]" <?=$prod->checked?> class="product_selection" data-prod-id="<?=$prod->id?>">
                                                    <i class="input-helper"></i>
                                                    <?=$prod->name?>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <? if(count($prods['prices_categories'])>0) {
                                                $display = (!empty($prod->checked)) ? '' : 'hide' ;
                                                ?>
                                            <select class="selectpicker <?=$display?>" name="prices_cat_for_product[<?=$prod->id?>]" id="prices_cat_select_<?=$prod->id?>">
                                                <? foreach($prods['prices_categories'] as $i => $prices_cat) {
                                                    $sel = ($prod->txt_prices_cat == $prices_cat->name) ? 'selected' : '';
                                                    ?>
                                                <option value="<?=$prices_cat->id?>" <?=$sel?>><?=$prices_cat->name?></option>
                                                <? } ?>
                                            </select>
                                            <? } ?>
                                        </div>
                                    </div>
                                <? } ?>
                            <? } ?>
                                <a href="/manager/add_product/<?=$prods['cat_id']?>">Ajouter un nouveau produit à cette catégorie</a>
                                </div>
                            </div>
                        <? } ?>
                        <a href="/manager/add_category">Ajouter une nouvelle catégorie de produits</a>
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                <button type="button" class="btn btn-primary btn-sm m-t-10 save_composition">
                    Enregistrer les modifications
                </button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                <button type="button" class='btn btn-warning btn-sm m-t-10 delete_composition' data-id="<?=$composition->compo_id?>">
                    Supprimer cette section
                </button>
            </div>
        </div>
        <? } ?>
    </div>
</div>
<?=form_close()?>










