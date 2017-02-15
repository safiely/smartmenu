<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="tile p-0">
    <div class="t-body tb-padding">
        <div class="form-wizard-basic fw-container">
            <ul class="tab-nav text-left">
                <li><a href="#help" id="link_help" data-toggle="tab">Demander de l'aide</a></li>
                <li><a href="#est" id="link_est" data-toggle="tab">Établissement</a></li>
                <li><a href="#custom" id="link_custom" data-toggle="tab">Personnalisation</a></li>
                <li><a href="#cat" id="link_cat" data-toggle="tab">Catégories de produits</a></li>
                <li><a href="#prod" id="link_prod" data-toggle="tab">Produits</a></li>
                <li><a href="#menu" id="link_menu" data-toggle="tab">Menus</a></li>
            </ul>
            
            <div class="tab-content" id="main_page_help">
                
                
                
                <div class="tab-pane fade" id="help">
                    <p>
<h4><i class="zmdi zmdi-help"></i>&nbsp;Besoin d'aide ?</h4>
Vous trouverez ici tous les renseignements sur la configuration du logiciel.
<br />
<br />
Si toutefois vous avez besoin de l'aide d'un technicien, contactez-nous directement via
le formulaire ci-dessous, nous vous répondrons dans les plus brefs délais.
<?=form_open('manager/contact_check_form')?>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
        <div class="form-group">
            <label>Sujet</label>
            <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
            <input type="text" name="subject" value="<?=set_value('subject', $subject)?>" class="form-control" />
            <?=form_error('subject')?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
        <div class="form-group">
            <label>Message</label>
            <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
            <textarea name="message" style="overflow: hidden; word-wrap: break-word; height: 150px;" class="form-control"><?=set_value('message', $message)?></textarea>
            <?=form_error('message')?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
        <button type="submit" class="btn btn-primary btn-sm m-t-10">Envoyer</button>
    </div>
</div>
<?=form_close()?>
                    </p>
                </div>
                
                
                
                <div class="tab-pane fade" id="est">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
<p>
<h4><i class="zmdi zmdi-home"></i>&nbsp;Tableau de bord</h4>
Vous trouverez dans cette section un aperçu général des données contenues dans votre carte.
<br />
<br />
<span class="c-red f-500">Important :</span>
<ul>
    <li>
    Dans la partie "Accès à votre carte", vous pouvez décider de passer en "mode maintenance". Ce mode vous permet de couper
    ponctuellement l'accès à votre carte à vos clients afin d'y apporter des modifications "conséquentes".
    Le mode maintenance est actif lors de votre première connexion, pensez à l'enlever une fois que votre carte
    est prête.
    </li>
</ul>
</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <img src="/assets/theme_manager/img/help/dashboard.png" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
<p>
<h4><i class="zmdi zmdi-store"></i>&nbsp;Établissement</h4>
Configurez les informations génériques telles que le nom de votre enseigne, ses horaires d'ouvertures,
ou bien encore son logo.
<br />
Certaines de ces informations sont optionnelles, d'autres sont obligatoires. Les informations obligatoires sont marquées d'un
<i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>.
<br />
<br />
<span class="c-red f-500">Important :</span>
<ul>
    <li>
    pour accéder à votre carte, vos clients ont besoin d'une adresse web. Vous devez en choisir une et la renseigner dans le champ
    "Adresse web d'accès à votre carte". Elle sera du type : <span style="white-space:nowrap;"><?=domain_name_human()?>/votrerestaurant</span>
    </li>
    <li>
    ces informations génériques sont les premières à être affichées à vos clients. Veillez donc à remplir le maximum de champs
    afin d'avoir une page d'accueil la plus complète possible.
    </li>
</ul>
</p>                        
                        </div>
                    </div>
                </div>
    
    
    
                
                
                <div class="tab-pane fade" id="custom">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
