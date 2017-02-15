<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Categories{
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
		$this->CI->load->model('categories_model', 'cat');
	}

	/**
	 * Return a sipmple list of all the categories of an establishment
	 * @return array (name, rank, image, description)
	 */
	public function categories_list(){
		return $this->CI->cat->select_all_cat_by_est($this->est_id);
	}
	
	
	/**
	 * Fetch establishment's categories datas *
	 * 
	 * @return array $data the formatted array of datas
	 */
	public function categories_manager(){
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		$this->CI->load->model('prices_categories_model', 'prices_cat');
		

		$data = array();
		$data['categories'] = $this->CI->cat->select_all_cat_by_est($this->est_id);
		
		if(count($data['categories'])>0){
			$count_prod_by_cat = $this->CI->link_cp->count_all_products_by_cat($this->est_id);
			$data['one_image'] = false;
			$data['img_cat_default_path'] = '/assets/common/img/categories/default';
			
			foreach($data['categories'] as $cat_id => $cat){
				$data['categories'][$cat_id]['count_products'] = (isset($count_prod_by_cat[$cat_id])) ? $count_prod_by_cat[$cat_id] : 0;
				$data['categories'][$cat_id]['prices_cat'] = '';
				
				if($data['one_image']==false&&$cat['image']!=0){
					$data['one_image'] = true;
				}
				
				$prices_cat = $this->CI->prices_cat->select_many(array( 
					'cat_id' => $cat_id
				));
				if(count($prices_cat)>0){
					$prices_cat_names = array();
					foreach($prices_cat as $k => $row){
						$prices_cat_names[] = $row->name;
					}
					$data['categories'][$cat_id]['prices_cat'] = implode(', ', $prices_cat_names);
				}
			}
		}
		return $data;
	}

	
	/**
	 * Load the formatted datas for a category
	 *
	 * @param int $cat_id
	 *        	the cat ImagickDraw
	 * @return array $data The formatted data's category array
	 */
	public function load_category($cat_id){
		$this->CI->load->model('link_est_cat_model', 'link_ec');
		$this->CI->load->helper('file');
		$data = array();
		
		$category = $this->CI->cat->select_row_array(array( 
			'id' => $cat_id
		));
		$data['id'] = $category['id'];
		$data['name'] = $category['name'];
		$data['image'] = $category['image'];
		$data['description'] = $category['description'];
		
		//VOIR SI YA PAS MOYEN DE FUSIONNER AVC LA METHDE DEDIEE
		//Fetch default image files for categories
		$data['img_cat_default'] = get_filenames('./assets/common/img/categories/default');
		$data['img_cat_default_path'] = '/assets/common/img/categories/default';
		
		$data['count_categories'] = $this->CI->link_ec->count(array( 
			'est_id' => $this->est_id
		));
		

		$data['prices_cat'] = array();
		$data['mod_prices_cat'] = $this->CI->mods->prices_cat;
		$data['prices_category_name'] = '';
		if($data['mod_prices_cat']==1){
			$this->CI->load_module('prices_categories');
			$mod_prices_cat = new Module_prices_categories($this->est_id);
			$mod_prices_cat->reorganize_ranks_prices_categories($cat_id);
			$data['prices_cat'] = $mod_prices_cat->select_prices_for_a_cat($cat_id);
		}
		
		return $data;
	}

	
	public function load_category_minimal_datas($cat_id){
		return $this->CI->cat->select_row_array(array(
			'id' => $cat_id
		));
	}
	
	
	/**
	 * Update category's datas
	 * 
	 * @param int $cat_id
	 *        	The cat id to update
	 * @param array $post
	 *        	The global POST variable
	 */
	public function update_category($cat_id, $post){
		$this->CI->cat->update(array( 
			'id' => $cat_id
		), array( 
			'name' => $post['name'],
			'image' => $post['image'],
			'description' => $post['description']
		));
	}

	
	/**
	 * Add a category
	 *
	 * @param array $post
	 *        	The global POST variable
	 */
	public function add_category($post){
		$this->CI->load->model('link_est_cat_model', 'link_ec');
		
		if($this->category_name_already_exists($post['name'])==true){
			return 'category already exists';
		}
		
		//Insert new category
		$fields = array( 
			'name' => $post['name'],
			'image' => $post['image'],
			'description' => $post['description']
		);
		$this->CI->cat->insert($fields);
		$cat_id = intval($this->CI->db->insert_id());
		
		//Define the rank
		$fields = array( 
			'est_id' => $this->est_id
		);
		$rank = ($this->CI->link_ec->select_max_rank_for_est_cat($fields)+1);
		
		//Insert new relation cat/est
		$fields = array( 
			'est_id' => $this->est_id,
			'cat_id' => $cat_id,
			'cat_rank' => $rank
		);
		
		$this->CI->link_ec->insert($fields);
	}

	
	/**
	 * Delete a category
	 * @param int $cat_id The cat ID to delete
	 */
	public function delete_category($cat_id){
		$this->CI->load->model('link_est_cat_model', 'link_ec');
		$this->CI->link_ec->delete(array( 
			'cat_id' => $cat_id
		));
		$this->CI->cat->delete(array( 
			'id' => $cat_id
		));
	}

	
	

	
	/**
	 * Count the number of categoies in an establishment
	 * 
	 */
	public function count_categories(){
		$this->CI->load->model('link_est_cat_model', 'link_ec');
		return intval($this->CI->link_ec->count(array(
			'est_id' => $this->est_id
		)));
	}
	
	/**
	 * Count the number of products in a category
	 * @param int $cat_id The Cat id
	 */
	public function count_products_in_category($cat_id){
		$this->CI->load->model('link_est_cat_model', 'link_ec');
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		return intval($this->CI->link_cp->count(array( 
			'cat_id' => $cat_id
		)));
	}

	
	/**
	 * Fetch default image files for categories
	 * 
	 * @return array $data the images categories array
	 */
	public function fetch_categories_images(){
		$this->CI->load->helper('file');
		$img_cat_default = get_filenames('./assets/common/img/categories/default');
		$data['img_cat_default'] = array();
		
		foreach($img_cat_default as $k => $file){
			$img_tab = explode('-', $file);
			$img_id = $img_tab[0];
			$img_name = $img_tab[1];
			$data['img_cat_default'][$img_id] = $img_name;
		}
		ksort($data['img_cat_default']);
		$data['img_cat_default_path'] = '/assets/common/img/categories/default';
		return $data;
	}
	
	
	
	public function category_name_already_exists($name){
		//Check if the category name already exist
		$cat_list = $this->categories_list();
		foreach($cat_list as $category){
			if(strtolower($name) == strtolower($category['name'])){
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Check if category exists in the establishment's menus
	 * @param int $cat_id The cat ID to check
	 * @return bool true false if exists
	 */
	public function category_exists_in_menus($cat_id){
		if($this->CI->mods->menus){
			$this->CI->load_module('menu');
			$mod_menu = new Module_menu($this->est_id);
			if($mod_menu->count_category_in_compositions($cat_id)>0){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	
	
	/**
	 * Modify the rank of a category
	 *
	 * @param int $cat_id
	 *        	The category ID to modify
	 * @param string $go
	 *        	The direction of the category movment (up/down)
	 */
	public function modify_category_rank($cat_id, $go){
		$this->CI->load->model('link_est_cat_model', 'link_ec');
	
		$category = $this->CI->link_ec->select(array(
			'cat_id' => $cat_id
		));
	
		if($go=='up')
			$rank = $category->cat_rank-1;
			elseif($go=='down')
			$rank = $category->cat_rank+1;
	
			$to_invert_category = $this->CI->link_ec->select(array(
				'est_id' => $this->est_id,
				'cat_rank' => $rank
			));
			$this->CI->link_ec->update(array(
				'cat_id' => intval($category->cat_id)
			), array(
				'cat_rank' => $rank
			));
			$this->CI->link_ec->update(array(
				'cat_id' => intval($to_invert_category->cat_id)
			), array(
				'cat_rank' => intval($category->cat_rank)
			));
	}
	
	/**
	 * Redonne un ordre logique à l'ordre d'affichage des produits dans les catégories
	 * La fonction fait des requetes et détecte des incohérence dans le stockage de l'ordre
	 * Si il y a incohérence, elle reconstrui un ordre propre selon l'ordre enregistré par l'user
	 */
	public function reorganize_ranks_categories(){
		$this->CI->load->model('link_est_cat_model', 'link_ec');
		$fields = array( 
			'est_id' => $this->est_id
		);
		$ranking = $this->CI->link_ec->select_cat_from_est($fields);
		

		$cats = array();
		foreach($ranking as $key => $est_cat){
			$cats[$est_cat->cat_id] = $est_cat->cat_rank;
		}
		
		$new_cats_ranking = array();
		$i = 1;
		foreach($cats as $cat_id => $rank){
			$new_cats_ranking[$cat_id] = $i;
			$i++;
		}
		
		$diff = (count(array_diff_assoc($cats, $new_cats_ranking))==0) ? false : true;
		
		if($diff==true){
			foreach($new_cats_ranking as $cat_id => $rank){
				$this->CI->link_ec->update(array( 
					'cat_id' => $cat_id
				), array( 
					'cat_rank' => $rank
				));
			}
		}
	}

}

?>