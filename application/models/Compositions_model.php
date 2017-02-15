<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Compositions_model extends MY_Model
{
	
	protected $table = 'compositions';
        
	public function select_menu_composition($menu_id) {
		$query = $this->db->query(
			"SELECT compo.id AS compo_id, compo.name AS compo_name, compo.prices_categories AS prices_categories, compo.selection AS compo_selection, compo.note AS compo_note, link_mc.compo_rank AS rank ".
			"FROM menus AS menu, link_menu_compo AS link_mc, compositions AS compo ".
			"WHERE compo.id = link_mc.compo_id ".
			"AND link_mc.menu_id = menu.id ".
			"AND menu.id =".$menu_id." ".
			"ORDER BY rank ASC"
			);
		
		$datas = array();
		foreach ($query->result() as $row){
			$datas[] = $row;
		}
		return  $datas;
	}
	
	
	public function select_composition($compo_id){
		return $this->db
		->select('compo.id AS compo_id, compo.name AS compo_name, compo.prices_categories AS prices_categories, compo.note AS compo_note, menu.id AS menu_id, menu.name AS menu_name')
		->from($this->table.' AS compo, link_menu_compo AS link_mc, menus AS menu')
		->where('compo.id = link_mc.compo_id AND link_mc.menu_id = menu.id AND compo.id='.$compo_id)
		->get()
		->row();
	}
        
	
	public function module_menu_list_composition_ids_by_est($est_id){
            return $this->db
                ->select('compo.id')
                ->from($this->table.' AS compo, link_menu_compo AS link_mc, menus, link_est_menu AS link_em')
                ->where('link_em.est_id = '.$est_id.' AND link_em.menu_id = menus.id AND menus.id = link_mc.menu_id AND link_mc.compo_id = compo.id')
		->get()
		->result();
        }
	
}


