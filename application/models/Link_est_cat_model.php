<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_est_cat_model extends MY_Model
{
	
	protected $table = 'link_est_cat';
	
	
	public function select_max_rank_for_est_cat($fields){
		$result = $this->db->select_max('cat_rank')
			->from($this->table.' AS link_ec')
			->where($fields)
			->get()
			->row();
		return $result->cat_rank;
	}
	
	public function select_cat_from_est($fields) {
		return $this->db->select()
			->from($this->table)
			->where($fields)
			->order_by('cat_rank', 'ASC')
			->get()
			->result();
	}
	
}