<p>
<h4><i class="zmdi zmdi-brush"></i>&nbsp;Personnalisation</h4>
Cette section vous permet de personnaliser votre carte, et notamment de créer votre page d'accueil.
<br />
<br />
<strong>Aperçu de votre carte :</strong> cet outils vous permet de visualiser votre carte selon 5 modes différents :
<ul>
    <li>simple : visualisez votre carte sur votre écran</li>
    <li>smartphone : visualisez votre carte sur un support de type smartphone</li>
    <li>tablette : visualisez votre carte sur un support de type tablette.</li>
</ul>
<br />
<strong>Logo :</strong> vous pouvez télécharger votre logo ici. Il s'affichera automatiquement à divers endroits de votre carte.
<br />
<br />
<strong>Présentation de votre établissement :</strong> cet outils vous permet de créer la page d'accueil de votre carte (votre couveture).
Il fonctionne très simplement, et il est comparable aux éditeurs de texte que vous connaissez déjà. Alors ajouter des
images, mettez votre identité en avant, et personnalisez autant que vous le souhaitez, vous êtes libre.
<br />
<br />
<strong>Image de fond de la carte :</strong> cet outils vous permet de rajouter une image de fond à votre carte. Choisissez parmi les motifs
proposés afin d'habiller votre carte avec un fond discret, mais toujours plus agréable qu'un blanc uni.
<br />
<br />
<span class="c-red f-500">Important :</span> pensez à vos clients, et ne mettez pas d'images trop lourdes dans la page d'accueil de votre carte.
Plus il y a d'images, et plus elles sont lourdes, plus votre page d'accueil mettra du temps à s'afficher.
</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <img src="/assets/theme_manager/img/help/customisation.png" />
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                <div class="tab-pane fade" id="cat">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
<p>
<h4><i class="zmdi zmdi-library"></i>&nbsp;Les catégories de produits</h4>
Définissez les différentes catégories structurant votre carte (ex : entrées, plats, desserts).
Vous pouvez en saisir autant que vous le souhaitez, et elles seront déterminantes pour classer vos produits par la suite.
<br />
Vous avez la possibilité de renseigner une information pour chaque catégorie. Par exemple, pour votre
catégories "Plats", vous pouvez mentionner le fait que tous vos plats sont accompagnés de frites et de salade.
<br />
<br />
<span class="c-red f-500">Important :</span>
<ul>
    <li>
        vos catégories s'affichent dans l'ordre que vous choisissez. N'oubliez pas de déterminer cette
        ordre, sinon les desserts pourraient bien s'afficher avant les entrées !
    </li>
    <li>
        l'image par défaut que vous choisirez pour votre catégorie sera visible par vos clients sur votre carte.
        Tous les produits n'ayant pas d'image définie se verront assignés automatiquement l'image par défaut de
        leur catégorie respective.
    </li>
</ul>
</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <img src="/assets/theme_manager/img/help/categories-ci.png" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
<p>
<h4><i class="zmdi zmdi-view-toc"></i>&nbsp;Les catégories de prix</h4>
Rattachées aux catégories de produits, les catégories de prix vous permettent de définir plusieurs
prix pour un produit vendu sous différentes formes.
<br />
Exemple : pour une carte des vins, vous pouvez définir des prix au verre, au pichet et à la bouteille pour chaque vin
que vous proposez.
<br />
<br />
Pour ne pas proposer une quantité sur un produit en particulier (ex : un vin servi uniquement à
la bouteille), il vous suffit de passer le prix des catégories non désirées à zéro.
<br />
Exemple : Verre => 0€ / Pichet => 0€ / Bouteille => 19€
<br />
Une icône <i class='zmdi zmdi-block-alt zmdi-hc-fw'></i> vous indiquera les produits non disponibles à la vente,
et vos clients ne les verront tout simplement pas sur votre carte.
<br />
<br />
Ce module permet d'englober de nombreux cas de figures (tailles de pizza petite/moyenne/grande, bière demi/pinte, etc...).
</ul>
</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="text-align: center;">
                            <img src="/assets/theme_manager/img/help/prices_categories.png" />
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                <div class="tab-pane fade" id="prod">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
<p>
<h4><i class="zmdi zmdi-pizza"></i>&nbsp;Les produits</h4>
Définissez les différents produits composant votre carte (ex : charcuterie, steack haché, glaçes) et
les informations les concernant (nom, prix, composition, etc...).
<br />
<br />
<strong>Prix : </strong>il y a deux modes de fonctionnement pour définir un prix.
<ul>
    <li>
        classique : saisissez simplement le prix de votre produit dans le champ prix.
    </li>
    <li>
        quantités : si vous avez défini des quantités pour cette catégorie de produit
        (ex : pizza petite/moyenne/grande), vous devrez saisir un prix pour chaque quantité.
    </li>
