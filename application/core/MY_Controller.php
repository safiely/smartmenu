<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    
	function load_class($class){
		require_once 'application/classes/'.$class.'.php';
	}
	
    function load_module($module){
        require_once 'application/classes/modules/'.$module.'.php';
    }
    
    
    
    
}
