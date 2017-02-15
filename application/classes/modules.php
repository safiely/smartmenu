<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Modules{
	private $CI;
	private $est_id;

	
	/**
	 * Menu Constructor
	 *
	 * @param int $est_id        	
	 */
	public function __construct($est_id){
		$this->CI = & get_instance();
		$this->est_id = $est_id;
		$this->CI->load->model('modules_model', 'module');
	}

	
	public function load_modules(){
		return $this->CI->module->select(array(
			'est_id' => $this->est_id
		));
	}
	
	public function switch_module($post){
		$mod_id = $post['mod_id'];
		$value = $post['value'];
		
		$this->CI->module->update(array( 
			'est_id' => $this->est_id
		), array( 
			$mod_id => $value
		));
		

		//Disable the module
		if($value==0){
			if($mod_id=='suggest'){
				$this->CI->load_module('suggestion');
				$mod_suggest = new Module_suggestion($this->est_id);
				$mod_suggest->delete_all_suggestions();
			} 


			elseif($mod_id=='prices_cat'){
				$this->CI->load_module('prices_categories');
				$mod_prices_cat = new Module_prices_categories($this->est_id);
				$mod_prices_cat->delete_all_prices_categories();
			} 


			elseif($mod_id=='menus'){
				$this->CI->load_module('menu');
				$mod_menu = new Module_menu($this->est_id);
				$mod_menu->delete_all_menus();
			} 


			elseif($mod_id=='social'){
				$this->CI->load_module('social');
				$mod_social = new Module_social($this->est_id);
				$mod_social->delete();
			}
		} 		

		//Enable the module
		else{
			if($mod_id=='social'){
				$this->CI->load_module('social');
				$mod_social = new Module_social($this->est_id);
				$mod_social->insert();
			}
		}
		
		return $mod_id;
	}

}

?>