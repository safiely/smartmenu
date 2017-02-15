<?php

if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Module_menu{
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
		$this->CI->load->model('menus_model', 'menus');
	}
	
	/**
	 * Load the menu's datas
	 *
	 * @param int $menu_id
	 *        	Menu id
	 * @return array $data The entire menu's datas (name, section, composition, etc...)
	 */
	public function load_menu($menu_id){
		$this->CI->load->model('link_menu_compo_model', 'link_mc');
		$this->CI->load->model('link_compo_cat_model', 'link_cc');
		$this->CI->load->model('link_compo_prices_model', 'link_cp');
	
		//Generic menu's datas
		$data = array();
		$data['menu'] = $this->CI->menus->select_row_array(array(
			'id' => $menu_id
		));
	
		//Fetch datas for add a new composition
		$this->CI->load_class('categories');
		$cat = new Categories($this->est_id);
		$categories = $cat->categories_list();
		
		$data['categories'] = array();
		foreach($categories as $cat_id => $cat){
			$data['categories'][$cat_id] = $cat['name'];
		}
		asort($data['categories']);
	
		$count_compo = $this->CI->link_mc->count(array(
			'menu_id' => $menu_id
		));
	
		if($count_compo==0){
			$data['composition'] = array();
		} else{
			$this->CI->load->model('compositions_model', 'compo');
			$db_composition = $this->CI->compo->select_menu_composition($menu_id);
			$composition = array();
				
			foreach($db_composition as $k => $compo){
				$composition[$compo->rank]['id'] = $compo->compo_id;
				$composition[$compo->rank]['rank'] = $compo->rank;
				$composition[$compo->rank]['prices_categories'] = $compo->prices_categories;
				$composition[$compo->rank]['selection'] = $compo->compo_selection;
				$composition[$compo->rank]['note'] = $compo->compo_note;
				$composition[$compo->rank]['name'] = $compo->compo_name;
	
				$link_cc = $this->CI->link_cc->select_category($compo->compo_id);
				if(count($link_cc)==1){
					$composition[$compo->rank]['linked_cat'] = $link_cc->cat_name;
				} else{
					$composition[$compo->rank]['linked_cat'] = '';
				}
	
				if($compo->prices_categories==1){
					$prices_cat_name = $this->CI->link_cp->select_prices_cat_name_from_compo_id($compo->compo_id);
					$composition[$compo->rank]['prices_categories_name'] = $prices_cat_name->name;
				} else{
					$composition[$compo->rank]['prices_categories_name'] = '';
				}
			}
				
			$data['composition'] = $composition;
		}
		return $data;
	}
	

	/**
	 * Select all the establishment's menus
	 */
	public function select_all_menus_by_est(){
		$menus = $this->CI->menus->select_all_menus_by_est($this->est_id);
		//Format prices
		foreach($menus as $k => $menu){
			$menus[$k]['price'] = number_format($menu['price'], 2);
		}
		return $menus;
	}
	
	public function select_menu_datas_from_est(){
		$this->CI->load->model('link_est_menu_model', 'link_em');
		return $this->CI->link_em->select_menu_datas_from_est($this->est_id);
	}
	

	/**
	 * Add a menu
	 * 
	 * @param array $post
	 *        	Global POST variable from form
	 */
	public function add_menu($post){
		$this->CI->load->model('link_est_menu_model', 'link_em');
		
		//Insert new menu
		$fields = array( 
			'name' => $post['name'],
			'price' => str_replace(',', '.', $post['price']),
			'note' => $post['note']
		);
		$this->CI->menus->insert($fields);
		$menu_id = intval($this->CI->db->insert_id());
		
		//Define the rank
		$fields = array( 
			'est_id' => $this->est_id
		);
		$rank = ($this->CI->link_em->select_max_rank_for_est_menu($fields)+1);
		
		//Insert new relation menu/est
		$fields = array( 
			'est_id' => $this->est_id,
			'menu_id' => $menu_id,
			'menu_rank' => $rank
		);
		
		$this->CI->link_em->insert($fields);
		return $menu_id;
	}

	/**
	 * Delete a menu
	 * 
	 * @param int $id
	 *        	Menu's id
	 */
	public function delete_menu($id){
		$this->CI->load->model('menus_model', 'menu');
		$this->CI->load->model('link_est_menu_model', 'link_em');
		$this->CI->link_em->delete(array( 
			'menu_id' => $id
		));
		$this->CI->menu->delete(array( 
			'id' => $id
		));
	}

	/**
	 * Delete all the menus
	 */
	public function delete_all_menus(){
		$this->CI->load->model('compositions_model', 'compos');
		$menus_ids = $this->CI->menus->module_menu_list_menus_ids_by_est($this->est_id);
		$compos_ids = $this->CI->compos->module_menu_list_composition_ids_by_est($this->est_id);
	
		foreach($compos_ids as $k => $compo){
			$this->delete_composition($compo->id);
		}
		foreach($menus_ids as $k => $menu){
			$this->delete_menu($menu->id);
		}
	}
	

	
	/**
	 * Update the menu's datas
	 * 
	 * @param int $menu_id
	 *        	menu id
	 * @param array $datas
	 *        	The global POST var
	 */
	public function update_menu($menu_id, $datas){
		$this->CI->menus->update(array( 
			'id' => $menu_id
		), array( 
			'name' => $datas['name'],
			'price' => str_replace(',', '.', $datas['price']),
			'note' => $datas['note']
		));
	}

	
	/**
	 * Modify the display rank of a menu
	 * 
	 * @param int $menu_id
	 *        	The menu to move
	 * @param str $go
	 *        	The direction (up/down)
	 */
	public function modify_menu_rank($menu_id, $go){
		$this->CI->load->model('link_est_menu_model', 'link_em');
		
		$menu = $this->CI->link_em->select(array( 
			'menu_id' => $menu_id
		));
		
		if($go=='up')
			$rank = $menu->menu_rank-1;
		elseif($go=='down')
			$rank = $menu->menu_rank+1;
		
		$to_invert_category = $this->CI->link_em->select(array( 
			'est_id' => $this->est_id,
			'menu_rank' => $rank
		));
		$this->CI->link_em->update(array( 
			'menu_id' => intval($menu->menu_id)
		), array( 
			'menu_rank' => $rank
		));
		$this->CI->link_em->update(array( 
			'menu_id' => intval($to_invert_category->menu_id)
		), array( 
			'menu_rank' => intval($menu->menu_rank)
		));
	}

	
	/**
	 * Redonne un ordre logique à l'ordre d'affichage des produits dans les catégories
	 * La fonction fait des requetes et détecte des incohérence dans le stockage de l'ordre
	 * Si il y a incohérence, elle reconstrui un ordre propre selon l'ordre enregistré par l'user
	 */
	public function reorganize_ranks_menus(){
		$this->CI->load->model('link_est_menu_model', 'link_em');
		$fields = array( 
			'est_id' => $this->est_id
		);
		$ranking = $this->CI->link_em->select_menu_from_est($fields);
		

		$menus = array();
		foreach($ranking as $key => $est_menu){
			$menus[$est_menu->menu_id] = $est_menu->menu_rank;
		}
		
		$new_menus_ranking = array();
		$i = 1;
		foreach($menus as $menu_id => $rank){
			$new_menus_ranking[$menu_id] = $i;
			$i++;
		}
		
		$diff = (count(array_diff_assoc($menus, $new_menus_ranking))==0) ? false : true;
		
		if($diff==true){
			foreach($new_menus_ranking as $menu_id => $rank){
				$this->CI->link_em->update(array( 
					'menu_id' => $menu_id
				), array( 
					'menu_rank' => $rank
				));
			}
		}
	}

	public function add_composition($menu_id, $post){
		$cat_id = $post['cat_id'];
		$selection = ($cat_id==0) ? 1 : 0;
		$prices_cat_flag = 0;
		
		//Define the rank
		$this->CI->load->model('link_menu_compo_model', 'link_mc');
		$rank = ($this->CI->link_mc->select_max_rank_for_composition(array( 
			'menu_id' => $menu_id
		))+1);
		
		//Define if prices_categories or not for this cat
		if($cat_id!=0){
			$this->CI->load->model('prices_categories_model', 'prices_cat');
			$prices_categories = $this->CI->prices_cat->select_prices_cat_by_cat($cat_id);
			$prices_cat_flag = (count($prices_categories)>0) ? 1 : 0;
		}
		
		//Insert in compositions
		$this->CI->load->model('compositions_model', 'compo');
		$this->CI->compo->insert(array( 
			'name' => $post['composition_name'],
			'prices_categories' => $prices_cat_flag,
			'selection' => $selection
		));
		$compo_id = intval($this->CI->db->insert_id());
		
		//Insert in link_menu_compo
		$this->CI->link_mc->insert(array( 
			'menu_id' => $menu_id,
			'compo_id' => $compo_id,
			'compo_rank' => $rank
		));
		
		//Insert in link_compo_cat if category restrictions
		if($cat_id!=0){
			$this->CI->load->model('link_compo_cat_model', 'link_cc');
			$this->CI->link_cc->insert(array( 
				'compo_id' => $compo_id,
				'cat_id' => $cat_id
			));
		}
		
		//Insert link_compo_prices if prices_categories
		if($prices_cat_flag==1){
			$this->CI->load->model('link_compo_prices_model', 'link_cp');
			$this->CI->link_cp->insert(array( 
				'compo_id' => $compo_id,
				'prices_id' => $prices_categories[0]->id
			));
		}
		return $compo_id;
	}

	public function edit_composition($compo_id){
		$this->CI->load->model('compositions_model', 'compo');
		$this->CI->load->model('selections_model', 'selection');
		$this->CI->load->model('link_compo_cat_model', 'link_cc');
		$this->CI->load->model('prices_categories_model', 'prices_cat');
		
		$compo = $this->CI->compo->select_composition($compo_id);
		$prices_categories = array();
		$link_cc = $this->CI->link_cc->select_category($compo->compo_id);
		
		$compo->cat_id = (count($link_cc)==1) ? $link_cc->cat_id : '';
		

		if($compo->prices_categories==1){
			$prices_categories = $this->CI->prices_cat->select_prices_cat_by_cat($link_cc->cat_id);
			$this->CI->load->model('link_compo_prices_model', 'link_cp');
			$prices_cat_id = $this->CI->link_cp->select(array( 
				'compo_id' => $compo_id
			));
			
			foreach($prices_categories as $k => $price_cat){
				if($prices_cat_id->prices_id==$price_cat->id){
					$prices_categories[$k]->selected = 'selected';
				} else{
					$prices_categories[$k]->selected = '';
				}
			}
		}
		
		$selection = $this->CI->selection->select_many(array( 
			'compo_id' => $compo_id
		));
		
		if(count($link_cc)==1){
			$products = $this->CI->selection->select_datas_product_by_cat($link_cc->cat_id);
		} else{
			$products = $this->CI->selection->select_datas_product_by_est($this->est_id);
		}
		

		//Defined the selection
		if(count($selection)==0){
			foreach($products as $k => $prod){
				$products[$k]->checked = 'checked';
			}
		} else{
			foreach($products as $key => $prod){
				$prod->checked = '';
				$prod->txt_prices_cat = '';
			}
			foreach($selection as $k => $sel){
				foreach($products as $key => $prod){
					if($prod->id==$sel->prod_id){
						$prod->checked = 'checked';
						$prod->txt_prices_cat = $sel->txt_prices_cat;
					}
				}
			}
		}
		
		//Format the product array if no category selected
		if(count($link_cc)==0){
			$all_products = array();
			foreach($products as $k => $prod){
				$all_products[$prod->cat_rank]['cat_name'] = $prod->cat_name;
				$all_products[$prod->cat_rank]['cat_id'] = $prod->cat_id;
				$all_products[$prod->cat_rank]['prices_categories'] = $this->CI->prices_cat->select_prices_cat_by_cat($prod->cat_id);
				$all_products[$prod->cat_rank][$prod->prod_rank] = new stdClass();
				$all_products[$prod->cat_rank][$prod->prod_rank]->id = $prod->id;
				$all_products[$prod->cat_rank][$prod->prod_rank]->name = $prod->prod_name;
				
				if(count($selection)==0){
					$all_products[$prod->cat_rank][$prod->prod_rank]->checked = '';
				} else{
					$all_products[$prod->cat_rank][$prod->prod_rank]->checked = $prod->checked;
					if($prod->checked=='checked'){
						$all_products[$prod->cat_rank]['selection'] = true;
					}
					$all_products[$prod->cat_rank][$prod->prod_rank]->txt_prices_cat = $prod->txt_prices_cat;
				}
			}
			ksort($all_products);
			$data['products'] = $all_products;
			$data['linked_cat'] = '0';
		} else{
			$data['products'] = $products;
			$data['linked_cat'] = '1';
		}
		
		$datas = array();
		$datas = $data;
		$datas['composition'] = $compo;
		$datas['prices_categories'] = $prices_categories;
		
		return $datas;
	}

	public function update_composition($compo_id, $post){
		$this->CI->load->model('compositions_model', 'compo');
		$this->CI->load->model('selections_model', 'selection');
		$this->CI->load->model('link_compo_prices_model', 'link_cp');
		$this->CI->load->model('link_cat_prod_model', 'link_cat_prod');
		$this->CI->load->model('link_menu_compo_model', 'link_mc');
		$this->CI->load->model('link_compo_cat_model', 'link_cc');
		$this->CI->load->model('prices_categories_model', 'prices_cat');
		

		$menu = $this->CI->link_mc->select(array( 
			'compo_id' => $compo_id
		));
		
		$name = $post['composition_name'];
		$note = $post['composition_note'];
		$prices_cat = (isset($post['prices_cat'])) ? $post['prices_cat'] : '';
		$prod_selection = $post['prod_ids'];
		
		$compo = $this->CI->compo->select(array( 
			'id' => $compo_id
		));
		$prices_cat_for_product = (isset($post['prices_cat_for_product'])) ? $post['prices_cat_for_product'] : '';
		

		$link_cc = $this->CI->link_cc->select_category($compo_id);
		if(count($link_cc)==1){
			$count_products = $this->CI->link_cat_prod->count(array( 
				'cat_id' => $link_cc->cat_id
			));
		}
		
		$count_prod_selection = count($prod_selection);
		
		//Update Selection
		if(count($link_cc)==1){
			$selection = ($count_products==$count_prod_selection) ? 0 : 1;
		} else{
			$selection = 1;
		}
		$this->CI->selection->delete(array( 
			'compo_id' => $compo_id
		));
		
		if($selection==1){
			foreach($prod_selection as $id => $v){
				if(isset($prices_cat_for_product[$id])){
					$fetch_price_cat = $this->CI->prices_cat->select(array( 
						'id' => $prices_cat_for_product[$id]
					));
					$txt_price_cat = $fetch_price_cat->name;
				} else{
					$txt_price_cat = '';
				}
				$this->CI->selection->insert(array( 
					'compo_id' => $compo_id,
					'prod_id' => $id,
					'txt_prices_cat' => $txt_price_cat
				));
			}
		}
		
		//Update composition
		$this->CI->compo->update(array( 
			'id' => $compo_id
		), array( 
			'name' => $name,
			'note' => $note,
			'selection' => $selection
		));
		
		//Update link_compo_prices
		if($prices_cat){
			$this->CI->link_cp->update(array( 
				'compo_id' => $compo_id
			), array( 
				'prices_id' => $prices_cat
			));
		}
		return $menu->menu_id;
	}

	
	/**
	 * Delete a composition section in a menu
	 * 
	 * @param int $compo_id
	 *        	The compo id
	 * @return int the menu id of the deleted composition
	 */
	public function delete_composition($compo_id){
		$this->CI->load->model('compositions_model', 'compo');
		$this->CI->load->model('link_menu_compo_model', 'link_mc');
		$this->CI->load->model('selections_model', 'selection');
		$this->CI->load->model('link_compo_prices_model', 'link_cp');
		$this->CI->load->model('link_compo_cat_model', 'link_cc');
		
		$compo = $this->CI->compo->select(array( 
			'id' => $compo_id
		));
		$link_mc = $this->CI->link_mc->select(array( 
			'compo_id' => $compo_id
		));
		$menu_id = $link_mc->menu_id;
		
		$this->CI->link_mc->delete(array( 
			'compo_id' => $compo_id
		));
		$this->CI->selection->delete(array( 
			'compo_id' => $compo_id
		));
		$this->CI->link_cp->delete(array( 
			'compo_id' => $compo_id
		));
		$this->CI->link_cc->delete(array( 
			'compo_id' => $compo_id
		));
		$this->CI->compo->delete(array( 
			'id' => $compo_id
		));
		return $menu_id;
	}
	
	
	public function modify_composition_rank($compo_id, $go){
		$this->CI->load->model('link_menu_compo_model', 'link_mc');
	
		$compo = $this->CI->link_mc->select(array(
			'compo_id' => $compo_id
		));
	
		if($go=='up')
			$rank = $compo->compo_rank-1;
			elseif($go=='down')
			$rank = $compo->compo_rank+1;
	
			$to_invert_composition = $this->CI->link_mc->select(array(
				'menu_id' => $compo->menu_id,
				'compo_rank' => $rank
			));
			$this->CI->link_mc->update(array(
				'compo_id' => $compo_id
			), array(
				'compo_rank' => $rank
			));
	
			$this->CI->link_mc->update(array(
				'compo_id' => intval($to_invert_composition->compo_id)
			), array(
				'compo_rank' => intval($compo->compo_rank)
			));
			return $compo->menu_id;
	}

	
	/**
	 * Count the number of menus in an establishment
	 * 
	 * @return int $result The number of menus in an establishment
	 */
	public function count_menus_in_establishment(){
		$this->CI->load->model('link_est_menu_model', 'link_em');
		return intval($this->CI->link_em->count(array(
			'est_id' => $this->est_id
		)));
	}
	
	
	/**
	 * Count if compositions exists in a menu
	 * 
	 * @param int $menu_id
	 *        	The menu id to check
	 * @return int $result The number of composition in the menu
	 */
	public function compo_existing($menu_id){
		$this->CI->load->model('link_menu_compo_model', 'link_mc');
		return intval($this->CI->link_mc->count(array( 
			'menu_id' => $menu_id
		)));
	}
	
	/**
	 * Return if a category exists in one of the composition of establishment's menus.
	 * @param int $cat_id The cat ID
	 * @return int The number of presents entities
	 */
	public function count_category_in_compositions($cat_id){
		$this->CI->load->model('link_compo_cat_model', 'link_cc');
		return intval($this->CI->link_cc->count(array(
			'cat_id' => $cat_id
		)));
	}
	

	/**
	 * Redonne un ordre logique à l'ordre d'affichage des produits dans les catégories
	 * La fonction fait des requetes et détecte des incohérence dans le stockage de l'ordre
	 * Si il y a incohérence, elle reconstrui un ordre propre selon l'ordre enregistré par l'user
	 */
	public function reorganize_ranks_composition($menu_id){
		$this->CI->load->model('link_menu_compo_model', 'link_mc');
		$ranking = $this->CI->link_mc->select_compos_from_menu(array( 
			'menu_id' => $menu_id
		));
		

		$compos = array();
		foreach($ranking as $key => $compo){
			$compos[$compo->compo_id] = $compo->compo_rank;
		}
		
		$new_compos_ranking = array();
		$i = 1;
		foreach($compos as $compo_id => $rank){
			$new_compos_ranking[$compo_id] = $i;
			$i++;
		}
		
		$diff = (count(array_diff_assoc($compos, $new_compos_ranking))==0) ? false : true;
		
		if($diff==true){
			foreach($new_compos_ranking as $compo_id => $rank){
				$this->CI->link_mc->update(array( 
					'menu_id' => $menu_id,
					'compo_id' => $compo_id
				), array( 
					'compo_rank' => $rank
				));
			}
		}
	}

}