</ul>

<strong>Mettre ce produit en avant : </strong>vous pouvez mettre un produit en avant sur votre carte en utilisant le bouton "Mettre ce produit en avant". Dans ce cas,
une icône <i class="zmdi zmdi-star zmdi-hc-fw"></i> apparaitra à côté de ce produit, et il sera en surbrillance dans
vos listes de produits.
<br />
<br/>
<strong>Ne pas proposer ce produit à la carte : </strong>vous pouvez décider de ne pas afficher un produit dans votre carte, mais de l'afficher tout de même dans vos menus.
<br />
<br />
<strong>Rupture de stock : </strong>désactive le produit. Il ne s'affichera ni à la carte, ni dans les menus.
<br />
<br />
<strong>Image du produit : </strong>vous pouvez télécharger une image pour chaque produit de votre carte. Si vous ne lui associez pas d'image,
le produit s'affichera avec l'image par défaut de sa catégorie. Votre image ne doit pas dépasser les 8Mo pour être correctement téléchargée.
Vous pouvez prendre vos produits en photo avec un smartphone ou une tablette, directement depuis votre interface de gestion.
<br />
<br />
<span class="c-red f-500">Important :</span>
<ul>
    <li>vos produits sont forcément associés aux catégories de produits que vous avez précédement créé.</li>
    <li>au même titre que les catégories, n'oubliez pas de gérer l'ordre d'affichage de vos produits.</li>
</ul>
</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <img src="/assets/theme_manager/img/help/products-ci.png" />
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                <div class="tab-pane fade" id="menu">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
<p>
<h4><i class="zmdi zmdi-assignment"></i>&nbsp;Les menus</h4>
Définissez les différentes formules qui composent votre carte. Commencez par créer un menu en renseignant
les informations génériques (ex : menu du jour, servi uniquement le midi, 12,50€).
<br />
<br />
<h4><i class="zmdi zmdi-view-headline"></i>&nbsp;Composition de votre menu</h4>
Ensuite, vous pourrez définir la composition d'un menu en lui ajoutant des sections (ex : entrées, plats).
Ces sections peuvent être de deux types :
<ul>
    <li>
        sélection libre. Vous définissez librement une sélection de produits présents dans votre carte.
        Vous pouvez ajouter n'importe quel produit à votre sélection.
    </li>
    <li>
        liée à une catégorie de produits. Vous pourrez seulement ajouter des produits de cette catégorie.
        Ce mode de fonctionnement est plus restrictif, mais aussi plus précis dans la gestion de vos menus.
    </li>
</ul>
<br />
Pour modifier la sélection de produits proposés dans votre menu, il vous suffit de modifier les différentes
sections qui le compose.
<br />
<br />
<span class="c-red f-500">Important :</span>
<ul>
    <li>
    vous pouvez choisir l'ordre d'affichage des menus et de leur composition
    dans votre carte, au même titre que les catégories de produits ou les produits.
    </li>
</ul>
</p>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <img src="/assets/theme_manager/img/help/menus-ci.png" />
                        </div>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                <ul class="fw-footer pagination wizard">
                    <li class="previous first"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>
                    <li class="previous"><a class="a-prevent" href=""><i class="zmdi zmdi-chevron-left"></i></a></li>
                    <li class="next"><a class="a-prevent" href=""><i class="zmdi zmdi-chevron-right"></i></a></li>
                    <li class="next last"><a class="a-prevent" href=""><i class="zmdi zmdi-more-horiz"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>