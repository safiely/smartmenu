<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Link_prod_prices_model extends MY_Model
{
	
	protected $table = 'link_prod_prices';
        
        public function select_prices_for_a_product($prod_id){
            return $this->db
                ->select('prices_cat.name, link_pp.price, prices_cat.id')
                ->from($this->table.' AS link_pp, prices_categories AS prices_cat')
                ->where('link_pp.prod_id='.$prod_id.' AND link_pp.prices_id=prices_cat.id')
                ->order_by('prices_cat.rank ASC')
                ->get()
                ->result();
        }
	
        public function select_name_and_price_for_one_product($prod_id, $prices_cat_id){
            return $this->db
                ->select('prices_cat.name, link_pp.price')
                ->from($this->table.' AS link_pp, prices_categories AS prices_cat, products AS prod')
                ->where('link_pp.prod_id='.$prod_id.' AND link_pp.prices_id='.$prices_cat_id.' AND link_pp.prices_id=prices_cat.id')
                ->get()
                ->result();
        }
        
}