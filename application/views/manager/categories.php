<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tile">
    <table class="table table-responsive table-bordered table-striped" id="table_categories">
        <thead class="bg-green">
            <tr>
                <? if($one_image==true) { ?>
                <th style="width:1%;" class="text-center hidden-xs">&nbsp;</th>
                <? } ?>
                <th class="col-xs-4 col-sm-4 col-md-2 col-lg-2 text-center">Ordre d'affichage</th>
                <th class="col-xs-8 col-sm-8 col-md-6 col-lg-7">Catégorie de produits</th>
                <th class="col-md-4 col-lg-3 hidden-xs hidden-sm">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach($categories as $cat_id=>$cat){
                $hidden_up = ($cat['rank']>1) ? '' : 'invisible';
                $hidden_down = ($cat['rank']<count($categories)) ? '' : 'invisible';
                $number_of_products = ($cat['count_products']>0) ? $cat['count_products'].' '.single_or_plurial(intval($cat['count_products']), 'produit', 'produits') : '<span class="c-red p-r-5 p-l-5">Aucun produit enregistré</span>';
            ?>
            <tr id="category-<?=$cat_id?>" class="selectionable">
                <? if($one_image==true) { ?>
                <td class="hidden-xs">
                    <? if($cat['image']!='0') { ?>
                    <img style="width:64px;height:64px;" src="<?=$img_cat_default_path?>/<?=$cat['image']?>" />
                    <? } ?>
                </td>
                <? } ?>
                <td class="text-center order_display">
                    <? if(count($categories)>1) { ?>
                    <i class="zmdi zmdi-long-arrow-up zmdi-hc-fw <?=$hidden_up?> ascend" data-id='<?=$cat_id?>' data-rank='<?=$cat->rank?>'></i>
                    <i class="zmdi zmdi-long-arrow-down zmdi-hc-fw  <?=$hidden_down?> descend" data-id='<?=$cat_id?>' data-rank='<?=$cat->rank?>'></i>
                    <? } else { ?>
                    <i class="zmdi zmdi-minus zmdi-hc-fw"></i>
                    <? } ?>
                </td>
                <td>
                    <a href="/manager/edit_category/<?=$cat_id?>" class="fast_link">
                    <strong><?=$cat['name']?></strong>
                    </a>                        
                    <i class="zmdi zmdi-caret-right zmdi-hc-fw hidden-xs"></i>
                    <a href="/manager/products_by_cat/<?=$cat_id?>">
                    <span class="hidden-xs"><?=$number_of_products?></span>
                    </a>
                    <? if(!empty($cat['description'])) { ?>
                    <br />
                    <?=$cat['description']?>
                    <? } ?>
                    <? if(!empty($cat['prices_cat'])) { ?>
                    <br />
                    Quantités : <?=$cat['prices_cat']?>
                    <i class="zmdi zmdi-caret-right zmdi-hc-fw hidden-xs"></i>
                    <a href="/manager/edit_prices_categories/<?=$cat_id?>">
                    modifier
                    </a>
                    <? } ?>
                </td>
                <td class="hidden-xs hidden-sm">
                    <button class='btn btn-primary edit_category' data-id="<?=$cat_id?>">Modifier</button>
                    <button class='btn btn-warning delete_category pull-right' data-id="<?=$cat_id?>">Supprimer</button>
                </td>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>
