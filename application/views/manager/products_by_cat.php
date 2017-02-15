<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="tile">
    <? if($category['count_products']==0) { ?>
        <div class="t-header">
            <div class="th-title">
                Vous n'avez pas encore enregistré de produit, commencez par en ajouter un.
                <button class='btn btn-success add_product_button' data-cat-id="<?=$category['id']?>">
                    <i class="zmdi zmdi-pizza zmdi-hc-fw"></i>
                    <span>Ajouter un nouveau produit</span>
                </button>
            </div>            
        </div>
    <? } else {
        $number_of_products = ($category['count_products']>0) ? $category['count_products'].' '.single_or_plurial($category['count_products'], 'produit', 'produits') : '<span class="bg-orange p-r-5 p-l-5">Aucun produit enregistré</span>';
        ?>
        <table class="table table-responsive table-bordered table-striped m-b-10" id="table_category_<?=$category['id']?>">
            <thead class="bg-green">
                <tr>
                    <? if($one_image == true) { ?>
                    <th style="width:1%;" class="text-center">&nbsp;</th>
                    <? } ?>
                    <th class="col-xs-6 col-sm-3 col-md-1 col-lg-1">Ordre d'affichage</th>
                    <th class="col-xs-6 col-sm-5 col-md-3 col-lg-2">Nom du produit</th>
                    <th class="col-md-3 col-lg-3 hidden-xs hidden-sm">Description</th>
                    <th class="col-sm-2 col-md-1 col-lg-1 hidden-xs">Prix</th>
                    <th class="col-md-4 col-lg-2 hidden-xs hidden-sm">&nbsp;</th>
                </tr>
            </thead>
                <tbody>
                <?
                foreach($category['products'] as $prod_id => $prod) {
                    $hidden_up = ($prod->rank>1) ? '' : 'invisible';
                    $hidden_down = ($prod->rank<$category['count_products']) ? '' : 'invisible';
                    $suggest = ($prod->suggest) ? '<i class="zmdi zmdi-star zmdi-hc-fw" title="Produit mis en avant."></i>' : '';
                ?>
                    <tr class="selectionable">
                        <? if($one_image == true) { ?>
                        <td>
                            <? if(!empty($prod->image)) { ?>
                            <img style="width:64px;height:64px;" src="<?=$prod->image?>" />
                            <? } ?>
                        </td>
                        <? } ?>
                        <td class="text-center order_display">
                            <? if($category['count_products']>1) { ?>
                            <i class="zmdi zmdi-long-arrow-up zmdi-hc-fw <?=$hidden_up?> ascend" data-id='<?=$prod_id?>' data-rank='<?=$prod->rank?>'></i>
                            <i class="zmdi zmdi-long-arrow-down zmdi-hc-fw  <?=$hidden_down?> descend" data-id='<?=$prod_id?>' data-rank='<?=$prod->rank?>'></i>
                            <? } else { ?>
                            <i class="zmdi zmdi-minus zmdi-hc-fw"></i>
                            <? } ?>
                        </td>
                        <td>
                            <strong>
                            <a href="/manager/edit_product/<?=$prod_id?>" class="fast_link">
                            <?=$prod->name?>
                            </a>
                            </strong>
                            <?=$suggest?>
                            <? if($prod->not_in_card) { ?>
                            <br />
                            Ce produit n'est pas proposé dans votre carte.
                            <? } ?>
                            <? if($prod->sold_out) { ?>
                            <br />
                            <i class="zmdi zmdi-lock"></i>&nbsp;&nbsp;<span class="sold_out">Rupture de stock</span>
                            <? } ?>
                        </td>
                        <td class="hidden-xs hidden-sm"><?=$prod->composition?></td>
                        <td class="hidden-xs">
                        <?
                        if($prod->prices_categories==0) {
                            if($prod->price>0){
                                echo $prod->price," &euro;";
                            } else {
                                echo "<i class='zmdi zmdi-block-alt zmdi-hc-fw'></i>";
                            }
                        } else {
                            echo "<table class='multi_prices'>";
                            foreach($prod->price as $k => $prices_cat){
                                echo "<tr><td>",$prices_cat->name,"</td>";
                                if($prices_cat->price>0){
                                    echo "<td class='price'>",number_format($prices_cat->price, 2)," &euro;</td></tr>";
                                } else {
                                    echo "<td class='price'><i class='zmdi zmdi-block-alt zmdi-hc-fw'></i></td></tr>";
                                }
                            }
                            echo "</table>";
                        }
                        ?>
                        </td>
                        <td class="hidden-xs hidden-sm">
                            <button class='btn btn-primary edit_product' data-id="<?=$prod_id?>">Modifier</button>
                            <button class='btn btn-warning delete_product pull-right' data-id="<?=$prod_id?>" data-cat-id="<?=$category['id']?>">Supprimer</button>
                        </td>
                    </tr>
                <? } ?>
                </tbody>
        </table>
    <? } ?>
</div>

<button class='btn btn-success add_product_button' data-cat-id="<?=$category['id']?>">
    <i class="zmdi zmdi-pizza zmdi-hc-fw"></i>
    <span>Ajouter un nouveau produit</span>
</button>