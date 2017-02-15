<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row center-xs">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6 div_order">
                <div class="box main_order">
                    
            <? foreach($menus as $k => $menu) { ?>
                <div class="row order cat middle-xs menu_ordered" data-menu-id="<?=$menu['menu_id']?>" data-menu-rank="<?=$k?>" data-est-id="<?=$est_id?>">
                    <div class="col-xs start-xs text-left">
                        <div class="box head clickable" id="menu_name_<?=$menu['menu_id']?>"><?=$menu['name']?></div>
                    </div>
                    <div class="col-xs-3 end-xs">
                        <div class="box"><?=$menu['price']?> &euro;</div>
                    </div>
                </div>
                <? foreach($menu['products'] as $k => $prod){ ?>
                <div class="row order middle-xs product_ordered in_menu" data-id="<?=$prod->id?>" data-est-id="<?=$est_id?>">
                    <div class="col-xs start-xs text-left">
                        <div class="box product_ordered clickable">
                            <?=$prod->name?>
                            <? if(!empty($prod->note)) { ?>
                            (<?=$prod->note?>)
                            <? } ?>
                        </div>
                    </div>
                    <div class="col-xs-3 end-xs">
                        <div class="box">&nbsp;</div>
                    </div>
                </div>
                <?    
                }
            }
            ?>
            
            
            <? foreach($categories as $cat_id => $cat) { ?>
                <div class="row order cat middle-xs">
                    <div class="col-xs-12 start-xs text-left">
                        <div class="box head"><b><?=$cat['name']?></b></div>
                    </div>
                </div>
                <? foreach($cat['products'] as $k => $prod){ ?>
                <div class="row order middle-xs product_ordered" data-id="<?=$prod->id?>" data-cat-id="<?=$cat_id?>" data-product-id="<?=$k?>" data-est-id="<?=$est_id?>">
                    <div class="col-xs start-xs text-left">
                        <div class="box product_ordered clickable" id="product_name_<?=$prod->id?>">
                        <?=$prod->name?>
                        <? if(!empty($prod->note)) { ?>            
                        (<?=$prod->note?>)
                        <? } ?>
                        </div>
                    </div>
                    <div class="col-xs-3 end-xs">
                        <div class="box"><?=$prod->price?> &euro;</div>
                    </div>
                </div>
                <?  
                }
            }
            ?>
            
            <hr />
            
            <div class="row order">
                <div class="col-xs-9 start-xs text-left">
                    <div class="box"><strong>Total</strong></div>
                </div>
                <div class="col-xs-3 end-xs">
                    <div class="box"><?=$amount?> &euro;</div>
                </div>
            </div>
            
            <div class="row order">
                <div class="col-xs-12">
                    <div class="box">            
                            <a href="#confirmOrderReset" data-rel="popup" data-position-to="window" data-role="button" data-inline="true" data-transition="pop" aria-haspopup="true" aria-owns="popupDialog" aria-expanded="false" class="ui-btn ui-btn-raised clr-warning waves-effect waves-button waves-effect waves-button reset-order" role="button">
                                <i class="zmdi zmdi-delete"></i> Réinitialiser la commande
                            </a>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<a href="#edit_order" id="edit_order_button"></a>
<div data-role="panel" id="edit_order" class="ui-bottom-sheet" data-animate="false" data-position='bottom' data-display="overlay">
    <div class="toast_title" id="toast_title"></div>
    <div class='row around-xs'>
        <div class='col-xs-4 center-xs see_product'>
            <a href='#' class='ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button waves-effect waves-button' id='see_product_from_order'>
                <i class='zmdi zmdi-eye zmd-2x'></i>
                <strong>Voir</strong>
            </a>
        </div>
        <div class='col-xs-4 center-xs'>
            <a href='#' class='ui-bottom-sheet-link ui-btn ui-btn-inline waves-effect waves-button waves-effect waves-button' id='remove_product_from_order' data-ajax="false" data-id="" data-cat="">
                <i class='zmdi zmdi-delete zmd-2x'></i>
                <strong>Retirer</strong>
            </a>
        </div>
    </div>
</div>


<div data-role="popup" id="confirmOrderReset" class="ui-popup ui-body-inherit ui-overlay-shadow ui-corner-all">
    <div data-role="header" role="banner" class="ui-header ui-bar-inherit">
        <h1 class="nd-title ui-title" role="heading" aria-level="1">Vider cette commande ?</h1>
    </div>
    <div data-role="content" class="ui-content" role="main">
        <p>En vidant cette commande, vous perdrez tous les produits que vous avez enregistré.</p>
        <div class='row'>
            <div class="col-xs-6">
                <a data-rel="back" data-role="button" class="ui-btn-primary ui-btn waves-effect waves-button waves-effect waves-button ui-btn-active" role="button"  >
                <i class="zmdi zmdi-arrow-back"></i> Annuler
                </a>
            </div>
            <div class="col-xs-6">
                <a href="/user/delete_order?est_id=<?=$est_id?>" data-role="button" class="ui-btn-primary ui-btn waves-effect waves-button waves-effect waves-button" role="button" data-ajax="false">
                <i class="zmdi zmdi-check"></i> OK
                </a>
            </div>
        </div>
    </div>
</div>