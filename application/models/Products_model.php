<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Products_model extends MY_Model{
	protected $table = 'products';
	
	// FAIRE LES ATTRIBUTS CORRESPONDANT AUX CHAMPS DE LA TABLE (a faire sur toutes les autres classes aussi)
	public function select_a_product($prod_id){
		return $this->db->select('prod.id, prod.name, prod.composition, prod.prices_categories, prod.price, prod.image, prod.suggest, prod.not_in_card, prod.sold_out, link_cp.prod_rank AS rank, link_cp.cat_id AS cat_id')->from($this->table.' AS prod, link_cat_prod AS link_cp')->where('link_cp.prod_id = prod.id AND prod.id = '.$prod_id)->get()->row();
	}

	public function count_all_prod_by_est($est_id){
		return $this->db->where('link_ec.est_id = '.$est_id.' AND link_cp.cat_id = link_ec.cat_id AND prod.id = link_cp.prod_id')->from($this->table.' AS prod, link_est_cat AS link_ec, link_cat_prod AS link_cp')->count_all_results();
	}

	public function list_products_by_est($est_id){
		return $this->db->select('prod.id, prod.name, link_cp.cat_id AS cat_id, link_cp.prod_rank AS rank')->from($this->table.' AS prod, link_est_cat AS link_ec, link_cat_prod AS link_cp')->where('link_ec.est_id = '.$est_id.' AND link_cp.cat_id = link_ec.cat_id AND prod.id = link_cp.prod_id')->get()->result();
	}

	public function select_cat_default_image($id){
		$query = $this->db->select('cat.image')->from($this->table.' AS prod, link_cat_prod AS link_cp, categories AS cat')->where('prod.id = link_cp.prod_id AND link_cp.cat_id = cat.id AND prod.id = '.$id)->get()->row();
		return $query->image;
	}

	public function module_suggestion_products_ids($est_id){
		return $this->db->select('prod.id')->from($this->table.' AS prod, link_est_cat AS link_ec, link_cat_prod AS link_cp')->where('link_ec.est_id = '.$est_id.' AND link_cp.cat_id = link_ec.cat_id AND prod.id = link_cp.prod_id AND prod.suggest="1"')->get()->result();
	}

	public function list_suggested_products_by_est($est_id){
		return $this->db->select('prod.id, prod.name, link_cp.cat_id AS cat_id, link_cp.prod_rank AS prod_rank, link_ec.cat_rank, cat.name AS cat_name, prod.image AS image, cat.image AS cat_image')->from($this->table.' AS prod, link_est_cat AS link_ec, link_cat_prod AS link_cp, categories AS cat')->where('link_ec.est_id = '.$est_id.' AND link_cp.cat_id = link_ec.cat_id AND prod.id = link_cp.prod_id AND prod.suggest=1 AND link_cp.cat_id = cat.id')->get()->result();
	}

	public function module_suggestion_reset($list){
		return $this->db->where('id IN ('.$list.')')->update($this->table, array( 
			'suggest' => '0'
		));
	}

}