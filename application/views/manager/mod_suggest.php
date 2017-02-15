<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div class="tile">
    <? if(count($categories)==0) { ?>
        <div class="t-header">
            <div class="th-title">
                Aucun produit n'est mis en avant sur votre carte.
                <br />
                Pour mettre un produit en avant sur votre carte, cochez l'option "Mettre le produit en avant" dans la fiche produit.
            </div>            
        </div>
    <? } else { ?>
        <table class="table table-responsive table-bordered table-striped m-b-10">
            <?
            foreach($categories as $cat_name => $prod) {
            ?>
            <thead class="bg-green">
                <tr>
                	<th>&nbsp;</th>
                	<th colspan=2><?=$cat_name?></th>
                </tr>
            </thead>
            <tbody>
            <? foreach($prod as $prod_name => $product) {?>
                    <tr class="selectionable">
                        <td style="width:1%;">
                        <img style="width:64px;height:64px;" src="<?=$product->image?>" />
                        </td>
                        <td class="col-xs-8">
                            <strong>
                            <a href="/manager/edit_product/<?=$product->id?>" class="fast_link">
                            <?=$product->name?>
                            </a>
                            </strong>
                        </td>
                        <td class="col-xs-4">		                
		                	<a href="/manager/remove_suggestion/<?=$product->id?>">Supprimer la mise en avant de ce produit</a>
                        </td>
                    </tr>
                <? } ?>
                </tbody>
                <? } ?>
        </table>
        <? } ?>
</div>