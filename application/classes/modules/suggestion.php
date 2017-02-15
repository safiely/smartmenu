<?php

if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Module_suggestion{
	private $CI;
	private $est_id;

	public function __construct($est_id){
		$this->CI = & get_instance();
		$this->CI->load->model('products_model', 'prod_model');
		$this->est_id = $est_id;
	}

	
	/**
	 * Load all the suggested products of an establishments
	 */
	public function load_suggested_products(){
		$suggested_products = $this->CI->prod_model->list_suggested_products_by_est($this->est_id);
		$data = array();
		foreach($suggested_products as $k => $prod){
			$data[$prod->cat_name][$prod->name] = $prod;
			
			//Images management
			if(!empty($prod->image)){
				$data[$prod->cat_name][$prod->name]->image = '/uploads/products/thumbnails/thumb_'.$prod->image;
			} elseif($prod->image=='0'){
				$data[$prod->cat_name][$prod->name]->image = '/assets/common/img/categories/default/'.$prod->cat_image;
			} else{
				$data[$prod->cat_name][$prod->name]->image = '';
			}
		}
		return $data;
	}

	public function delete_suggestion($prod_id){
		$this->CI->prod_model->update(array( 
			'id' => $prod_id
		), array( 
			'suggest' => 0
		));
	}

	
	/**
	 * Delete all suggestions in establishment's products
	 */
	public function delete_all_suggestions(){
		$ids = $this->CI->prod_model->module_suggestion_products_ids($this->est_id);
		$tab_ids = array();
		
		foreach($ids as $k => $v){
			$tab_ids[] = $v->id;
		}
		$list_ids = implode(',', $tab_ids);
		$this->CI->prod_model->module_suggestion_reset($list_ids);
	}

}