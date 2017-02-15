<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/edit_menu_check_form/'.$menu['id'])?>
<div class="tile">
    <div class="t-header">
        <div class="th-title">
            Modifier le menu
        </div>
    </div>
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                <div class="form-group">
                    <label>Nom du menu</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-assignment"></i></span>
                        <input type="text" name="name" id="name" value="<?=set_value('name', $menu['name'])?>" class="form-control" />
                    </div>
                    <?=form_error('name')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5">
                <div class="form-group">
                    <label>Informations complémentaires</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-info-outline"></i></span>
                        <input type="text" name="note" value="<?=set_value('note', $menu['note'])?>" class="form-control" placeholder="Informations particulières concernant ce menu." />
                    </div>
                    <?=form_error('note')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-2">
                <div class="form-group">
                    <label>Prix</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-money"></i></span>
                        <input type="text" name="price" value="<?=set_value('price', $menu['price'])?>" class="form-control" placeholder="ex : 12,50" />
                    </div>
                    <?=form_error('price')?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-left">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">
                Enregistrer les modifications
                </button>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                <button type="button" class='btn btn-warning btn-sm m-t-10 delete_menu' data-id="<?=$menu['id']?>">
                Supprimer ce menu
                </button>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>


<div class="tile">
    <div class="t-header p-b-0">
        <div class="th-title">
            Composition du menu
        </div>
    </div>
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                            Pour définir la composition de votre menu, vous devez avant tout créer les sections qui le compose (ex : "une entrée au choix" et "un plat au choix").
                            Une section peut-être soit une catégorie de produits, soit une sélection libre parmi tous vos produits.
                            <a href="/manager/help#menu" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?=form_open('manager/add_composition/'.$menu['id'])?>
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                <div class="form-group">
                    <label>Nom de la nouvelle section</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-view-headline"></i></span>
                        <input type="text" name="composition_name" value="<?=set_value('composition_name')?>" class="form-control" placeholder="ex : Plat" id="new_selection_name" />
                    </div>
                    <?=form_error('composition_name')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5">
                <div class="toggle-switch">
                    <label for="selection_type" class="ts-label">Associer une catégorie à cette section</label>
                    <input name="one_category" id="selection_type" type="checkbox" hidden="hidden">
                    <label for="selection_type" class="ts-helper"></label>
                </div>
                <div class="form-group selection_type_list">
                    <select name="cat_id" class="selectpicker" id="select_cat">
                        <option value='0' <?=set_select('cat_id', '0', TRUE)?> >Sélectionnez la catégorie concernée par cette section</option>
                        <?
                        foreach($categories as $cat_id=>$name) {
                            echo "<option value='$cat_id' ",set_select('cat_id', $cat_id)," >$name</option>";
                        }
                        ?>
                    </select>
                    <small>Important : si vous choissisez une catégorie, seuls les produits de cette catégorie seront affichés.</small>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">
                    Ajouter une section à ce menu
                </button>
            </div>
        </div>
        <?=form_close()?>
    </div>
    <? if(count($composition)>0) { ?>
    <table class="table table-responsive table-bordered table-striped">
        <thead class="bg-green">
            <tr>
                <th class="col-xs-6 col-sm-2 col-md-2 col-lg-2 text-center">Ordre d'affichage</th>
                <th class="col-xs-6 col-sm-10 col-md-6 col-lg-7">Sections</th>
                <th class="col-lg-3 col-md-4 col-lg-3 hidden-xs hidden-sm">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach($composition as $k => $compo){
                $hidden_up = ($compo['rank']>1) ? '' : 'invisible';
                $hidden_down = ($compo['rank']<count($composition)) ? '' : 'invisible';
            ?>
            <tr class="selectionable">
                <td class="text-center order_display">
                    <? if(count($composition)>1) { ?>
                    <i class="zmdi zmdi-long-arrow-up zmdi-hc-fw <?=$hidden_up?> composition_ascend" data-id='<?=$compo['id']?>' data-rank='<?=$compo['rank']?>'></i>
                    <i class="zmdi zmdi-long-arrow-down zmdi-hc-fw  <?=$hidden_down?> composition_descend" data-id='<?=$compo['id']?>' data-rank='<?=$compo['rank']?>'></i>
                    <? } else { ?>
                     <i class="zmdi zmdi-minus zmdi-hc-fw"></i>
                    <? } ?>
                </td>
                <td>
                    <strong>
                    <a href="/manager/edit_composition/<?=$compo['id']?>" class="fast_link">
                    <?=$compo['name']?>
                    </a>
                    </strong>
                    <span class="hidden-xs">
                    <?
                    if(!empty($compo['note'])) {
                        echo ' (',$compo['note'],')';
                    }
                    if(!empty($compo['linked_cat'])){
                        echo "<br />Catégorie associée : ",$compo['linked_cat'];
                    }
                    if($compo['prices_categories']==1){
                        echo ' (',$compo['prices_categories_name'],')';
                    }
                    ?>
                    </span>
                </td>
                <td class="hidden-xs hidden-sm">
                    <button class='btn btn-primary edit_composition' data-id="<?=$compo['id']?>">
                        <i class="zmdi zmdi-edit zmdi-hc-fw"></i>
                        <span>Modifier</span>
                    </button>
                    <button class='btn btn-warning delete_composition pull-right' data-id="<?=$compo['id']?>">
                        <i class="zmdi zmdi-delete zmdi-hc-fw"></i>
                        <span>Supprimer</span>
                    </button>
                </td>
            </tr>
            <? }  ?>
        </tbody>
    </table>
    <? } ?>
</div>