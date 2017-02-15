<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tile">    
    <div class="t-header p-b-0">
        <div class="th-title">
            Quantités
        </div>
    </div>
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                            Les quantités permettent de proposer des produits sous différentes formes.
                            Pour une catégorie Vins, les quantités pourraient être Verre, Pichet et Bouteille.
                            <a href="/manager/help#cat" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?=form_open('manager/add_prices_category_check_form/'.$id)?>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Ajouter une quantité</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-view-toc"></i></span>
                        <input type="text" id="prices_category_name" name="prices_category_name" value="<?=set_value('prices_category_name', $prices_category_name)?>" class="form-control" placeholder="ex : Au verre" />
                    </div>
                    <?=form_error('prices_category_name')?>
                </div>             
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-12 text-left">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Ajouter cette quantité</button>
            </div>
        </div>
        <?=form_close()?>
    </div>
  
    
    
    <? if(count($prices_cat)>0) { ?>        
        <table class="table table-responsive table-bordered table-striped" id="table_prices_categories">
            <thead class="bg-green">
                <tr>
                    <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center">Ordre d'affichage</th>
                    <th class="col-xs-10 col-sm-8 col-md-8 col-lg-8">Nom</th>
                    <th class="col-sm-2 col-md-2 col-lg-2 hidden-xs">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?
                foreach($prices_cat as $k => $cat){
                    $hidden_up = ($cat->rank>1) ? '' : 'invisible';
                    $hidden_down = ($cat->rank<count($prices_cat)) ? '' : 'invisible';
                ?>
                <tr id="prices-category-<?=$cat->id?>" class="selectionable">
                    <td class="text-center order_display">
                        <? if(count($prices_cat)>1) { ?>
                        <i class="zmdi zmdi-long-arrow-up zmdi-hc-fw <?=$hidden_up?> ascend_prices_cat" data-id='<?=$cat->id?>' data-rank='<?=$cat->rank?>' data-cat-id='<?=$id?>'></i>
                        <i class="zmdi zmdi-long-arrow-down zmdi-hc-fw  <?=$hidden_down?> descend_prices_cat" data-id='<?=$cat->id?>' data-rank='<?=$cat->rank?>' data-cat-id='<?=$id?>'></i>
                        <? } else { ?>
                         <i class="zmdi zmdi-minus zmdi-hc-fw"></i>
                        <? } ?>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="<?=$cat->id?>" value="<?=$cat->name?>" class="form-control" />
                                <span class="input-group-addon first">
                                    <button type="button" class="btn btn-primary edit_prices_category_name" data-id="<?=$cat->id?>">Modifier</button>
                                </span>
                            </div>
                        </div>
                        <button class='btn btn-warning delete_prices_category pull-right hidden-lg hidden-md hidden-sm' data-id="<?=$cat->id?>">
                        <i class="zmdi zmdi-delete zmdi-hc-fw"></i>
                        <span>Supprimer</span>
                        </button>
                    </td>
                    <td class="hidden-xs">
                        <button class='btn btn-warning delete_prices_category pull-right' data-id="<?=$cat->id?>">
                        <i class="zmdi zmdi-delete zmdi-hc-fw"></i>
                        <span>Supprimer</span>
                        </button>
                    </td>
                </tr>
                <? } ?>
            </tbody>
        </table>
    <? } ?>
</div>