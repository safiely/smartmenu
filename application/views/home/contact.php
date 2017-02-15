<div class="page-header" id="banner">
    <div class="row">
        <div class="col-xs-12">
            <h1>Contact</h1>
            <p class="lead">Nous vous répondrons dans les plus brefs délais.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
        <?=form_open('home/contact_check_form')?>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Votre email</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <input type="text" name="email" id="email" value="<?=set_value('email')?>" class="form-control" />
                    <?=form_error('email')?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Sujet</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <input type="text" name="subject" value="<?=set_value('subject')?>" class="form-control" />
                    <?=form_error('subject')?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                <div class="form-group">
                    <label>Message</label>
                    <i class="zmdi zmdi-star zmdi-hc-fw obligatory"></i>
                    <textarea name="message" style="overflow: hidden; word-wrap: break-word; height: 150px;" class="form-control"><?=set_value('message')?></textarea>
                    <?=form_error('message')?>
                </div>
            </div>
        </div>
        <div class="row last">
            <div class="col-xs-12 text-left">
                <button type="submit" class="btn btn-primary btn-sm m-t-10">Envoyer</button>
                <? if(!empty($message)) {
                    echo $message;
                } ?>
            </div>
        </div>
        <?=form_close()?>
        </div>
    </div>
</div>