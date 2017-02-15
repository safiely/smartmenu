<?php

defined('BASEPATH') or exit('No direct script access allowed');
class User extends MY_Controller{
	public $request;
	public $debug;
	public $est;
	public $est_id;
	public $customisation;
	public $categories;
	public $prod;
	public $modules;
	public $menus;

	public function __construct(){
		parent::__construct();
		
		
		if(!isset($_REQUEST['est_id'])||$_REQUEST['est_id']<=0){
			redirect('/home');
		}
		
		$this->lang->load('fr', $this->config->item('language'));
		$this->load->library(array(
			'layout_user'
		));
		$this->layout_user->set_theme('user');
		$this->theme_path = 'assets/theme_user';
		
		$this->est_id = intval($_REQUEST['est_id']);
		$this->debug = '';
		
		
		
		$common_css_files = array(
			base_url($this->theme_path.'/css/font-awesome.min.css'),
			base_url($this->theme_path.'/vendor/jquerymobile/jquery.mobile.min.css'),
			base_url($this->theme_path.'/vendor/waves/waves.min.css'),
			base_url($this->theme_path.'/vendor/wow/animate.css'),
			base_url($this->theme_path.'/css/nativedroid2.css'),
			base_url($this->theme_path.'/css/style.css')
		);
		$this->layout_user->add_css_files($common_css_files);
		
		
		$common_js_files = array(
			base_url($this->theme_path.'/vendor/jquery/jquery-2.1.4.min.js'),
			base_url($this->theme_path.'/vendor/jquery-ui/jquery-ui-1.11.4.min.js'),
			base_url($this->theme_path.'/vendor/jquerymobile/jquery.mobile-1.4.5.min.js'),
			base_url($this->theme_path.'/vendor/waves/waves.min.js'),
			base_url($this->theme_path.'/vendor/wow/wow.min.js'),
			base_url($this->theme_path.'/js/nativedroid2.js'),
			base_url($this->theme_path.'/nd2settings.js'),
			base_url($this->theme_path.'/js/function.js'),
			base_url($this->theme_path.'/js/home.js'),
			base_url($this->theme_path.'/js/category.js'),
			base_url($this->theme_path.'/js/product.js'),
			base_url($this->theme_path.'/js/menu.js'),
			//base_url($this->theme_path.'/js/order.js'),
			base_url($this->theme_path.'/js/function.js')
		);
		$this->layout_user->add_js_files($common_js_files);
		
		
		$this->load_class('establishment');
		$est = new Establishment($this->est_id);           
		$this->est = $est->load_establishment();
		$this->layout_user->set_establishment($this->est);
		
		//Maintenance
		if($this->est->maintenance && !$this->session->userdata('sub_id')){
			redirect('/home/maintenance');
		}
		
		
		
		$this->load_class('customisation');
		$custom = new Customisation($this->est_id);		
		$this->customisation = $custom->load_customisation();
		$this->layout_user->set_customisation($this->customisation);

		
		
		//Set modules
		$this->load_class('modules');
		$modules = new Modules($this->est_id);
		$this->modules = $modules->load_modules();
		$this->layout_user->set_modules($this->modules);
		
		
		
		
		//Fetch cats
		$this->load_class('categories');
		$categories = new Categories($this->est_id);
		$this->categories = $categories->categories_list();
		$this->layout_user->set_categories($this->categories);
		
		
		//Fetch menus
		if($this->modules->menus){
			$this->load_module('menu');
			$mod_menu = new Module_menu($this->est_id);
			$this->menus = $mod_menu->select_menu_datas_from_est();
			$this->layout_user->set_menus($this->menus);
		}
		
		

		
		//A REFAIRE
		$order = $this->session->userdata('order');
		if(!isset($order[$this->est_id])){
			$order = array(
				$this->est_id => array(
					'menus' => array(),
					'categories' => array()
				)
			);
			$this->session->set_userdata('order', $order);
			$this->layout_user->is_ordering(false);
		} else{
			$order = $this->session->userdata('order');
			if(isset($order[$this->est_id])&&count($order[$this->est_id]['menus'])==0&&count($order[$this->est_id]['categories'])==0){
				$this->layout_user->is_ordering(false);
			} else{
				$this->layout_user->is_ordering(true);
			}
		}
		
		
	}

