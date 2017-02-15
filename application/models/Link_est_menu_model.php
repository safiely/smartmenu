<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_est_menu_model extends MY_Model
{
	
	protected $table = 'link_est_menu';
	
	
	public function select_max_rank_for_est_menu($fields){
		$result = $this->db->select_max('menu_rank')
			->from($this->table.' AS link_em')
			->where($fields)
			->get()
			->row();
		return $result->menu_rank;
	}
	
	public function select_menu_from_est($fields) {
		return $this->db->select()
			->from($this->table)
			->where($fields)
			->order_by('menu_rank', 'ASC')
			->get()
			->result();
	}
	
	public function select_menu_datas_from_est($est_id) {
		return $this->db->select('menus.id, menus.name')
			->from($this->table.' AS link_em, menus')
			->where('link_em.est_id='.$est_id.' AND link_em.menu_id = menus.id')
			->order_by('link_em.menu_rank', 'ASC')
			->get()
			->result();
	}
	
	
}