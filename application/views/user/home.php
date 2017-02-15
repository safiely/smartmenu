<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="row center-xs center-sm center-md center-lg">
    <div class="col-xs-12">
	<div class="box">
	    <div class="presentation note-editor">
	    <? if(!empty($customisation->presentation)) { ?>
		    <?=$customisation->presentation?>
	    <? } else { ?>
		    <?=$est->name?>
	    <? } ?>
	    </div>	    
	</div>
    </div>
</div>


<div data-role="footer" data-position="fixed" role="contentinfo" class="ui-footer ui-bar-inherit ui-footer-fixed slideup home_footer">
    <div class="row">
	<div class="col-xs-12 center-xs footer_action">
	    <div class="box">
		<?
        if(count($categories)>0) {
            echo "<a href='#leftpanel_home' class='ui-btn ui-btn-inline see_card_button'><i class='zmdi zmdi-local-library zmd-fw'></i></a>";
        }

		if(!empty($est->adress) && !empty($est->postal_code) && !empty($est->city)){
		    $adr = $est->adress.', '.$est->postal_code.' '.$est->city;
		    $encoded = urlencode($adr);
		    echo "<a target='_blank' href='https://maps.google.fr/maps?q=$encoded&t=h&z=16' class='ui-btn ui-btn-inline'><i class='zmdi zmdi-my-location zmd-fw'></i></a>";
		}

		if(!empty($est->phone)){
		    echo "<a href='tel:",$est->phone,"'' class='ui-btn ui-btn-inline'><i class='zmdi zmdi-local-phone zmd-fw'></i></a>";
		}

		if(!empty($est->web_site)){						    
		    echo "<a href='",$est->web_site,"' target='_blank' class='ui-btn ui-btn-inline'><i class='zmdi zmdi-globe-alt zmd-fw'></i></a>";
		}

        if(isset($modules->social)){
            if(!empty($mod_social->facebook)){
                echo "<a href='' data-fb-id='",$mod_social->facebook,"' id='fb-link' target='_blank' class='ui-btn ui-btn-inline'><i class='zmdi zmdi-facebook-box'></i></a>";
            }
            if(!empty($mod_social->twitter)){
                echo "<a href='",$mod_social->twitter,"' target='_blank' class='ui-btn ui-btn-inline'><i class='zmdi zmdi-twitter-box'></i></a>";
            }
            if(!empty($mod_social->instagram)){
                echo "<a href='",$mod_social->instagram,"' target='_blank' class='ui-btn ui-btn-inline'><i class='zmdi zmdi-instagram'></i></a>";
            }
		}
		?>

		<div class="info_contact_footer">
		<?=$est->name?>
		<?
		if(!empty($est->adress) && !empty($est->postal_code) && !empty($est->city)) { 
		    $adr = $est->adress.', '.$est->postal_code.' '.$est->city;
		    echo ' - ',$adr;
		}
		
		if(!empty($est->phone)){
		    echo " - ",$est->phone;
		}
		if(!empty($est->web_site)){
		    echo " - ",$est->web_site;
		}
		?>
		</div>
	    </div>
	</div>
	
    </div>
</div>