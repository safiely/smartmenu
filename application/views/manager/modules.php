<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tile">
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                        Les modules vous permettent de personnaliser les fonctionnnalités disponibles pour votre carte.
                        <a href="/manager/help#modules" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-responsive table-bordered table-striped" id="table_modules">
                    <thead class="bg-green">
                        <tr>                            
                            <th class="col-xs-6 col-sm-4 col-md-3 col-lg-3">Modules</th>
                            <th class="hidden-xs col-sm-6 col-md-5 col-lg-5">Description</th>
                            <th class="hidden-xs hidden-sm col-md-2 col-lg-2">Prix</th>
                            <th class="col-xs-6 col-sm-2 col-md-2 col-lg-2">Activation</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr>
                            <td>Quantités</td>
                            <td class="hidden-xs">
                                Ce module vous permet de définir plusieurs prix pour un produit vendu sous différentes formes. Par exemple, vous pouvez
                                définir des tailles de pizzas (petite/moyenne/grande), ou bien des volumes de vente pour du vin
                                (verre/pichet/bouteille).
                            </td>
                            <td class="hidden-xs hidden-sm">Gratuit (inclus dans l'abonnement)</td>
                            <td>
                                <div class="toggle-switch">                    
                                    <input id="prices_cat" type="checkbox" hidden="hidden" class="switchModule" <? if($modules->prices_cat==1) echo 'checked'; ?> >
                                    <label for="prices_cat" class="ts-helper"></label>
                                    <label for="prices_cat" class="ts-label"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Géolocalisation</td>
                            <td class="hidden-xs">
                                Permet d'afficher votre établissement dans la carte de géolocalisation sur la page d'accueil de smartmenu.fr.
                                L'utilisateur est géo-localisé automatiquement, et il verra votre établissement si vous vous trouvez dans le même secteur.
                                <br />
                                Un lien permet aux utilisateurs de se connecter directement à votre carte sans avoir à rechercher votre établissement.
                            </td>
                            <td class="hidden-xs hidden-sm">Gratuit (inclus dans l'abonnement)</td>
                            <td>
                                <div class="toggle-switch">                    
                                    <input id="geoloc" type="checkbox" hidden="hidden" class="switchModule" <? if($modules->geoloc==1) echo 'checked'; ?> >
                                    <label for="geoloc" class="ts-helper"></label>
                                    <label for="geoloc" class="ts-label"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Menus et formules</td>
                            <td class="hidden-xs">
                                Ce module vous permet de proposer des menus ou formules dans votre carte. Crééz vos différents
                                menus sur la base des produits et des catégories composant votre carte.
                            </td>
                            <td class="hidden-xs hidden-sm">1,90 €</td>
                            <td>
                                <div class="toggle-switch">                    
                                    <input id="menus" type="checkbox" hidden="hidden" class="switchModule" <? if($modules->menus==1) echo 'checked'; ?> >
                                    <label for="menus" class="ts-helper"></label>
                                    <label for="menus" class="ts-label"></label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Suggestion</td>
                            <td class="hidden-xs">
                                Vous permet de mettre en avant des produits sur votre carte. Le produit sera suivi d'une étoile <i class="zmdi zmdi-star zmdi-hc-fw"></i>,
                                et sera en surbrillance par rapport aux autres produits de la même catégorie.
                            </td>
                            <td class="hidden-xs hidden-sm">0,90 €</td>
                            <td>
                                <div class="toggle-switch">                    
                                    <input id="suggest" type="checkbox" hidden="hidden" class="switchModule" <? if($modules->suggest==1) echo 'checked'; ?> >
                                    <label for="suggest" class="ts-helper"></label>
                                    <label for="suggest" class="ts-label"></label>
                                </div>
                            </td>
                        </tr>                        
                        <tr>
                            <td>Réseaux sociaux</td>
                            <td class="hidden-xs">
                                Permet à vos clients d'accéder à vos réseaux sociaux lorsqu'ils consultent votre carte.
                            </td>
                            <td class="hidden-xs hidden-sm">1,90 €</td>
                            <td>
                                <div class="toggle-switch">
                                    <input id="social" type="checkbox" hidden="hidden" class="switchModule" <? if($modules->social==1) echo 'checked'; ?> >
                                    <label for="social" class="ts-helper"></label>
                                    <label for="social" class="ts-label"></label>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
