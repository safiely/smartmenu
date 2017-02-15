<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_cat_prod_model extends MY_Model
{
	
	protected $table = 'link_cat_prod';
	
	
	//POUR LE CRUD : utilisation de la classe parente MY_Model dans application/core
	
	public function count_all_products_by_cat($est_id){
		$query = $this->db
			->select('link_cp.cat_id AS cat_id, COUNT(*) as cnt_prod')
			->from($this->table.' AS link_cp, link_est_cat AS link_ec')
			->where('link_cp.cat_id = link_ec.cat_id AND link_ec.est_id='.$est_id)
			->group_by('link_cp.cat_id');
			
		
		
		$data = array();
		
		foreach($query->get()->result() as $row){
			$data[$row->cat_id] = $row->cnt_prod;
		}
		
		return $data;
	}
	
	public function select_max_rank_for_cat_prod($fields){
		$result = $this->db->select_max('prod_rank')
			->from($this->table.' AS link_cp')
			->where($fields)
			->get()
			->row();
		return $result->prod_rank;
	}
	
	public function select_product_from_cat($fields) {
		return $this->db->select()
			->from($this->table)
			->where($fields)
			->order_by('prod_rank', 'ASC')
			->get()
			->result();
	}
	
	public function select_datas_product_from_cat($cat_id) {
		return $this->db->select()
			->from($this->table.' AS link_cp, products AS prod')
			->where('cat_id='.$cat_id.' AND link_cp.prod_id=prod.id')
			->order_by('prod_rank', 'ASC')
			->get()
			->result();
	}
	
	public function select_datas_product_from_cat_UI($cat_id) {
		return $this->db->select()
			->from($this->table.' AS link_cp, products AS prod')
			->where('cat_id='.$cat_id.' AND link_cp.prod_id=prod.id AND prod.not_in_card=0 AND prod.sold_out=0')
			->order_by('prod_rank', 'ASC')
			->get()
			->result();
	}
	
	public function select_datas_product_for_menus($cat_id) {
		return $this->db->select('prod.id AS id, prod.name, prod.image, prod.suggest, prod.composition')
			->from($this->table.' AS link_cp, products AS prod')
			->where('cat_id='.$cat_id.' AND link_cp.prod_id=prod.id AND prod.sold_out=0')
			->order_by('prod_rank', 'ASC')
			->get()
			->result();
	}
	
	
}