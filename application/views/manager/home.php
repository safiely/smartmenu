<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?
$warning = '<i class="zmdi zmdi-alert-triangle zmdi-hc-fw f-20" style="color:#FF9800;"></i>';
$ok = '<i class="zmdi zmdi-check zmdi-hc-fw f-20" style="color:#4CAF50;"></i>';
?>

<div class="tile" id="profile-main">
    <div class="pm-overview c-overflow-dark">
        <div class="pmo-pic">
            <div class="p-relative">
                <a href="/manager/customisation">
                    <? if(!empty($customisation->logo)) { ?>
                    <img class="img-responsive" src="<?=base_url('uploads/logos/'.$customisation->logo)?>">
                    <? } else { ?>
                    <img class="img-responsive" src="<?=base_url('assets/common/img/logo_default.png')?>">
                    <? } ?>
                </a>
                <a href="/manager/customisation" class="pmop-edit">
                    <i class="zmdi zmdi-camera"></i> <span class="hidden-xs">Mettre à jour la photo de profil.</span>
                </a>
            </div>
            <div class="pmo-stat">
                <h2 class="m-0 c-white">
                    <a href="/manager/establishment" class="establishment_name_profile"><?=$establishment->name?></a>
                </h2>
            </div>
        </div>
        
        <div class="pmo-block pmo-contact hidden-xs">
            <ul>
                <li>
                    <i class="zmdi zmdi-my-location"></i>
                    <?
                    if(empty($establishment->adress) && empty($establishment->postal_code) && empty($establishment->city))
                    echo 'Non renseigné';
                    ?>
                    <?=$establishment->adress?>
                    <br />
                    <?=$establishment->postal_code?>
                    <br />
                    <?=$establishment->city?>
                </li>
                <li>
                    <i class="zmdi zmdi-phone"></i>
                    <? if(!empty($establishment->phone)) echo $establishment->phone; else echo 'Non renseigné';?>
                </li>
                <li>
                    <i class="zmdi zmdi-globe-alt"></i>
                    <? if(!empty($establishment->web_site)) echo $establishment->web_site; else echo 'Non renseigné';?>
                </li>
                <li>
                    <a href="/manager/establishment">Modifier les informations de contact</a>
                </li>
            </ul>
        </div>
    </div>    
    <div class="pm-body clearfix">
        <ul class="tab-nav tn-justified">
            <li class="active"><a href="#" style="cursor:default;">Profil de votre établissment</a></li>
        </ul>
        <div class="pmb-block">
            <div class="pmbb-header">
                <h2>
                    <i class="zmdi zmdi-store m-r-5"></i><?=$establishment->name?>
                </h2>
            </div>
            <div class="pmbb-body p-l-20">
                <div class="pmbb-view">
                    <a href='/manager/establishment'>Modifier le nom de votre établissement</a>
                </div>
            </div>
        </div>
        <div class="pmb-block">
            <div class="pmbb-header">
                <h2><i class="zmdi zmdi-smartphone-android m-r-5"></i>Accès à votre carte</h2>
            </div>
            <div class="pmbb-body p-l-20">
                Votre carte est accessible à l'adresse suivante : <a href="<?=base_url()?>/<?=$establishment->url?>" target="_blank"><?=domain_name_human()?>/<?=$establishment->url?></a> <?=$ok?>
                <br />
                <a href="/manager/establishment">Modifier l'adresse d'accès à votre carte</a>
                <br />
                <br />
                <div class="toggle-switch">
                    <label for="maintenance" class="ts-label">Mode maintenance</label>
                    <input id="maintenance" type="checkbox" hidden="hidden" name="maintenance" <? if($maintenance==1) echo 'checked'; ?> >
                    <label for="maintenance" class="ts-helper"></label>
                </div>
                <? $display_maintenance_warning = ($maintenance==0) ? 'none' : 'inline-block' ; ?>
                <i class="zmdi zmdi-alert-triangle zmdi-hc-fw f-20" style="display:<?=$display_maintenance_warning?>;color:#FF9800;" id="maintenance_warning"></i>
                <br />
                En activant le mode maintenance, votre carte ne sera pas accessible par vos clients. Vous pouvez utiliser
                ce mode le temps de créer ou de mettre à jour votre carte.
            </div>
        </div>
        <div class="pmb-block">
            <div class="pmbb-header">
                <h2><i class="zmdi zmdi-library m-r-5"></i>Catégories de produits</h2>
            </div>            
            <div class="pmbb-body p-l-20">                
                Votre carte contient <?=$count_categories?> <?=single_or_plurial($count_categories, 'catégorie', 'catégories')?>.
                <? if($count_categories==0) echo $warning; else echo $ok; ?>
                <br />
                <a href="/manager/add_category">Créer une nouvelle catégorie</a>
            </div>
        </div>
        <div class="pmb-block">
            <div class="pmbb-header">
                <h2><i class="zmdi zmdi-pizza m-r-5"></i>Produits</h2>
            </div>
            <div class="pmbb-body p-l-20">                
                Votre carte contient <?=$count_products?> <?=single_or_plurial($count_products, 'produit', 'produits')?>.
                <? if($count_products==0)  echo $warning; else echo $ok; ?>
                <br />
                <a href="/manager/add_product">Ajouter un nouveau produit</a>
            </div>
        </div>
    </div>
</div>