<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tile">
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <a href="/manager/add_menu" class='btn btn-primary edit_menu'><i class="zmdi zmdi-plus zmdi-hc-fw"></i><span>Ajouter un menu</span></a>
            </div>
        </div>
    </div>
    <table class="table table-responsive table-bordered table-striped" id="table_menus">
        <thead class="bg-green">
            <tr>
                <th class="col-xs-4 col-sm-2 col-md-2 col-lg-2 text-center">Ordre d'affichage</th>
                <th class="col-xs-8 col-sm-8 col-md-5 col-lg-6">Nom</th>
                <th class="col-sm-2 col-md-1 col-lg-1 hidden-xs">Prix</th>
                <th class="col-md-4 col-lg-3 hidden-xs hidden-sm">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach($menus as $menu_id=>$menu){
                $hidden_up = ($menu['rank']>1) ? '' : 'invisible';
                $hidden_down = ($menu['rank']<count($menus)) ? '' : 'invisible';
                $note = !empty($menu['note']) ? "<br />".$menu['note'] : "" ; 
            ?>
            <tr id="category-<?=$menu_id?>" class="selectionable">
                <td class="text-center order_display">
                    <? if(count($menus)>1) { ?>
                    <i class="zmdi zmdi-long-arrow-up zmdi-hc-fw <?=$hidden_up?> ascend" data-id='<?=$menu_id?>' data-rank='<?=$menu['rank']?>'></i>
                    <i class="zmdi zmdi-long-arrow-down zmdi-hc-fw  <?=$hidden_down?> descend" data-id='<?=$menu_id?>' data-rank='<?=$menu['rank']?>'></i>
                    <? } else { ?>
                    <i class="zmdi zmdi-minus zmdi-hc-fw"></i>
                    <? } ?>
                </td>
                <td>
                    <strong><a href="/manager/edit_menu/<?=$menu_id?>" class="fast_link"><?=$menu['name']?></a></strong>
                    <?=$note?>
                </td>
                <td class="hidden-xs">
                    <?=$menu['price']?> &euro;
                </td>
                <td class="hidden-xs hidden-sm">
                    <button class='btn btn-primary edit_menu' data-id="<?=$menu_id?>"><i class="zmdi zmdi-edit zmdi-hc-fw"></i><span>Modifier</span></button>
                    <button class='btn btn-warning delete_menu pull-right' data-id="<?=$menu_id?>"><i class="zmdi zmdi-delete zmdi-hc-fw"></i><span>Supprimer</span></button>
                </td>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>
