<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Selections_model extends MY_Model
{
	
	protected $table = 'selections';
        
	
	
        public function select_datas_product_by_cat($cat_id) {
                return $this->db->select('prod.id, prod.name')
                        ->from('link_cat_prod AS link_cp, products AS prod')
                        ->where('cat_id='.$cat_id.' AND link_cp.prod_id=prod.id')
                        ->order_by('prod_rank', 'ASC')
                        ->get()
                        ->result();
        }
	
	public function select_datas_product_by_est($est_id) {
                return $this->db->select('prod.id, prod.name AS prod_name, cat.name AS cat_name, cat.id AS cat_id, link_ec.cat_rank AS cat_rank, link_cp.prod_rank AS prod_rank')
                        ->from('establishments AS est, link_est_cat AS link_ec, categories AS cat, link_cat_prod AS link_cp, products AS prod')
                        ->where('prod.id = link_cp.prod_id AND link_cp.cat_id = cat.id AND cat.id = link_ec.cat_id AND link_ec.est_id = est.id AND est.id='.$est_id)
                        ->order_by('link_cp.prod_rank', 'ASC')
                        ->get()
                        ->result();
        }
        
	
	public function select_datas_product_for_menus($compo_id) {
		return $this->db->select('prod.id AS id, prod.name, prod.image, prod.composition,  prod.suggest, selection.txt_prices_cat, cat.name AS cat_name')
			->from($this->table.' AS selection, products AS prod, link_cat_prod AS link_cp, categories AS cat, link_est_cat AS link_ec')
			->where('selection.compo_id='.$compo_id.' AND selection.prod_id=prod.id AND prod.id=link_cp.prod_id AND link_cp.cat_id=cat.id AND cat.id = link_ec.cat_id AND prod.sold_out=0')
			->order_by('link_ec.cat_rank ASC, link_cp.prod_rank ASC')
			->get()
			->result();
	}
        
}