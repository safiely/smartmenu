<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prices_categories_model extends MY_Model
{
	
	protected $table = 'prices_categories';
	
	
	
        public function select_max_rank_for_a_cat($fields){
		$result = $this->db->select_max('rank')
			->from($this->table)
			->where($fields)
			->get()
			->row();
		return $result->rank;
	}
        
        public function select_prices_for_a_cat($fields) {
		return $this->db
                ->select()
                ->from($this->table)
                ->where($fields)
                ->order_by('rank ASC')
                ->get()
                ->result();
	}
	
	public function select_prices_cat_name_by_est_and_products($est_id){
		$query = $this->db
		->select('prices_cat.id AS prices_cat_id, prices_cat.name AS prices_cat_name,  link_pp.prod_id')
		->from($this->table.' AS prices_cat, categories AS cat, link_est_cat AS link_ec, link_prod_prices AS link_pp')
		->where('prices_cat.cat_id = cat.id AND cat.id = link_ec.cat_id AND prices_cat.id = link_pp.prices_id AND link_ec.est_id='.$est_id)
		->order_by('prices_id');
		
		$datas = array();
		foreach($query->get()->result() as $row){
			$datas['prices_cat_name'][$row->prices_cat_id] = $row->prices_cat_name;
			$datas['prod_affected'][$row->prod_id][] = $row->prices_cat_id;
		}
		
		return $datas;
		
	}
	
	public function select_prices_cat_by_cat($cat_id) {
		return $this->db
		->select()
		->from($this->table)
		->where('cat_id = '.$cat_id)
		->order_by('rank ASC')
		->get()
		->result();
	}
	
	public function select_prices_cat_not_deleted($deleted, $cat_id) {
		return $this->db
		->select()
		->from($this->table)
		->where('cat_id = '.$cat_id.' AND id!='.$deleted)
		->get()
		->result();
	}
	
	public function module_prices_cat_list_ids($est_id){
		return $this->db
		->select('prices_cat.id')
		->from($this->table.' AS prices_cat, categories AS cat, link_est_cat AS link_ec')
		->where('prices_cat.cat_id = cat.id AND cat.id = link_ec.cat_id AND link_ec.est_id='.$est_id)
		->get()
		->result();
	}
	
	
       
}


