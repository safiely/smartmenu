<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_compo_prices_model extends MY_Model
{
	
	protected $table = 'link_compo_prices';
	
	public function select_prices_cat_name_from_compo_id($compo_id){
            return $this->db
            ->select('prices_cat.name')
            ->from($this->table.' AS link_cp, prices_categories AS prices_cat')
            ->where('link_cp.prices_id = prices_cat.id AND link_cp.compo_id='.$compo_id)
            ->get()
            ->row();
        }
	
	
}