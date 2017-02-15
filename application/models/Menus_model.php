<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menus_model extends MY_Model
{
	
	protected $table = 'menus';
	
	
	//POUR LE CRUD : utilisation de la classe parente MY_Model dans application/core
        
        public function select_all_menus_by_est($est_id){
            $query = $this->db
                ->select('menu.id, menu.name, menu.price, menu.note, link_em.menu_rank AS rank')
                ->from($this->table.' AS menu, link_est_menu AS link_em')
                ->where('link_em.est_id = '.$est_id.' AND menu.id = link_em.menu_id')
		->order_by('menu_rank', 'ASC');
            
            $datas = array();
	    
            foreach($query->get()->result() as $row){
                $data[$row->id] = array();
                $datas[$row->id]['name'] = $row->name;
                $datas[$row->id]['rank'] = $row->rank;
                $datas[$row->id]['price'] = $row->price;
                $datas[$row->id]['note'] = $row->note;
            }
            
            return $datas;
            
        }
        
	
	public function list_menus_by_est($est_id){
            $query = $this->db
                ->select('menu.id, menu.name, link_em.menu_rank AS rank')
                ->from($this->table.' AS menu, link_est_menu AS link_em')
                ->where('link_em.est_id = '.$est_id.' AND menu.id = link_em.menu_id')
		->order_by('menu_rank', 'ASC');
            
            $datas = array();
	    
            foreach($query->get()->result() as $row){
                $data[$row->id] = array();
                $datas[$row->id]['name'] = $row->name;
                $datas[$row->id]['rank'] = $row->rank;
            }
            
            return $datas;
            
        }
	
	
	public function module_menu_list_menus_ids_by_est($est_id){
            return $this->db
                ->select('menu.id')
                ->from($this->table.' AS menu, link_est_menu AS link_em')
                ->where('link_em.est_id = '.$est_id.' AND menu.id = link_em.menu_id')
		->get()
		->result();
        }
	
	
	
}


