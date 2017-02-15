<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<? if(count($products)==0){ ?>
    <div class="row center-xs">
        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
                <div class="box">
                    Aucun produit n'est proposé dans cette catégorie.
                </div>
        </div>
    </div>
<? } else { ?>
    <div class="row center-xs">
        <div class="col-xs-12">
            <div class="box">
                <ul id="productList" data-role="listview" data-icon="false" class="ui-listview">
                    <?
                    foreach($products as $k=>$prod){
                        $suggest = ($prod->suggest==1) ? '&nbsp;<i class="zmdi zmdi-star zmdi-hc-fw"></i>' : '';
                        $suggestClass = ($prod->suggest==1) ? 'suggest' : '';
                        $no_img_class = ($one_image == false) ? 'no_image' : '';
                        if($prod->price > 0 && $prod->image_file == false && empty($prod->composition)){
                            //Rien de spécial à montrer dans la page produit, donc possibilité de commander direct
                            $href = '#confirmProductOrder';
                            $order_class = 'confirmOrder';
                            $type_popup = 'data-transition="pop" data-rel="popup" data-position-to="window" aria-haspopup="true" aria-owns="popupDialog" aria-expanded="false"';
                        } else {
                            //Suit le process normal et va dans la page produit
                            $href = "/user/product/".$prod->id.'?est_id='.$est_id;
                            $order_class = "";
                            $type_popup = 'data-dom-cache="true"';
                        }
                    ?>
                    <li class="ui-li-has-thumb <?=$suggestClass?>">
                            <a href="<?=$href?>" class="ui-btn waves-effect waves-button waves-effect waves-button <?=$order_class?> <?=$no_img_class?>" <?=$type_popup?> data-id="<?=$prod->id?>">
                                    <? if(!empty($prod->image)) { ?>
                                        <img src="<?=$prod->image?>" class="ui-thumbnail ui-thumbnail-circular">
                                    <? } ?>
                                    <h2><?=$prod->name?><?=$suggest?></h2>
                                    <p><?=$prod->composition?></p>
                                    <?if($prod->prices_categories==0) { ?>
                                    <h4><?=$prod->price?> &euro;</h4>
                                    <? } ?>
                            </a>
                    </li>
                    <? } ?>
                </ul>
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
<? } ?>


<?php  /* ?>
<div data-role="popup" id="confirmProductOrder" class="ui-popup ui-body-inherit ui-overlay-shadow ui-corner-all">
    
            <div data-role="header" role="banner" class="ui-header ui-bar-inherit">
                <h1 class="nd-title ui-title" role="heading" aria-level="1">Commander ce produit</h1>
            </div>
            <div data-role="content" class="ui-content order_product_note" role="main">
                <p>
                Souhaitez vous rajouter une information particulière sur ce produit ?
                <br />
                (ex : cuisson des viandes, ingrédient non-désiré, etc...)
                </p>
                <input type="text" id="note_text_field_product" maxlength=128 />
                <div class='row'>
                    <div class="col-xs-3">
                        <a data-rel="back" data-role="button" class="ui-btn-primary ui-btn waves-effect waves-button waves-effect waves-button ui-btn-active" role="button">
                        <i class="zmdi zmdi-arrow-back"></i>
                        </a>
                    </div>
                    <div class="col-xs-9">
                        <a href="#" data-role="button" class="ui-btn-primary ui-btn waves-effect waves-button waves-effect waves-button" id="product_order" role="button" data-id="" data-est-id="<?=$est_id?>">
                        <i class="zmdi zmdi-shopping-cart-add" style="font-size:20px;"></i> Commander
                        </a>
                    </div>
                </div>
            </div>
        
</div>

<? */ ?>
