<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row center-xs center-sm center-md- center-lg">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
        <div class="box">
            <div class="nd2-card">
                <? if(!empty($product->image)) { ?>
                <div class="card-media">
                    <img src="/uploads/products/<?=$product->image?>" />
                </div>
                <? } ?>
                
                <? if(!empty($product->composition)) { ?>
                <div class="card-supporting-text has-action text-left">
                    <?=$product->composition?>
                    <? if($product->suggest==1) { ?>        
                    <br /><i class="zmdi zmdi-star zmdi-hc-fw"></i> <i>Produit recommandé par l'établissement.</i>
                    <? } ?>
                </div>
                <? } ?>
                
                <div class="card-supporting-text has-action price">
                    <div class="pull-left text-left">
                        <strong><?=$category->name?><i class="zmdi zmdi-chevron-right zmd-fw"></i><?=$product->name?></strong>
                    </div>
                    <? if($product->prices_categories == 0) { ?>                    
                    <strong>Prix : <?=$product->price?> &euro;</strong>                    
                    <? } else {
                        foreach($product->price as $k => $prices_cat) {
                            if($prices_cat->price > 0) { ?>
                            <div class='row multi_prices'>
                                <div class="col-xs-7 start-xs ">
                                    <div class="box" id="prices_cat_name_<?=$prices_cat->id?>" style="text-align:left;"><?=$prices_cat->name?></div>
                                </div>
                                <div class="col-xs-3 end-xs">
                                    <div class="box" id="prices_cat_price_<?=$prices_cat->id?>" data-price="<?=$prices_cat->price?>"><?=$prices_cat->price?> &euro;</div>
                                </div>
                                <div class="col-xs-2 center-xs">
                                    <div class="box">
                                    <input type="radio" name="prices_categories" data-id="<?=$product->id?>" value="<?=$prices_cat->id?>" class="product_selected clickable" <? if($orderable != 1) echo 'disabled="disabled"'; ?> />
                                    </div>
                                </div>
                            </div>
                            <?
                            } 
                        }
                    }
                    ?>
                </div>
                
                <? /* if($orderable == 1) { ?>
                <div class="card-action">
                    <div class="row">
                        <div class="box">
                            <a href="#confirmOrder" class="ui-btn ui-btn-inline waves-effect waves-button waves-effect waves-button ui-disabled add_command_button" data-transition="pop" data-rel="popup" data-position-to="window" aria-haspopup="true" aria-owns="popupDialog" aria-expanded="false" id="prepare_order_<?=$product->id?>">
                            <i class="zmdi zmdi-shopping-cart-add zmd-fw" style="font-size:20px;"></i>&nbsp;Ajouter à ma commande
                            </a>
                        </div>
                    </div>
                </div>
                <? } */ ?>
                
            </div>
        </div>
    </div>
</div>


<? if(!empty($category->description)) { ?>
<div data-role="footer" data-position="fixed" role="contentinfo" class="ui-footer ui-bar-inherit ui-footer-fixed slideup">
    <div class="row center-xs">
        <div class="col-xs">
            <div class="box category_description">
                <?=$category->description?>
            </div>
        </div>
    </div>
</div>
<? } ?>



<?php  /* ?>
<div data-role="popup" id="confirmOrder" class="ui-popup ui-body-inherit ui-overlay-shadow ui-corner-all">
    <div data-role="header" role="banner" class="ui-header ui-bar-inherit">
        <h1 class="nd-title ui-title" role="heading" aria-level="1">Commander ce produit</h1>
    </div>
    <div data-role="content" class="ui-content order_product_note" role="main">
        <p>
        Souhaitez vous rajouter une information particulière sur ce produit ?
        <br />
        (ex : cuisson des viandes, ingrédient non-désiré, etc...)
        </p>
        <input type="text" id="note_text_field" maxlength=128 />
        <div class='row'>
            <div class="col-xs-3">
                <a data-rel="back" data-role="button" class="ui-btn-primary ui-btn waves-effect waves-button waves-effect waves-button ui-btn-active" role="button">
                <i class="zmdi zmdi-arrow-back"></i>
                </a>
            </div>
            <div class="col-xs-9">
                <a href="#" data-role="button" class="ui-btn-primary ui-btn waves-effect waves-button waves-effect waves-button product_order" role="button" data-id="<?=$product->id?>" data-prices-cat="<?=$product->prices_categories?>" data-est-id="<?=$est_id?>">
                <i class="zmdi zmdi-shopping-cart-add" style="font-size:20px;"></i> Commander
                </a>
            </div>
        </div>
    </div>
</div>
<? */ ?>