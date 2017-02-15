<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Products{
	private $CI;
	private $est_id;

	
	/**
	 * Menu Constructor
	 *
	 * @param int $est_id        	
	 */
	public function __construct($est_id){
		$this->CI = & get_instance();
		$this->est_id = $est_id;
		$this->CI->load->model('products_model', 'prod');
	}

	
	/**
	 * Return the formatted array for the products list in the manager
	 *
	 * @param int $cat_id
	 *        	the category ID we need
	 * @return array $data The formatted array
	 */
	public function products_by_cat($cat_id){
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		$this->CI->load->model('link_prod_prices_model', 'link_pp');
		
		$this->CI->load_class('categories');
		$cat = new Categories($this->est_id);
		
		$data = array();
		$data['products'] = $this->CI->link_cp->select_datas_product_from_cat($cat_id);
		$data['one_image'] = false;
		$data['category'] = $cat->load_category_minimal_datas($cat_id);
		$data['category']['products'] = array();
		$data['category']['count_products'] = 0;
		
		foreach($data['products'] as $k => $v){
			$id = $v->id;
			$data['category']['products'][$id] = $v;
			
			//Check the prices categories
			if($v->prices_categories==0){
				$data['category']['products'][$id]->price = number_format($v->price, 2);
			} else{
				$data['category']['products'][$id]->price = $this->CI->link_pp->select_prices_for_a_product($id);
			}
			
			//Images
			if(!empty($v->image)){
				$data['category']['products'][$id]->image = '/uploads/products/thumbnails/thumb_'.$v->image;
			} elseif($data['category']['image']!='0'){
				$data['category']['products'][$id]->image = '/assets/common/img/categories/default/'.$data['category']['image'];
			} else{
				$data['category']['products'][$id]->image = '';
			}
			if($data['one_image']==false&&!empty($data['category']['products'][$id]->image)){
				$data['one_image'] = true;
			}
			
			$data['category']['count_products'] = intval($data['category']['count_products'])+1;
			unset($data['category']['products'][$id]->id);
			unset($data['category']['products'][$id]->cat_id);
		}
		
		// IMPORTANT VOIR SI JE PEUX MODIFIER LA REQUETE SQL POUR AVOIR LE BON ALLIAS SANS FOUTRE LE BORDEL
		foreach($data['category']['products'] as $prod_id => $prod){
			$data['category']['products'][$prod_id]->rank = $data['category']['products'][$prod_id]->prod_rank;
			unset($data['category']['products'][$prod_id]->prod_rank);
		}
		
		uasort($data['category']['products'], array( 
			$this,
			'cmp_obj'
		));
		unset($data['products']);
		return $data;
	}

	
	/*
	 * Load all the information of a product
	 * @param int $prod_id The prod id to load
	 * @return array of objects The product's datas
	 */
	public function load_product($prod_id){
		return $this->CI->prod->select_a_product($prod_id);
	}

	public function add_product($post){
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		
		$prices_categories = ($post['prices_categories']==0) ? 0 : 1;
		$price = ($prices_categories==0) ? str_replace(',', '.', $post['price']) : 0;
		
		//Insert new product
		$fields = array( 
			'name' => $post['name'],
			'composition' => $post['composition'],
			'prices_categories' => $prices_categories,
			'price' => $price
		);
		$this->CI->prod->insert($fields);
		$new_prod_id = intval($this->CI->db->insert_id());
		
		//Define the rank
		$fields = array( 
			'cat_id' => $post['category']
		);
		$rank = ($this->CI->link_cp->select_max_rank_for_cat_prod($fields)+1);
		
		//Insert new relation cat/prod
		$fields = array( 
			'prod_id' => $new_prod_id,
			'cat_id' => $post['category'],
			'prod_rank' => $rank
		);
		$this->CI->link_cp->insert($fields);
		

		return $new_prod_id;
	}

	
	/**
	 * Update the product's datas
	 *
	 * @param int $prod_id
	 *        	The prod id
	 * @param array $post
	 *        	The global $_POST variable
	 * @param str $image
	 *        	The name of the image file (if exists), or an empty string
	 *        	
	 */
	public function update_product($prod_id, $post){
		$suggest = (element('suggest', $post)=='on') ? 1 : 0;
		$not_in_card = (element('not_in_card', $post)=='on') ? 1 : 0;
		$sold_out = (element('sold_out', $post)=='on') ? 1 : 0;
		$prices_categories = (element('prices_categories', $post)==0) ? 0 : 1;
		$price = ($prices_categories==0) ? str_replace(',', '.', $post['price']) : 0;
		$cat_id = element('category', $post);
		

		$fields = array( 
			'name' => $post['name'],
			'composition' => $post['composition'],
			'prices_categories' => $prices_categories,
			'price' => $price,
			'suggest' => $suggest,
			'not_in_card' => $not_in_card,
			'sold_out' => $sold_out
		);
		
		$this->CI->prod->update(array( 
			'id' => $prod_id
		), $fields);
	}

	
	/**
	 * Change the product's category
	 */
	public function modify_product_category($prod_id, $cat_id){
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		$this->CI->load->model('link_prod_prices_model', 'link_pp');
		$this->CI->link_pp->delete(array( 
			'prod_id' => $prod_id
		));
		$rank = $this->CI->link_cp->select_max_rank_for_cat_prod(array( 
			'cat_id' => $cat_id
		))+1;
		$this->CI->link_cp->update(array( 
			'prod_id' => $prod_id
		), array( 
			'cat_id' => $cat_id,
			'prod_rank' => $rank
		));
	}

	
	/**
	 * Upload image on a product
	 *
	 * @param int $prod_id
	 *        	the Prod ID to update
	 * @param array $img
	 *        	The global $_FILE variable
	 * @return array $data['logo_error'] : empty string if it's ok, array of errors if not
	 */
	public function upload_image_product($prod_id, $files){
		if(!empty($files['logo']['name'])){
			$config['upload_path'] = './uploads/products';
			$config['file_name'] = 'product_'.$prod_id;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['overwrite'] = true;
			$this->CI->load->library('upload', $config);
			
	
			//UPLOAD THE FILE
			if(!$this->CI->upload->do_upload('logo')){
				$data = array( 
					'error' => $this->CI->upload->display_errors()
				);
				return $data;
			}
			
	
			//UPLOAD OK : RESIZE IMAGE				
			$path = './uploads/products/';
			$file = $this->CI->upload->data('file_name');
			
			$this->CI->load->library('image_lib');
			$this->CI->image_lib->resize_to_1024_by_768_max($path, $file);
			$this->CI->image_lib->crop_image($path, $file);
			$this->CI->image_lib->thumbnailize_image($path, $file);
			
			//Update the image field product in database
			$fields = array( 
				'image' => $file
			);
			$this->CI->prod->update(array( 
				'id' => $prod_id
			), $fields);
		}
	}

	
	/**
	 * Delete a product
	 *
	 * @param int $prod_id
	 *        	The prod ID
	 */
	public function delete_product($prod_id){
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		$this->CI->load->model('link_prod_prices_model', 'link_pp');
		$this->CI->load->model('selections_model', 'selection');
		
		$product = $this->load_product($prod_id);
		
		//Delete relation cat / prod
		$this->CI->link_cp->delete(array( 
			'prod_id' => $prod_id
		));
		
		//Delete relation prod/prices
		if($this->CI->link_pp->count(array( 
			'prod_id' => $prod_id
		))>0){
			$this->CI->link_pp->delete(array( 
				'prod_id' => $prod_id
			));
		}
		
		//Delete products from selection
		$this->CI->selection->delete(array( 
			'prod_id' => $prod_id
		));
		
		//Delete product's image		
		if(!empty($product->image)){
			if(file_exists('./uploads/products/'.$product->image)==true){
				unlink('./uploads/products/'.$product->image);
			}
			if(file_exists('./uploads/products/thumbnails/thumb_'.$product->image)==true){
				unlink('./uploads/products/thumbnails/thumb_'.$product->image);
			}
		}
		
		//Delete the product
		$this->CI->prod->delete(array( 
			'id' => $prod_id
		));
	}
	
	
	public function count_all_products_by_est(){
		return intval($this->CI->prod->count_all_prod_by_est($this->est_id));
	}
	

	public function modify_product_rank($prod_id, $go){
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		
		$product = $this->CI->link_cp->select(array( 
			'prod_id' => $prod_id
		));
		
		if($go=='up')
			$rank = $product->prod_rank-1;
		elseif($go=='down')
			$rank = $product->prod_rank+1;
		
		$to_invert_product = $this->CI->link_cp->select(array( 
			'cat_id' => $product->cat_id,
			'prod_rank' => $rank
		));
		$this->CI->link_cp->update(array( 
			'prod_id' => intval($product->prod_id)
		), array( 
			'prod_rank' => $rank
		));
		$this->CI->link_cp->update(array( 
			'prod_id' => intval($to_invert_product->prod_id)
		), array( 
			'prod_rank' => intval($product->prod_rank)
		));
		return $product;
	}

	
	/**
	 * Redonne un ordre logique à l'ordre d'affichage des produits dans les catégories
	 * La fonction fait des requetes et détecte des incohérence dans le stockage de l'ordre
	 * Si il y a incohérence, elle reconstrui un ordre propre selon l'ordre enregistré par l'user
	 */
	public function reorganize_ranks_products($cat_id){
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		$fields = array( 
			'cat_id' => $cat_id
		);
		$ranking = $this->CI->link_cp->select_product_from_cat($fields);
		$prods = array();
		foreach($ranking as $key => $cat_prod){
			$prods[$cat_prod->prod_id] = $cat_prod->prod_rank;
		}
		
		$new_prods_ranking = array();
		$i = 1;
		foreach($prods as $prod_id => $rank){
			$new_prods_ranking[$prod_id] = $i;
			$i++;
		}
		
		$diff = (count(array_diff_assoc($prods, $new_prods_ranking))==0) ? false : true;
		if($diff==true){
			foreach($new_prods_ranking as $prod_id => $rank){
				$this->CI->link_cp->update(array( 
					'prod_id' => $prod_id
				), array( 
					'prod_rank' => $rank
				));
			}
		}
	}

	/**
	 * Triage des produits par rang dans la page products
	 */
	static function cmp_obj($a, $b){
		return ($a->rank>$b->rank) ? +1 : -1;
	}

}

?>