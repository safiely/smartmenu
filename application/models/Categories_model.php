<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories_model extends MY_Model
{
	
	protected $table = 'categories';
	
	
	//POUR LE CRUD : utilisation de la classe parente MY_Model dans application/core
        
        public function select_all_cat_by_est($est_id){
            $query = $this->db
                ->select('cat.id, cat.name, cat.image, cat.description, link_ec.cat_rank AS rank')
                ->from($this->table.' AS cat, link_est_cat AS link_ec')
                ->where('link_ec.est_id = '.$est_id.' AND cat.id = link_ec.cat_id')
		->order_by('cat_rank', 'ASC');
            
            $datas = array();
	    
            foreach($query->get()->result() as $row){
                $data[$row->id] = array();
                $datas[$row->id]['name'] = $row->name;
                $datas[$row->id]['rank'] = $row->rank;
		$datas[$row->id]['image'] = $row->image;
		$datas[$row->id]['description'] = $row->description;
            }
            
            return $datas;
            
        }
	
	public function select_image_category($id){
		$query = $this->db
			->select('image')
			->from($this->table)
			->where('id = '.$id)
			->get()
			->row();
		return $query->image;
        }
        
	
}


