<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/add_product_check_form/'.$selected_cat, array('id'=>'add_product_form', 'enctype'=>'multipart/form-data'))?>
<div class="tile">
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                        Cette page vous permet d'ajouter un produit à votre carte. N'oubliez pas de l'associer à une de vos catégories.
                        <a href="/manager/help#prod" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="form-group">
                    <label>Catégorie du produit</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <? if(count($categories)>0) { ?>
                    <br />
                    <select name="category" class="selectpicker" id="select_category">
                        <option value="0">Choisir une catégorie</option>
                        <?
                        foreach($categories as $cat_id=>$cat) {
                            $sel = (isset($selected_cat) && !empty($selected_cat) && $selected_cat==$cat_id) ? 'selected' : '';
                            $prices_cat = (count($cat['prices_cat'])>0) ? '1' : '0' ;
                            echo "<option value='$cat_id' ",set_select('category')," $sel data-prices-cat='",$prices_cat,"' >",$cat['name'],"</option>";
                        }
                        ?>
                    </select>
                    <?=form_error('category')?>
                    <? } else { ?>
                    <div class='has-error'>
                        <small class='help-block'>
                            Vous n'avez enregistré aucune catégorie de produits.
                            <br />
                            <a href="/manager/add_category">Ajouter une catégorie de produits</a>.
                        </small>
                    </div>
                    <? } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                <div class="form-group">
                    <label>Nom du produit</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-pizza"></i></span>
                        <input type="text" name="name" id="name" value="<?=set_value('name')?>" class="form-control" placeholder="Le nom de votre produit" maxlength=128 />
                    </div>
                    <?=form_error('name')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-8">
                <div class="form-group">
                    <label>Description</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-cutlery"></i></span>
                        <input type="text" name="composition" value="<?=set_value('composition')?>" class="form-control" placeholder="La composition ou la description de votre produit" />
                    </div>
                    <?=form_error('composition')?>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="form-group">
                    <label>Prix</label>                    
                    <!--Prix unique-->
                    <div class="unique_price">
                        <div class="input-group">
                            <span class="input-group-addon last"><i class="zmdi zmdi-money"></i></span>
                            <input type="text" name="price" value="<?=set_value('price', 0)?>" class="form-control" />
                        </div>
                        <?=form_error('price')?>
                    </div>                    
                    <!--Catégorie de produit-->
                    <?
                    foreach($categories as $cat_id=>$cat) {
                        if(count($cat['prices_cat'])>0) { ?>
                            <div class="prices_category prices_category_<?=$cat_id?>">
                            <? foreach($cat['prices_cat'] as $k => $prices){ ?>
                                <div class="input-group">
                                    <span class="input-group-addon last" style="width:50%;"><?=$prices->name?></span>                                    
                                    <input type="text" name="prices_category[<?=$cat_id?>][<?=$prices->id?>]" value="<?=set_value('prices_category['.$cat_id.']['.$prices->id.']', 0)?>" class="form-control" pattern="^(\d+(?:[\.,][\d]{1,2})?)$" />
                                    <span class="input-group-addon"><i class="zmdi zmdi-money"></i></span>
                                </div>
                                <?=form_error('prices_category[][]')?>
                            <? } ?>
                            </div>
                        <? }
                    }
                    ?>                    
                    <input type="hidden" name="prices_categories" id="prices_categories" value="" />                    
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Image du produit</label>
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                        <div>
                            <span class="btn btn-info btn-file">
                                <span class="fileinput-new">Ajouter une image</span>
                                <span class="fileinput-exists">Changer</span>
                                <input type="file" name="logo" value="" />
                            </span>
                            <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Supprimer</a>
                            <div class='has-warning'>
                                <small class='help-block'>
                                Votre image doit faire moins de 8Mo.
                                </small>
                            </div>
                        </div>
                        <?
                        if(isset($logo_error) && is_array($logo_error)){
                           foreach($logo_error as $k){
                                echo "<div class='has-error'><small class='help-block'>$k</small></div>";
                           }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10" <? if(count($categories)==0) echo "disabled='disabled'"; ?> >Ajouter ce produit</button>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>