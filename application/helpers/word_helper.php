<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY Words Helper
 *
 * 
 */

// ------------------------------------------------------------------------


function single_or_plurial($count, $single, $plural){
    
        if(!is_integer($count) || !is_string($single) || !is_string($plural))
            return false;
        
        if($count==0 || $count==1)
            return $single;
        else
            return $plural;
}
