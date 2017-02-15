<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tile">
    <table class="table table-responsive table-bordered table-striped" id="table_categories">
        <thead class="bg-green">
            <tr>
                <? if($one_image==true) { ?>
                <th style="width:1%;" class="text-center hidden-xs">&nbsp;</th>
                <? } ?>                
                <th class="col-xs-12 col-sm-12 col-md-8 col-lg-9">Catégorie de produits</th>
                <th class="col-md-4 col-lg-3 hidden-xs hidden-sm">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach($categories as $cat_id=>$cat){
                $number_of_prices_cat = (!empty($cat['prices_cat'])) ? $cat['prices_cat'] : '<span class="p-r-5 p-l-5">Aucune quantité définie pour cette catégorie.</span>';
            ?>
            <tr id="category-<?=$cat_id?>" class="selectionable">
                <? if($one_image==true) { ?>
                <td class="hidden-xs">
                    <? if($cat['image']!='0') { ?>
                    <img style="width:64px;height:64px;" src="<?=$img_cat_default_path?>/<?=$cat['image']?>" />
                    <? } ?>
                </td>
                <? } ?>
                
                <td>
                    <a href="/manager/edit_prices_categories/<?=$cat_id?>" class="fast_link">
                    <strong><?=$cat['name']?></strong>
                    </a>                        
                    <i class="zmdi zmdi-caret-right zmdi-hc-fw hidden-xs"></i>
                    <a href="/manager/edit_prices_categories/<?=$cat_id?>">
                    <span class="hidden-xs"><?=$number_of_prices_cat?></span>
                    </a>
                </td>
                <td class="hidden-xs hidden-sm">
                    <button class='btn btn-primary edit_category' data-id="<?=$cat_id?>">Modifier</button>
                </td>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>
