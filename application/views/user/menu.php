<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row center-xs center-sm center-md center-lg">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 div_menu_selection">
        <div class="box">
            <div class="menu_price">Prix : <?=number_format($menu['price'],2)?>&euro;</div>
            <div class="menu_title"><?=$menu['note']?></div>
            <div data-role="collapsible-set" data-inset="false" class="menu_selection">
            <? foreach($composition as $k => $compo){ ?>
                <div data-role="collapsible" data-inset="false" class="composition_list">
                    <h4>
                        <a href="#" class="ui-btn waves-effect waves-button waves-effect waves-button"  style="white-space:normal;">                
                            <?=$compo['name']?>
                            <?
                            if($compo['prices_categories']==1 && !empty($compo['prices_categories_name'])){ 
                                echo "(",$compo['prices_categories_name'],")";
                            }
                            ?>
                            <? if(!empty($compo['note'])){ ?>
                            <br />
                            <span class="composition_note">
                                <?=$compo['note']?>
                            </span>
                            <? } ?>
                        </a>
                    </h4>
                    <ul data-role="listview" class="product_composition_list">
                    <? if(count($compo['products'])>1) { ?>
                            <? foreach($compo['products'] as $k => $prod){
                                $checked = (count($compo['products'])==1) ? 'checked' : '';
                                ?>
                            <li <? if($prod->suggest==1) echo 'class=suggest'; ?> >
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="box">
                                            <i class="zmdi zmdi-shopping-basket zmd-fw"></i>
                                            <input type=radio name="<?=$compo['id']?>" id="cat_<?=$compo['id']?>" value="<?=$prod->id?>" data-name="<?=$prod->name?>" class="select_a_product clickable" <?=$checked?> />                                            
                                        </div>
                                    </div>
                                    <div class="col-xs-7">
                                        <div class="box menu_products_from_category">
                                            <?=$prod->name?>
                                            <? if($prod->suggest==1) { ?>
                                            &nbsp;<i class="zmdi zmdi-star zmdi-hc-fw"></i>
                                            <? } ?>
                                            <? if(isset($prod->cat_name)) { ?>
                                            <br />
                                            <small>> <?=$prod->cat_name?></small>
                                            <? } ?>
                                            <? if(!empty($prod->txt_prices_cat)) { ?>
                                            <br />
                                            <small>> <?=$prod->txt_prices_cat?></small>
                                            <? } ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-2">
                                        <div class="box">
                                            <? if(!empty($prod->image) || !empty($prod->composition)) { ?>
                                            <i class="zmdi zmdi-search zmd-fw see_product clickable" data-id="<?=$prod->id?>"  data-menu="<?=$menu['id']?>" data-est-id="<?=$est_id?>"></i>
                                            <? } ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <? } ?>
                    <? } elseif(count($compo['products'])==1) { ?>
                        <li>
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="box">
                                        <i class="zmdi zmdi-shopping-basket zmd-fw"></i>
                                        <input type=radio name="<?=$compo['id']?>" value="<?=$compo['products'][0]->id?>" checked />                                        
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="box menu_products">
                                        <?=$compo['products'][0]->name?>
                                        <? if($compo['products'][0]->suggest==1) { ?>
                                        &nbsp;<i class="zmdi zmdi-star zmdi-hc-fw"></i>
                                        <? }?>
                                        <? if(isset($compo['products'][0]->cat_name)) { ?>
                                        <br />
                                        <small>> <?=$compo['products'][0]->cat_name?></small>
                                        <? } ?>
                                        <? if(!empty($compo['products'][0]->txt_prices_cat)) { ?>
                                        <br />
                                        <small>> <?=$compo['products'][0]->txt_prices_cat?></small>
                                        <? } ?>
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="box">
                                        <? if(!empty($compo['products'][0]->image) || !empty($compo['products'][0]->composition)) { ?>
                                        <i class="zmdi zmdi-search zmd-fw see_product" data-id="<?=$compo['products'][0]->id?>" data-menu="<?=$menu['id']?>" data-est-id="<?=$est_id?>"></i>
                                        <? } ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <? } else { ?>
                    <li class="ui-li-static ui-body-inherit menu_order">
                        Aucun produit proposé.
                    </li>
                    <? } ?>
                    </ul>
                </div>
            <? } ?>            
            </div>
        </div>
    </div>


<?php  /*

    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 div_menu_order">
        <div class="box">
        <?=form_open('user/add_menu_order?est_id='.$est_id, array('id' => 'form_order', 'data-ajax' => 'false'))?>            
            <ol data-role="listview" data-icon="false" class="ui-listview">
                <?
                foreach($composition as $k => $compo) {
                    if(count($compo['products'])>1) {
                ?>
                    <li class="ui-li-static ui-body-inherit menu_order">
                        <span id="compo_<?=$compo['id']?>_selection">Votre choix dans "<?=$compo['name']?>".</span>
                        <input type="text" id="compo_<?=$compo['id']?>_note" placeholder="Note pour la commande" disabled />
                        <? foreach($compo['products'] as $k => $prod) { ?>
                        <input type=hidden name="txt_prices_cat[<?=$prod->id?>]" value="<? if(!empty($prod->txt_prices_cat)) echo $prod->txt_prices_cat; ?>" />
                        <? } ?>
                    </li>
                    <? } elseif(count($compo['products'])==1) { ?>
                    <li class="ui-li-static ui-body-inherit menu_order" id="compo_<?=$compo['id']?>_selection">
                        <?=$compo['products'][0]->name?>
                        <input type='text' name="note[<?=$compo['products'][0]->id?>]" placeholder="Note pour la commande" />
                        <input type=hidden name="txt_prices_cat[<?=$compo['products'][0]->id?>]" value="<? if(!empty($compo['products'][0]->txt_prices_cat)) echo $compo['products'][0]->txt_prices_cat; ?>" />
                    </li>
                    <? } else { ?>
                    <li class="ui-li-static ui-body-inherit menu_order">
                        <span id="compo_<?=$compo['id']?>_selection">Votre choix dans "<?=$compo['name']?>".</span>
                        <br />
                        <i>Aucun produit proposé.</i>
                        <hr />
                    </li>
                    <? } ?>
                <?
                }
                ?>
            </ol>
            <input type=hidden name="menu_id" value="<?=$menu['id']?>" />
            <?
            foreach($composition as $k => $compo) { 
                $prod_id = (count($compo['products'])==1) ? $compo['products'][0]->id : '';
            ?>
                <input type=hidden name="ids[<?=$k?>]" id="compo_<?=$compo['id']?>_ordered" value="<?=$prod_id?>" class="order_construction" />
            <?
            }
            ?>            
        <?=form_close()?>
        <a class="ui-btn ui-btn-icon-right ui-btn-raised clr-primary ui-disabled " id="order_menu" />
        <i class="zmdi zmdi-shopping-cart-add zmd-fw"></i>
        Commander
        </a>
        </div>
    </div>
    
    */ ?>
</div>