	public function index($data = array()){
		
		$data['est'] = $this->est;
		$data['categories'] = $this->categories;
		$data['customisation'] = $this->customisation;
		$data['modules'] = $this->modules;
		
		if($this->modules->social==1){
			require_once 'application/classes/modules/social.php';
			$mod_social = new Module_social($this->est_id);
			$mod_social->load();
			$data['mod_social'] = $mod_social;
		}
		
		//Set main menu collapsing
		$this->layout_user->collapse_main_menus('true', 'false');
		
		/*
		$this->layout_user->debug($this->modules);
		$this->layout_user->debug($data);
		*/
		
		
		$this->layout_user->set_header($this->est->name);
		$this->layout_user->set_nav_icon('local-library');
		$this->layout_user->set_panel_id('leftpanel_home');
		$this->layout_user->set_nav_icon_href('#leftpanel_home');
		$this->layout_user->view('user/home', $data);
	}

	public function category($id){
		
		
		$this->load->model('categories_model', 'category');
		$data['category'] = $this->category->select(array( 
			'id' => $id
		));
		
		$this->load->model('Link_cat_prod_model', 'link_cp');
		$data['products'] = $this->link_cp->select_datas_product_from_cat_UI($id);
		
		$data['one_image'] = false;
		
		foreach($data['products'] as $k => $prod){
			$data['products'][$k]->price = number_format($prod->price, 2);
			
			//Images
			if(!empty($prod->image)){
				$data['products'][$k]->image = '/uploads/products/thumbnails/thumb_'.$prod->image;
				$data['products'][$k]->image_file = true;
			} elseif($data['category']->image!='0'){
				$data['products'][$k]->image = '/assets/common/img/categories/default/'.$data['category']->image;
				$data['products'][$k]->image_file = false;
			} else{
				$data['products'][$k]->image = '';
				$data['products'][$k]->image_file = false;
			}
			if($data['one_image']==false&&!empty($data['products'][$k]->image)){
				$data['one_image'] = true;
			}
		}
		
		$data['est_id'] = $this->est_id;
		
		if(count($data['products'])==0){
			$data['toast'] = '<div class="hidden" id="no_product_in_category"></div>';
		} elseif(count($data['products'])==1){
			redirect('user/product/'.$data['products'][0]->id.'/solo?est_id='.$this->est_id);
		}
		
		$this->layout_user->set_nav_icon('local-library');
		$this->layout_user->set_panel_id('leftpanel_cat_'.$id);
		$this->layout_user->set_nav_icon_href('#leftpanel_cat_'.$id);
		$this->layout_user->set_header($data['category']->name);
		$this->layout_user->collapse_main_menus('true', 'false');
		$this->layout_user->view('user/category', $data);
	}

	public function product($id, $nav = ''){
		$this->load->model('products_model', 'product');
		$data['product'] = $this->product->select_a_product($id);
		$data['product']->price = number_format($data['product']->price, 2);
		
		$this->load->model('categories_model', 'category');
		$data['category'] = $this->category->select(array( 
			'id' => $data['product']->cat_id
		));
		
		if($data['product']->prices_categories==1){
			$this->load->model('link_prod_prices_model', 'link_pp');
			$data['product']->price = $this->link_pp->select_prices_for_a_product($data['product']->id);
		}
		
		//Check if product is "orderable"
		if($data['product']->prices_categories==1&&is_array($data['product']->price)){
			foreach($data['product']->price as $k => $prices_cat){
				if($prices_cat->price>0){
					$orderable = true;
					break;
				} else{
					$orderable = false;
				}
			}
		} else{
			$orderable = true;
		}
		$data['orderable'] = $orderable;
		
		if(empty($nav)){
			//Cas normal
			$this->layout_user->set_nav_icon('arrow-back');
			$this->layout_user->set_panel_id('#');
			$this->layout_user->set_nav_icon_href('/user/category/'.$data['product']->cat_id.'?est_id='.$this->est_id);
			$this->layout_user->collapse_main_menus('true', 'false');
		} elseif($nav=='solo'){
			// cas d'un seul produit dans une catégorie
			$this->layout_user->set_nav_icon('local-library');
			$this->layout_user->set_panel_id('leftpanel_product_'.$id);
			$this->layout_user->set_nav_icon_href('#leftpanel_product_'.$id);
			$this->layout_user->collapse_main_menus('true', 'false');
		} elseif(strpos($nav, 'menu')!==false){
			//Cas qu'on vient des menus
			$this->layout_user->set_nav_icon('arrow-back');
			$tab = explode('_', $nav);
			$this->layout_user->set_panel_id('#');
			$this->layout_user->set_nav_icon_href('/user/menus/'.$tab[1].'?est_id='.$this->est_id);
			$data['orderable'] = false;
		} elseif(strpos($nav, 'order')!==false){
			//Cas qu'on vient de la commande
			$this->layout_user->set_nav_icon('arrow-back');
			$this->layout_user->set_panel_id('#');
			$this->layout_user->set_nav_icon_href('/user/order?est_id='.$this->est_id);
			$data['orderable'] = false;
		}
		
		$this->layout_user->set_header($data['product']->name);
		$data['est_id'] = $this->est_id;
		$this->layout_user->view('user/product', $data);
	}

