<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_compo_cat_model extends MY_Model
{
	
	protected $table = 'link_compo_cat';
	
	public function select_category($compo_id) {
		return $this->db
		->select('cat.id AS cat_id, cat.image AS cat_image, cat.name AS cat_name')
		->from($this->table.' AS link_cc, categories AS cat')
		->where('link_cc.compo_id = '.$compo_id.' AND link_cc.cat_id = cat.id')
		->get()
		->row();
	}
	
	
}