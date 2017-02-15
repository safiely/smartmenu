<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?=form_open('manager/add_menu_check_form')?>
<div class="tile">
    <div class="t-body tb-padding">
        <div class="row">
            <div class="col-xs-12">
                <div class="tile bg-green">
                    <div class="t-header th-alt">
                        <div class="th-title">
                            Pour créer un menu, vous devez renseigner au moins son nom et son prix. Une fois créé,
                            vous pourrez définir sa composition.
                            <a href="/manager/help#menu" class="help_link"><i class="zmdi zmdi-help"></i>&nbsp;Voir l'aide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
                <div class="form-group">
                    <label>Nom du menu</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-assignment"></i></span>
                        <input type="text" name="name" id="name" value="<?=set_value('name')?>" class="form-control" placeholder="Le nom de votre menu" />
                    </div>
                    <?=form_error('name')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-5">
                <div class="form-group">
                    <label>Informations complémentaire</label>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-info-outline"></i></span>
                        <input type="text" name="note" value="<?=set_value('note')?>" class="form-control" placeholder="Informations particulières concernant ce menu." />
                    </div>
                    <?=form_error('note')?>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-2">
                <div class="form-group">
                    <label>Prix</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <div class="input-group">
                        <span class="input-group-addon last"><i class="zmdi zmdi-money"></i></span>
                        <input type="text" name="price" value="<?=set_value('price')?>" class="form-control" />
                    </div>
                    <?=form_error('price')?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Créer le menu</button>
                <a name="manage"></a>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>