	public function menus($id){
		$this->load->model('menus_model', 'menu');
		$this->load->model('compositions_model', 'compo');
		$this->load->model('link_cat_prod_model', 'link_cp');
		$this->load->model('link_compo_prices_model', 'link_compo_prices');
		$this->load->model('selections_model', 'selection');
		$this->load->model('link_compo_cat_model', 'link_cc');
		
		$data['menu'] = $this->menu->select_row_array(array( 
			'id' => $id
		));
		$db_composition = $this->compo->select_menu_composition($id);
		$composition = array();
		
		foreach($db_composition as $k => $compo){
			$composition[$compo->rank]['id'] = $compo->compo_id;
			$composition[$compo->rank]['name'] = $compo->compo_name;
			$composition[$compo->rank]['prices_categories'] = $compo->prices_categories;
			$composition[$compo->rank]['selection'] = $compo->compo_selection;
			$composition[$compo->rank]['note'] = $compo->compo_note;
			
			if($compo->prices_categories==1){
				$prices_cat_name = $this->link_compo_prices->select_prices_cat_name_from_compo_id($compo->compo_id);
				$composition[$compo->rank]['prices_categories_name'] = $prices_cat_name->name;
			} else{
				$composition[$compo->rank]['prices_categories_name'] = '';
			}
			
			if($compo->compo_selection==1){
				$composition[$compo->rank]['products'] = $this->selection->select_datas_product_for_menus($compo->compo_id);
				//If there is a product's selection, but the section is linked with a specific category,
				//remove the category name
				if($this->link_cc->count(array( 
					'compo_id' => $compo->compo_id
				))==1){
					foreach($composition[$compo->rank]['products'] as $k => $prod){
						unset($composition[$compo->rank]['products'][$k]->cat_name);
					}
				}
			} else{
				$link_cc = $this->link_cc->select_category($compo->compo_id);
				$composition[$compo->rank]['products'] = $this->link_cp->select_datas_product_for_menus($link_cc->cat_id);
			}
		}
		
		$data['composition'] = $composition;
		$data['est_id'] = $this->est_id;
		
		
		$this->layout_user->set_nav_icon('local-library');
		$this->layout_user->set_panel_id('leftpanel_menu_'.$id);
		$this->layout_user->set_nav_icon_href('#leftpanel_menu_'.$id);
		$this->layout_user->set_header($data['menu']['name']);
		$this->layout_user->collapse_main_menus('false', 'true');
		$this->layout_user->view('user/menu', $data);
	}

	public function order($data = array()){
		
		$this->layout_user->add_specific_js_files($specific_js_files);
		$order = $this->session->userdata('order');
		$data['menus'] = $order[$this->est_id]['menus'];
		$data['categories'] = $order[$this->est_id]['categories'];
		$data['amount'] = 0;
		

		//Sort categories
		$this->load->model('link_est_cat_model', 'link_ec');
		$link_ec = $this->link_ec->select_cat_from_est(array( 
			'est_id' => $this->est_id
		));
		foreach($link_ec as $k => $link){
			if(isset($data['categories'][$link->cat_id])){
				$data['categories'][$link->cat_id]['rank'] = $link->cat_rank;
			}
		}
		uasort($data['categories'], array( 
			$this,
			'cmp_obj'
		));
		

		foreach($data['menus'] as $k => $menu){
			$data['amount'] += $menu['price'];
		}
		
		foreach($data['categories'] as $cat_id => $cat){
			foreach($cat['products'] as $k => $prod){
				$data['amount'] += $prod->price;
			}
		}
		
		$data['amount'] = number_format($data['amount'], 2);
		$data['est_id'] = $this->est_id;
		$this->layout_user->set_nav_icon('local-library');
		$this->layout_user->set_nav_icon_href('#leftpanel');
		$this->layout_user->set_header('Votre commande');
		$this->layout_user->view('user/order', $data);
	}
	

	//Triage des catégories par rang dans la page order
	static function cmp_obj($a, $b){
		return ($a['rank']>$b['rank']) ? +1 : -1;
	}

