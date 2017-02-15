<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_menu_compo_model extends MY_Model
{
	
	protected $table = 'link_menu_compo';
	
	
	public function select_max_rank_for_composition($fields){
		$result = $this->db->select_max('compo_rank')
			->from($this->table)
			->where($fields)
			->get()
			->row();
		return $result->compo_rank;
	}
	
	public function select_compos_from_menu($fields) {
		return $this->db->select()
			->from($this->table)
			->where($fields)
			->order_by('compo_rank', 'ASC')
			->get()
			->result();
	}
	
}