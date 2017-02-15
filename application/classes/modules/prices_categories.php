<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Module_prices_categories{
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
		$this->CI->load->model('prices_categories_model', 'prices_cat');
	}

	
	/**
	 * Select all the prices cat for a category
	 *
	 * @param int $cat_id
	 *        	Th ecat id
	 */
	public function select_prices_for_a_cat($cat_id){
		return $this->CI->prices_cat->select_prices_for_a_cat(array( 
			'cat_id' => $cat_id
		));
	}

	
	/**
	 * Load the different prices for a product
	 *
	 * @param int $prod_id
	 *        	The prod ID
	 */
	public function load_prices_for_a_product($prod_id){
		$this->CI->load->model('link_prod_prices_model', 'link_pp');
		return $this->CI->link_pp->select_prices_for_a_product($prod_id);
	}

	public function add_prices_category($cat_id, $post){
		$this->CI->load->model('link_cat_prod_model', 'link_cp');
		$this->CI->load->model('link_compo_cat_model', 'link_cc');
		
		//Define the rank
		$rank = ($this->CI->prices_cat->select_max_rank_for_a_cat(array( 
			'cat_id' => $cat_id
		))+1);
		
		//Insert new prices category
		$fields = array( 
			'cat_id' => $cat_id,
			'name' => $post['prices_category_name'],
			'rank' => $rank
		);
		$this->CI->prices_cat->insert($fields);
		$new_prices_cat_id = intval($this->CI->db->insert_id());
		

		/*
		 * Si des produits existent deja dans cette catégorie,
		 * db:prices_categories = 1, db:price = 0,
		 * et on créé une nouvelle entrée dans link_prod_prices pour chaque produit
		 * avec le db:link_pp:price = db:products:price :-s
		 */
		if($this->CI->link_cp->count(array( 
			'cat_id' => $cat_id
		))>0){
			$this->CI->load->model('products_model', 'products');
			$this->CI->load->model('link_prod_prices_model', 'link_pp');
			$prod_ids = $this->CI->link_cp->select_many(array( 
				'cat_id' => $cat_id
			));
			
			foreach($prod_ids as $k => $prod){
				$product = $this->CI->products->select(array( 
					'id' => $prod->prod_id
				));
				
				//Si on ajoute une catégorie de prix sur un produit qui en a deja, et qui a donc un prix = 0
				//Alors on chope le premier prix qui nous viens dans link_pp
				if($product->price==0){
					$link_pp = $this->CI->link_pp->select(array( 
						'prod_id' => $product->id
					));
					if(count($link_pp)==1){
						$price = $link_pp->price;
					} else{
						$price = 0;
					}
				} else{
					$price = $product->price;
				}
				
				$this->CI->link_pp->insert(array( 
					'prod_id' => $prod->prod_id,
					'prices_id' => $new_prices_cat_id,
					'price' => $price
				));
				$this->CI->products->update(array( 
					'id' => $prod->prod_id
				), array( 
					'prices_categories' => 1,
					'price' => 0
				));
			}
		}
		
		//Si on ajoute une PREMIERE prices_cat à une catégorie qui est présente dans les compositions
		//Alors db:compositions:prices_categories = 1
		//On insert une entrée dans db:link_compo_prices afin d'avoir la référence
		if($this->CI->link_cc->count(array( 
			'cat_id' => $cat_id
		))>0){
			$this->CI->load->model('compositions_model', 'compo');
			$this->CI->load->model('link_compo_prices_model', 'link_compo_prices');
			$compo_ids = $this->CI->link_cc->select_many(array( 
				'cat_id' => $cat_id
			));
			
			foreach($compo_ids as $k => $compos){
				if($this->CI->link_compo_prices->count(array( 
					'compo_id' => $compos->compo_id
				))==0){
					$this->CI->link_compo_prices->insert(array( 
						'compo_id' => $compos->compo_id,
						'prices_id' => $new_prices_cat_id
					));
					$this->CI->compo->update(array( 
						'id' => $compos->compo_id
					), array( 
						'prices_categories' => 1
					));
				}
			}
		}
	}

	
	/**
	 * Insert the prices categories for a new product
	 *
	 * @param int $prod_id
	 *        	The id pf the new product
	 * @param array $post
	 *        	The specific prices category POST datas
	 */
	public function insert_product_prices($prod_id, $post){
		$this->CI->load->model('link_prod_prices_model', 'link_pp');
		foreach($post as $prices_cat_id => $price){
			$f_price = str_replace(',', '.', $price);
			$this->CI->link_pp->insert(array( 
				'prod_id' => $prod_id,
				'prices_id' => $prices_cat_id,
				'price' => $f_price
			));
		}
	}

	public function update_name($post){
		$this->CI->prices_cat->update(array( 
			'id' => $post['prices_cat_id']
		), array( 
			'name' => $post['name']
		));
	}

	
	/**
	 * Update the prices cat for a product
	 *
	 * @param int $prod_id
	 *        	The prod ID
	 * @param array $post
	 *        	The POST prices category of a category
	 */
	public function update_product_prices($prod_id, $post){
		$this->CI->load->model('link_prod_prices_model', 'link_pp');
		foreach($post as $prices_cat_id => $price){
			$f_price = str_replace(',', '.', $price);
			$this->CI->link_pp->update(array( 
				'prod_id' => $prod_id,
				'prices_id' => $prices_cat_id
			), array( 
				'price' => $f_price
			));
		}
	}

	public function delete_prices_category($prices_category_id){
		$this->CI->load->model('link_prod_prices_model', 'link_pp');
		$this->CI->load->model('link_compo_prices_model', 'link_cp');
		
		$prices_cat = $this->CI->prices_cat->select(array( 
			'id' => $prices_category_id
		));
		$cat_id = $prices_cat->cat_id;
		$cnt_prices_cat = $this->CI->prices_cat->count(array( 
			'cat_id' => $cat_id
		));
		
		//Manage the composition's restrictions and choices in the 'prices_cat' field
		$compo_prices = $this->CI->link_cp->select_many(array( 
			'prices_id' => $prices_category_id
		));
		if(count($compo_prices)>=1){
			$other_prices_cat = $this->CI->prices_cat->select_prices_cat_not_deleted($prices_category_id, $cat_id);
			if($cnt_prices_cat>1){
				foreach($compo_prices as $k => $compo_price){
					$this->CI->link_cp->update(array( 
						'compo_id' => $compo_price->compo_id
					), array( 
						'prices_id' => $other_prices_cat[0]->id
					));
				}
			} else{
				$this->CI->load->model('compositions_model', 'compo');
				foreach($compo_prices as $k => $compo_price){
					$this->CI->link_cp->delete(array( 
						'compo_id' => $compo_price->compo_id
					));
					$this->CI->compo->update(array( 
						'id' => $compo_price->compo_id
					), array( 
						'prices_categories' => 0
					));
				}
			}
		}
		
		//Manage the products prices if there is no more prices_cat
		if($cnt_prices_cat==1){
			//Il ne reste qu'une seule catégorie de prix
			//Du coup, on reporte les prix de db:prod_prices sur db:products
			//Avant de supprimer tout :)
			$this->CI->load->model('products_model', 'product');
			$prod_prices = $this->CI->link_pp->select_many(array( 
				'prices_id' => $prices_category_id
			));
			
			foreach($prod_prices as $k => $prod){
				$this->CI->product->update(array( 
					'id' => $prod->prod_id
				), array( 
					'prices_categories' => 0,
					'price' => $prod->price
				));
			}
		}
		
		$this->CI->link_pp->delete(array( 
			'prices_id' => $prices_category_id
		));
		$this->CI->prices_cat->delete(array( 
			'id' => $prices_category_id
		));
		
		return $cat_id;
	}

	public function delete_all_prices_categories(){
		$ids = $this->CI->prices_cat->module_prices_cat_list_ids($this->est_id);
		foreach($ids as $k => $id){
			$this->delete_prices_category($id->id);
		}
	}

	public function modify_prices_category_rank($prices_cat_id, $cat_id, $go){
		$prices_cat = $this->CI->prices_cat->select(array( 
			'id' => $prices_cat_id
		));
		
		if($go=='up')
			$rank = $prices_cat->rank-1;
		elseif($go=='down')
			$rank = $prices_cat->rank+1;
		
		$to_invert_category = $this->CI->prices_cat->select(array( 
			'cat_id' => $cat_id,
			'rank' => $rank
		));
		$this->CI->prices_cat->update(array( 
			'id' => $prices_cat_id
		), array( 
			'rank' => $rank
		));
		$this->CI->prices_cat->update(array( 
			'id' => $to_invert_category->id
		), array( 
			'rank' => intval($prices_cat->rank)
		));
	}

	
	/**
	 * Redonne un ordre logique à l'ordre d'affichage des produits dans les catégories
	 * La fonction fait des requetes et détecte des incohérence dans le stockage de l'ordre
	 * Si il y a incohérence, elle reconstrui un ordre propre selon l'ordre enregistré par l'user
	 *
	 * @param int $cat_id
	 *        	The cat ID
	 */
	public function reorganize_ranks_prices_categories($cat_id){
		$ranking = $this->CI->prices_cat->select_prices_for_a_cat(array( 
			'cat_id' => $cat_id
		));
		

		$prices_cats = array();
		foreach($ranking as $key => $cats){
			$prices_cats[$cats->id] = $cats->rank;
		}
		
		$new_cats_ranking = array();
		$i = 1;
		foreach($prices_cats as $price_id => $rank){
			$new_cats_ranking[$price_id] = $i;
			$i++;
		}
		
		$diff = (count(array_diff_assoc($prices_cats, $new_cats_ranking))==0) ? false : true;
		
		if($diff==true){
			foreach($new_cats_ranking as $price_id => $rank){
				$this->CI->prices_cat->update(array( 
					'id' => $price_id
				), array( 
					'rank' => $rank
				));
			}
		}
	}

}

?>