	public function add_product_order(){
		$id = $this->input->post('prod_id');
		$note = $this->input->post('note');
		$price = $this->input->post('price');
		
		$order = $this->session->userdata('order');
		$this->load->model('products_model', 'product');
		$this->load->model('categories_model', 'category');
		$product = $this->product->select_a_product($id);
		$category = $this->category->select(array( 
			'id' => $product->cat_id
		));
		
		$cat_id = $product->cat_id;
		unset($product->image);
		unset($product->suggest);
		unset($product->not_in_card);
		unset($product->sold_out);
		
		//Force note and price if necessary
		$product->note = $note;
		$product->price = ($price!=0) ? number_format($price, 2) : number_format($product->price, 2);
		

		unset($product->rank);
		unset($product->prices_categories);
		unset($product->composition);
		unset($product->cat_id);
		$order[$this->est_id]['categories'][$cat_id]['name'] = $category->name;
		$order[$this->est_id]['categories'][$cat_id]['products'][] = $product;
		$this->session->set_userdata('order', $order);
	}

	public function add_menu_order(){
		$this->load->model('products_model', 'product');
		$this->load->model('menus_model', 'menu');
		
		
		
		$order = $this->session->userdata('order');
		$post = $this->input->post();
		

		if(isset($post['ids'])){
			$ids = $post['ids'];
			$notes = $post['note'];
			
			$menu_id = $post['menu_id'];
			unset($post['menu_id']);
			

			$menu = $this->menu->select_row_array(array( 
				'id' => $menu_id
			));
			$count_menus = count($order[$this->est_id]['menus']);
			$order[$this->est_id]['menus'][$count_menus] = array();
			$order[$this->est_id]['menus'][$count_menus]['menu_id'] = $menu['id'];
			$order[$this->est_id]['menus'][$count_menus]['name'] = $menu['name'];
			$order[$this->est_id]['menus'][$count_menus]['price'] = number_format($menu['price'], 2);
			$order[$this->est_id]['menus'][$count_menus]['products'] = array();
			

			foreach($ids as $k => $prod_id){
				$product = $this->product->select_a_product($prod_id);
				$cat_id = $product->cat_id;
				
				$product->note = '';
				if(!empty($post['txt_prices_cat'][$prod_id])){
					$product->note .= $post['txt_prices_cat'][$prod_id];
				}
				if(!empty($post['txt_prices_cat'][$prod_id])&&!empty($notes[$prod_id])){
					$product->note .= ', ';
				}
				if(!empty($notes[$prod_id])){
					$product->note .= $notes[$prod_id];
				}
				
				unset($product->rank);
				unset($product->composition);
				unset($product->cat_id);
				unset($product->price);
				$order[$this->est_id]['menus'][$count_menus]['products'][] = $product;
			}
			
			$this->session->set_userdata('order', $order);
			$data['toast'] = '<div class="hidden" id="menu_added_to_order"></div>';
			$this->order($data);
		} else{
			$this->order();
		}
	}

	public function remove_product_order($cat_id, $cat_prod_id){
		$order = $this->session->userdata('order');
		unset($order[$this->est_id]['categories'][$cat_id]['products'][$cat_prod_id]);
		
		if(count($order[$this->est_id]['categories'][$cat_id]['products'])==0){
			unset($order[$this->est_id]['categories'][$cat_id]);
		}
		
		$this->session->set_userdata('order', $order);
		
		if(count($order[$this->est_id]['menus'])>0||count($order[$this->est_id]['categories'])>0){
			$data['toast'] = '<div class="hidden" id="product_removed"></div>';
			$this->order($data);
		} else{
			$this->delete_order();
		}
	}

	public function remove_menu_order($rank_menu){
		$order = $this->session->userdata('order');
		unset($order[$this->est_id]['menus'][$rank_menu]);
		
		$this->session->set_userdata('order', $order);
		
		if(count($order[$this->est_id]['menus'])>0||count($order[$this->est_id]['categories'])>0){
			$data['toast'] = '<div class="hidden" id="product_removed"></div>';
			$this->order($data);
		} else{
			$this->delete_order();
		}
	}

	public function delete_order(){
		$this->session->unset_userdata('order');
		$order = array( 
			$this->est_id => array( 
				'menus' => array(),
				'categories' => array()
			)
		);
		$this->session->set_userdata('order', $order);
		$this->layout_user->is_ordering(false);
		$data['toast'] = '<div class="hidden" id="order_reseted"></div>';
		$this->index($data);
	}

}
