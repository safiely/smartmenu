<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Manager extends MY_Controller{
	private $sub_id;
	private $est_id;
	private $theme_path;
	private $title;
	private $count_categories;
	private $count_products;
	private $count_menus;
	//private $categories;
	public $mods;

	public function __construct(){
		parent::__construct();
		

		if(!$this->session->userdata('est_id')){
			redirect('home/logout');
		}
		
		$this->lang->load('fr', $this->config->item('language'));
		$this->load->library(array( 
			'layout',
			'form_validation'
		));
		$this->load->helper('language');
		
		$this->layout->set_theme('manager');
		$this->theme_path = 'assets/theme_manager';
		$this->title = 'Votre carte - ';
		
		$common_css_files = array( 
			base_url($this->theme_path.'/vendors/bower_components/animate.css/animate.min.css'),
			base_url($this->theme_path.'/vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css'),
			base_url($this->theme_path.'/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css'),
			base_url($this->theme_path.'/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.css'),
			base_url($this->theme_path.'/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.css'),
			base_url($this->theme_path.'/css/app.min.css'),
			base_url($this->theme_path.'/css/style.css')
		);
		$this->layout->add_css_files($common_css_files);
		
		$common_js_files = array( 
			base_url($this->theme_path.'/vendors/bower_components/jquery/dist/jquery.min.js'),
			base_url($this->theme_path.'/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js'),
			base_url($this->theme_path.'/vendors/bootstrap-growl/bootstrap-growl.min.js'),
			base_url($this->theme_path.'/vendors/bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js'),
			base_url($this->theme_path.'/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js'),
			base_url($this->theme_path.'/vendors/bower_components/nouislider/distribute/jquery.nouislider.all.min.js'),
			base_url($this->theme_path.'/vendors/bower_components/typeahead.js/dist/typeahead.bundle.min.js'),
			base_url($this->theme_path.'/vendors/chosen_v1.4.2/chosen.jquery.min.js'),
			base_url($this->theme_path.'/vendors/fileinput/fileinput.min.js'),
			base_url($this->theme_path.'/vendors/input-mask/input-mask.min.js'),
			base_url($this->theme_path.'/vendors/farbtastic/farbtastic.min.js'),
			base_url($this->theme_path.'/vendors/bower_components/jquery-placeholder/jquery.placeholder.min.js'),
			base_url($this->theme_path.'/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js'),
			base_url($this->theme_path.'/js/functions.js')
		);
		$this->layout->add_js_files($common_js_files);
		
		$this->form_validation->set_error_delimiters("<div class='has-error'><small class='help-block'>", "</small></div>");
		

		//On stock l'id subscriber et establishment
		$this->sub_id = $this->session->userdata('sub_id');
		$this->est_id = $this->session->userdata('est_id');
		
		//Set sub_id in layout
		$this->layout->set_sub_id($this->sub_id);
		

		//Vérifie qu'aucune info nécdéssaire ne manque
		$this->datas_missing();
		
		//Categories list
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		$this->layout->categories_list($cat->categories_list());
		

		//Set maintenance infos
		$this->load->model('establishments_model', 'est');
		$maintenance = $this->est->select(array( 
			'id' => $this->est_id
		));
		$maintenance_state = ($maintenance->maintenance==1) ? 1 : 0;
		$this->layout->set_maintenance($maintenance_state);
		
		//Set modules
		$this->load->model('modules_model', 'module');
		$this->mods = $this->module->select(array( 
			'est_id' => $this->est_id
		));
		$this->layout->set_modules_menu($this->mods);
	}

	
	/**
	 * Establishment's dashboard
	 *
	 * @param array $data        	
	 */
	public function index($data = array()){
		$this->load_class('categories');
		$this->load_class('products');
		$this->load_class('establishment');
		$this->load_class('customisation');
		
		$cat = new Categories($this->est_id);
		$prod = new Products($this->est_id);
		$est = new Establishment($this->est_id);
		$custom = new Customisation($this->est_id);
		
		$data['count_categories'] = $cat->count_categories();
		$data['count_products'] = $prod->count_all_products_by_est();
		$data['establishment'] = $est->load_establishment();
		$data['customisation'] = $custom->load_customisation();
		$data['maintenance'] = ($data['establishment']->maintenance==1) ? 1 : 0;
		
		$this->layout->set_title($this->title.'Accueil');
		$this->layout->set_header('Tableau de bord');
		$this->layout->set_active_menu('menu_dashboard');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/home.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->view('manager/home', $data);
	}

	/**
	 * Basic establishment's datas (name, tel,...)
	 *
	 * @param array $data        	
	 */
	public function establishment($data = array()){
		$this->load_class('establishment');
		$est = new Establishment($this->est_id);
		
		$data['est'] = $est->load_establishment();
		$data['url_helper'] = ($data['est']->id==$data['est']->url) ? true : false;
		$data['est']->qrcode = base_url().$data['est']->url;
		
		$this->layout->set_title($this->title.'Établissement');
		$this->layout->set_header('Établissement');
		$this->layout->set_active_menu('menu_establishment');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/establishment.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->view('manager/establishment', $data);
	}

	/**
	 * Record the establishment's basic datas.
	 */
	public function establishment_check_form(){
		$this->form_validation->set_message('forbidden_urls', 'L\'adresse que vous avez indiquée est un terme réservé au système. Veuillez en choisir une autre.');
		if($this->form_validation->run()==FALSE){
			$this->establishment();
		} else{
			$this->load_class('establishment');
			$est = new Establishment($this->est_id);
			$data = $est->update_establishment($this->input->post());
			$this->establishment($data);
		}
	}

	
	/**
	 * The 'style' customisation page of an establishment
	 *
	 * @param array $data        	
	 */
	public function customisation($data = array()){
		$this->load_class('customisation');
		$custom = new Customisation($this->est_id);
		$data['customisation'] = $custom->load_customisation();
		$background_images = $custom->fetch_customisation_background_image();
		$data['img_background_default'] = $background_images['img_background_default'];
		$data['img_background_default_path'] = $background_images['img_background_default_path'];
		
		$this->layout->set_title($this->title.'Personnalisation');
		$this->layout->set_header('Personnalisation');
		$this->layout->set_active_menu('menu_customisation');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/customisation.js'),
			base_url('/assets/theme_manager/vendors/bower_components/tinymce/js/tinymce/tinymce.min.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->view('manager/customisation', $data);
	}

	/**
	 * Update the customisation datas
	 */
	public function customisation_check_form(){
		$this->load_class('customisation');
		$custom = new Customisation($this->est_id);
		$data = array();
		$custom->update_customisation($this->input->post());
		$data['logo_errors'] = $custom->upload_customisation_logo($_FILES);
		$data['notifications'] = '<div class="hidden" id="presentation_modified"></div>';
		$this->customisation($data);
	}

	/**
	 * Route to the manager preview
	 *
	 * @param str $type
	 *        	Type of device
	 */
	public function preview($type){
		$this->load_class('establishment');
		$obj_est = new Establishment($this->est_id);
		$est = $obj_est->load_establishment();
		
		$types = array( 
			'mobile' => array( 
				'width' => 375,
				'height' => 627,
				'version' => 'version mobile'
			),
			'tablet' => array( 
				'width' => 768,
				'height' => 1024,
				'version' => 'version tablette'
			)
		);
		
		$data['url'] = base_url().$est->url;
		$data['name'] = $est->name;
		
		if($type!='user'){
			$data['sizes'] = $types[$type];
		}
		
		if($type=='user'){
			redirect($data['url']);
		} else{
			$this->load->view('manager/preview', $data);
		}
	}

	/**
	 * The catagories managment page
	 *
	 * @param array $data        	
	 */
	public function categories($data = array()){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		$cat->reorganize_ranks_categories();
		$categories = $cat->categories_manager();
		$data = array_merge($data, $categories);
		
		//If no categories, force add the first category
		if(count($data['categories'])==0){
			redirect('manager/add_category');
		} else{
			$this->layout->set_title($this->title.'Catégories de produits');
			$this->layout->set_header('Catégories de produits');
			$this->layout->set_active_menu('menu_edit_categories', 'menu_categories');
			$specific_js_files = array( 
				base_url($this->theme_path.'/js/categories.js')
			);
			$this->layout->add_js_files($specific_js_files);
			$this->layout->view('manager/categories', $data);
		}
	}

	
	/**
	 * Add category page
	 *
	 * @param array $data        	
	 */
	public function add_category($data = array()){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		$data = array_merge($data, $cat->fetch_categories_images());
		
		$this->layout->set_title($this->title.'Ajouter une catégorie de produits');
		$this->layout->set_header('Ajouter une catégorie de produits');
		$this->layout->set_active_menu('menu_add_categories', 'menu_categories');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/categories.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->view('manager/add_category', $data);
	}

	public function add_category_check_form(){
		if($this->form_validation->run()==FALSE){
			$this->add_category();
		} else{
			$this->load_class('categories');
			$cat = new Categories($this->est_id);
			$adding_cat = $cat->add_category($this->input->post());
			
			if($adding_cat=='category already exists'){
				$data['errors'] = '<div class="hidden" id="category_already_exists"></div>';
				$this->add_category($data);
			} else{
				$data['notifications'] = '<div class="hidden" id="category_added"></div>';
				$this->categories($data);
			}
		}
	}

	public function edit_category($id, $data = array()){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		$data = $cat->load_category($id);
		
		$this->layout->set_active_menu('menu_edit_categories', 'menu_categories');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/categories.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($this->title.' catégorie de produits : '.$data['name']);
		$this->layout->set_header('<span class="hidden-xs">Catégorie de produits <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </span>'.$data['name']);
		$this->layout->view('manager/edit_category', $data);
	}

	public function edit_category_check_form($id){
		if($this->form_validation->run()==FALSE){
			$this->edit_category($id);
		} else{
			$this->load_class('categories');
			$cat = new Categories($this->est_id);
			$cat->update_category($id, $this->input->post());
			$this->form_validation->reset_field_data();
			$data['notifications'] = '<div class="hidden" id="category_modified"></div>';
			$this->categories($data);
		}
	}

	public function delete_category($id){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		
		$data = array();
		$data['errors'] = '';
		$data['errors'] .= ($cat->category_exists_in_menus($id)) ? '<div class="hidden" id="category_existing_in_compo"></div>' : '';
		$data['errors'] .= ($cat->count_products_in_category($id)>0) ? '<div class="hidden" id="products_existing_in_category" data-cat-id="'.$id.'"></div>' : '';
		
		if(empty($data['errors'])){
			$cat->delete_category($id);
			$data['notifications'] = '<div class="hidden" id="category_deleted"></div>';
		}
		$this->categories($data);
	}

	public function modify_category_rank($id, $go){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		$cat->modify_category_rank($id, $go);
		$data['notifications'] = '<div id="category_rank_modified"></div>';
		$data['scroll_to'] = 'table_categories';
		$this->categories($data);
	}

	public function prices_categories($data = array()){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		$cat->reorganize_ranks_categories();
		$categories = $cat->categories_manager();
		$data = array_merge($data, $categories);
		
		//If no categories, force to add the first category
		if(count($data['categories'])==0){
			redirect('manager/add_category');
		} else{
			$this->layout->set_title($this->title.'Quantités');
			$this->layout->set_header('Quantités');
			$this->layout->set_active_menu('mod_prices_cat', 'menu_modules');
			$specific_js_files = array( 
				base_url($this->theme_path.'/js/prices_categories.js')
			);
			$this->layout->add_js_files($specific_js_files);
			$this->layout->view('manager/prices_categories', $data);
		}
	}

	public function edit_prices_categories($cat_id){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		$data = $cat->load_category($cat_id);
		
		$this->layout->set_active_menu('mod_prices_cat', 'menu_modules');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/prices_categories.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($this->title.' Quantités : '.$data['name']);
		$this->layout->set_header('<span class="hidden-xs">Quantités <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </span>'.$data['name']);
		$this->layout->view('manager/edit_prices_categories', $data);
	}

	public function add_prices_category_check_form($cat_id){
		if($this->form_validation->run()==FALSE){
			$this->edit_prices_categoryies($cat_id);
		} else{
			$this->load_module('prices_categories');
			$mod_prices_cat = new Module_prices_categories($this->est_id);
			$mod_prices_cat->add_prices_category($cat_id, $this->input->post());
			$this->form_validation->reset_field_data('prices_category_name');
			$data['notifications'] = '<div class="hidden" id="prices_category_added"></div>';
			$this->edit_prices_categories($cat_id, $data);
		}
	}

	public function modify_prices_category_rank($prices_cat_id, $cat_id, $go){
		$this->load_module('prices_categories');
		$mod_prices_cat = new Module_prices_categories($this->est_id);
		$mod_prices_cat->modify_prices_category_rank($prices_cat_id, $cat_id, $go);
		$data['notifications'] = '<div id="prices_category_rank_modified"></div>';
		$this->edit_prices_categories($cat_id, $data);
	}

	public function edit_prices_category_name(){
		$this->load_module('prices_categories');
		$mod_prices_cat = new Module_prices_categories($this->est_id);
		$mod_prices_cat->update_name($this->input->post());
	}

	public function delete_prices_category($prices_category_id){
		$this->load_module('prices_categories');
		$mod_prices_cat = new Module_prices_categories($this->est_id);
		$cat_id = $mod_prices_cat->delete_prices_category($prices_category_id);
		$data['notifications'] = '<div class="hidden" id="prices_category_deleted"></div>';
		$this->edit_prices_categories($cat_id, $data);
	}

	public function products_by_cat($cat_id, $data = array()){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		if($cat->count_products_in_category($cat_id)==0){
			redirect('manager/add_product/'.$cat_id);
		} else{
			$this->load_class('products');
			$prod = new Products($this->est_id);
			$prod->reorganize_ranks_products($cat_id);
			$data = $prod->products_by_cat($cat_id);
			$this->layout->set_title($this->title.$data['category']['name']);
			$this->layout->set_header('<span class="hidden-xs">Produits <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </span>'.$data['category']['name']);
			$this->layout->set_active_menu('menu_cat_'.$data['category']['id'], 'menu_product');
			$specific_js_files = array( 
				base_url($this->theme_path.'/js/product.js')
			);
			$this->layout->add_js_files($specific_js_files);
			$this->layout->view('manager/products_by_cat', $data);
		}
	}

	public function add_product($selected_cat = 0, $data = array()){
		$this->load_class('categories');
		$cat = new Categories($this->est_id);
		$data['categories'] = $cat->categories_list();
		

		//A revoir 
		if($this->mods->prices_cat==1){
			$this->load_module('prices_categories');
			$mod_prices_cat = new Module_prices_categories($this->est_id);
			foreach($data['categories'] as $cat_id => $cat){
				$data['categories'][$cat_id]['prices_cat'] = $mod_prices_cat->select_prices_for_a_cat($cat_id);
			}
		} else{
			foreach($data['categories'] as $cat_id => $cat){
				$data['categories'][$cat_id]['prices_cat'] = array();
			}
		}
		
		$data['selected_cat'] = $selected_cat;
		
		$this->layout->set_title($this->title.'Ajouter un produit');
		$this->layout->set_header('Ajouter un produit');
		$this->layout->set_active_menu('menu_add_product', 'menu_product');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/products.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->view('manager/add_product', $data);
	}

	public function add_product_check_form($cat_id = 0){
		if($this->form_validation->run()==FALSE){
			$this->add_product($cat_id);
		} else{
			$data = array();
			$this->load_class('products');
			$prod = new Products($this->est_id);
			
			//Insert the new product
			$new_prod_id = $prod->add_product($this->input->post());
			
			//Manage prices categories
			if($this->input->post('prices_categories')==1){
				$this->load_module('prices_categories');
				$mod_prices_cat = new Module_prices_categories($this->est_id);
				$post_prices_cat = $this->input->post('prices_category['.$this->input->post('category').']');
				$mod_prices_cat->insert_product_prices($new_prod_id, $post_prices_cat);
			}
			
			//Manage the image
			$data['logo_error'] = $prod->upload_image_product($new_prod_id, $_FILES);
			
			$cat_id = $this->input->post('category');
			$this->form_validation->reset_field_data();
			$data['notifications'] = '<div class="hidden" id="product_added"></div>';
			$this->edit_product($new_prod_id, $data);
		}
	}

	public function edit_product($id, $data = array()){
		$this->load_class('categories');
		$this->load_class('products');
		
		$cat = new Categories($this->est_id);
		$prod = new Products($this->est_id);
		
		$data['categories'] = $cat->categories_list();
		$data['product'] = $prod->load_product($id);
		$data['mod_suggest'] = $this->mods->suggest;
		$data['product']->price = number_format($data['product']->price, 2);
		

		//A revoir
		if($this->mods->prices_cat==true){
			$this->load_module('prices_categories');
			$mod_prices_cat = new Module_prices_categories($this->est_id);
			foreach($data['categories'] as $cat_id => $cat){
				$data['categories'][$cat_id]['prices_cat'] = $mod_prices_cat->select_prices_for_a_cat($cat_id);
			}
			if($data['product']->prices_categories==1){
				$data['product']->price = $mod_prices_cat->load_prices_for_a_product($id);
			}
		} else{
			foreach($data['categories'] as $cat_id => $cat){
				$data['categories'][$cat_id]['prices_cat'] = array();
			}
		}
		

		if(isset($data['logo_error'])){
			$data['errors'] = '<div class="hidden" id="upload_image_problem"></div>';
		}
		
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/products.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($this->title.'Produit : '.$data['product']->name);
		$this->layout->set_header('<span class="hidden-xs">'.$data['categories'][$data['product']->cat_id]['name'].' <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </span>'.$data['product']->name);
		$this->layout->set_active_menu('menu_cat_'.$data['product']->cat_id, 'menu_product');
		$this->layout->view('manager/edit_product', $data);
	}

	public function edit_product_check_form($id){
		if($this->form_validation->run()==FALSE){
			$this->edit_product($id);
		} else{
			$this->load_class('products');
			$prod = new Products($this->est_id);
			$data = array();
			
			//Fetch some datas...
			$cat_id = $this->input->post('category');
			$prices_categories = ($this->input->post('prices_categories')==0) ? 0 : 1;
			$price = ($prices_categories==0) ? str_replace(',', '.', $this->input->post('price')) : 0;
			

			$data['logo_error'] = $prod->upload_image_product($id, $_FILES);
			$prod->update_product($id, $this->input->post());
			
			//Modify product's category
			$this->load->model('link_cat_prod_model', 'link_cp');
			$link_cp = $this->link_cp->select(array( 
				'prod_id' => $id
			));
			if($cat_id!=$link_cp->cat_id){
				$prod->modify_product_category($id, $cat_id);
			}
			
			//Fill the differents prices for each prices categories
			if($prices_categories==1){
				$this->load_module('prices_categories');
				$mod_prices_cat = new Module_prices_categories($this->est_id);
				$post_prices = $this->input->post('prices_category['.$cat_id.']');
				
				if($cat_id==$link_cp->cat_id){
					//Just update the prices cat
					$mod_prices_cat->update_product_prices($id, $post_prices);
				} else{
					//Modify the cat, so insert the prices_cat
					$mod_prices_cat->insert_product_prices($id, $post_prices);
				}
			}
			
			$data['notifications'] = '<div class="hidden" id="product_modified"></div>';
			if($prices_categories==0&&$price==0){
				$data['errors'] = '<div class="hidden" id="no_price_for_this_product"></div>';
			}
			
			$this->form_validation->reset_field_data();
			
			if(isset($data['logo_error'])&&!empty($data['logo_error'])){
				$data['errors'] = element('errors', $data, '').'<div class="hidden" id="upload_image_problem"></div>';
			}
			$this->edit_product($id, $data);
		}
	}

	public function delete_product($id, $cat_id = 0){
		$this->load_class('products');
		$prod = new Products($this->est_id);
		$prod->delete_product($id);
		$data['notifications'] = '<div id="product_deleted"></div>';
		$this->products_by_cat($cat_id, $data);
	}

	public function modify_product_rank($id, $go){
		$this->load_class('products');
		$prod = new Products($this->est_id);
		$product = $prod->modify_product_rank($id, $go);
		$data['notifications'] = '<div id="product_rank_modified"></div>';
		$data['scroll_to'] = 'table_category_'.$product->cat_id;
		$this->products_by_cat($product->cat_id, $data);
	}

	public function menus($data = array()){
		$this->load_module('menu');
		$mod_menu = new Module_menu($this->est_id);
		
		if($mod_menu->count_menus_in_establishment()==0){
			redirect('manager/add_menu');
		} else{
			$mod_menu->reorganize_ranks_menus();
			$data['menus'] = $mod_menu->select_all_menus_by_est();
			$this->layout->set_title($this->title.'Menus');
			$this->layout->set_header('Menus');
			$this->layout->set_active_menu('mod_menus', 'menu_modules');
			$specific_js_files = array( 
				base_url($this->theme_path.'/js/menus.js')
			);
			$this->layout->add_js_files($specific_js_files);
			$this->layout->view('manager/menus', $data);
		}
	}

	public function add_menu(){
		$this->layout->set_title($this->title.'Ajouter un menu');
		$this->layout->set_header('Ajouter un menu');
		$this->layout->set_active_menu('mod_menus', 'menu_modules');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/menus.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->view('manager/add_menu');
	}

	public function edit_menu($id, $data = array()){
		$this->load_module('menu');
		$mod_menu = new Module_menu($this->est_id);
		$mod_menu->reorganize_ranks_composition($id);
		$data = array_merge($data, $mod_menu->load_menu($id));
		
		$this->layout->set_active_menu('mod_menus', 'menu_modules');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/menus.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($this->title.'Menu '.$data['menu']['name']);
		$this->layout->set_header('<span class="hidden-xs">Menu <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> </span>'.$data['menu']['name']);
		$this->layout->view('manager/edit_menu', $data);
	}

	public function edit_composition($compo_id = 0, $data = array()){
		$this->load_module('menu');
		$mod_menu = new Module_menu($this->est_id);
		$data = $mod_menu->edit_composition($compo_id);
		$this->layout->set_active_menu('mod_menus', 'menu_modules');
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/menus.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($data['composition']->menu_name.' / '.$data['composition']->compo_name);
		$this->layout->set_header($data['composition']->menu_name.' <i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i> '.$data['composition']->compo_name);
		$this->layout->view('manager/edit_composition', $data);
	}

	public function add_menu_check_form(){
		if($this->form_validation->run()==FALSE){
			$this->add_menu();
		} else{
			$this->load_module('menu');
			$mod_menu = new Module_menu($this->est_id);
			$menu_id = $mod_menu->add_menu($this->input->post());
			$this->form_validation->reset_field_data();
			$data['notifications'] = '<div class="hidden" id="menu_added"></div>';
			$this->edit_menu($menu_id, $data);
		}
	}

	public function modify_menu_rank($id, $go){
		$this->load_module('menu');
		$mod_menu = new Module_menu($this->est_id);
		$mod_menu->modify_menu_rank($id, $go);
		$data['notifications'] = '<div id="menu_rank_modified"></div>';
		$this->menus($data);
	}

	public function edit_menu_check_form($id){
		if($this->form_validation->run()==FALSE){
			$this->edit_menu($id);
		} else{
			$this->load_module('menu');
			$mod_menu = new Module_menu($this->est_id);
			$mod_menu->update_menu($id, $this->input->post());
			$data['notifications'] = '<div class="hidden" id="menu_modified"></div>';
			$this->edit_menu($id, $data);
		}
	}

	public function delete_menu($id){
		$this->load_module('menu');
		$mod_menu = new Module_menu($this->est_id);
		if($mod_menu->compo_existing($id)>0){
			$data['errors'] = '<div class="hidden" id="composition_existing_in_menu" data-id="'.$id.'"></div>';
		} else{
			$mod_menu->delete_menu($id);
			$data['notifications'] = '<div class="hidden" id="menu_deleted"></div>';
		}
		$this->menus($data);
	}

	public function add_composition($menu_id){
		if($this->form_validation->run()==FALSE){
			$this->edit_menu($menu_id);
		} elseif($this->input->post('one_category')=='on'&&$this->input->post('cat_id')==0){
			$data['errors'] = '<div class="hidden" id="select_cat_for_composition"></div>';
			$this->edit_menu($menu_id, $data);
		} else{
			$this->load_module('menu');
			$mod_menu = new Module_menu($this->est_id);
			$post = $this->input->post();
			$compo_id = $mod_menu->add_composition($menu_id, $post);
			$data['notifications'] = '<div class="hidden" id="menu_modified"></div>';
			$this->edit_composition($compo_id, $data);
		}
	}

	public function modify_composition_rank($compo_id, $go){
		$this->load_module('menu');
		$mod_menu = new Module_menu($this->est_id);
		$menu_id = $mod_menu->modify_composition_rank($compo_id, $go);
		$data['notifications'] = '<div id="composition_rank_modified"></div>';
		$this->edit_menu($menu_id, $data);
	}

	public function delete_composition($compo_id){
		$this->load_module('menu');
		$mod_menu = new Module_menu($this->est_id);
		$menu_id = $mod_menu->delete_composition($compo_id);
		$data['notifications'] = '<div class="hidden" id="composition_deleted"></div>';
		$this->edit_menu($menu_id, $data);
	}

	public function edit_composition_check_form($compo_id = 0){
		if($this->form_validation->run()==FALSE){
			$this->edit_composition($compo_id);
		} else{
			$this->load_module('menu');
			$mod_menu = new Module_menu($this->est_id);
			$menu_id = $mod_menu->update_composition($compo_id, $this->input->post());
			$this->form_validation->reset_field_data();
			$data['notifications'] = '<div class="hidden" id="composition_modified"></div>';
			$this->edit_menu($menu_id, $data);
		}
	}

	public function modules($data = array()){
		$data['modules'] = $this->mods;
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/modules.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($this->title.'Modules');
		$this->layout->set_header('Modules');
		$this->layout->set_active_menu('menu_modules_selection', 'menu_modules');
		$this->layout->view('manager/modules', $data);
	}

	public function modules_selection(){
		$this->load_class('modules');
		$modules = new Modules($this->est_id);
		$mod_id = $modules->switch_module($this->input->post());
		echo $mod_id;
	}

	public function mod_social($data = array()){
		$this->load_module('social');
		$mod_social = new Module_social($this->est_id);
		$mod_social->load();
		$data['facebook'] = $mod_social->facebook;
		$data['twitter'] = $mod_social->twitter;
		$data['instagram'] = $mod_social->instagram;
		
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/mod_social.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($this->title.'Réseaux sociaux');
		$this->layout->set_header('Réseaux sociaux');
		$this->layout->set_active_menu('mod_social', 'menu_modules');
		$this->layout->view('manager/mod_social', $data);
	}

	public function mod_social_check_form(){
		if($this->form_validation->run()==FALSE){
			$this->mod_social();
		} else{
			$this->load_module('social');
			$mod_social = new Module_social($this->est_id);
			$mod_social->update($this->input->post());
			$data['notifications'] = '<div class="hidden" id="social_datas_updated"></div>';
			$this->mod_social($data);
		}
	}

	public function suggestions($data = array()){
		$this->load_module('suggestion');
		$mod_suggest = new Module_suggestion($this->est_id);
		
		$data['categories'] = $mod_suggest->load_suggested_products();
		$specific_js_files = array( 
			base_url($this->theme_path.'/js/mod_suggest.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($this->title.'Suggestions');
		$this->layout->set_header('Suggestions');
		$this->layout->set_active_menu('mod_suggest', 'menu_modules');
		$this->layout->view('manager/mod_suggest', $data);
	}

	public function remove_suggestion($prod_id, $data = array()){
		$this->load_module('suggestion');
		$mod_suggest = new Module_suggestion($this->est_id);
		$mod_suggest->delete_suggestion($prod_id);
		$data['notifications'] = '<div class="hidden" id="suggestion_deleted"></div>';
		$this->suggestions($data);
	}

	public function switch_maintenance_mode(){
		$this->load->model('establishments_model', 'estab');
		$maintenance = $this->estab->select(array( 
			'id' => $this->est_id
		));
		$switch = ($maintenance->maintenance==1) ? 0 : 1;
		$responseText = ($switch==1) ? 'enabled' : 'disabled';
		$maintenance = $this->estab->update(array( 
			'id' => $this->est_id
		), array( 
			'maintenance' => $switch
		));
		echo $responseText;
	}

	public function help($data = array()){
		$data['subject'] = '';
		$data['message'] = '';
		$specific_js_files = array( 
			base_url($this->theme_path.'/vendors/bootstrap-wizard/jquery.bootstrap.wizard.min.js'),
			base_url($this->theme_path.'/js/help.js'),
			base_url($this->theme_path.'/js/contact.js')
		);
		$this->layout->add_js_files($specific_js_files);
		$this->layout->set_title($this->title.'Aide');
		$this->layout->set_header('Aide');
		$this->layout->set_active_menu('menu_help', 'menu_home');
		$this->layout->view('manager/help', $data);
	}

	public function contact_check_form(){
		if($this->form_validation->run()==FALSE){
			$this->help();
		} else{
			$data = array();
			$this->load->model('subscribers_model', 'sub');
			$this->load->model('establishments_model', 'estab');
			$sub = $this->sub->select(array( 
				'id' => $this->sub_id
			));
			$estab = $this->estab->select_est_by_sub_id($this->sub_id);
			
			$to = 'contact@smartmenu.fr';
			$subject = 'Aide utilisateur - '.$this->input->post('subject');
			$message = '<html><head></head><body>';
			$message .= "<h3>Utilisateur : ".$sub->email.'</h3>';
			$message .= "<h3>Titre : ".$this->input->post('subject').'</h3>';
			$message .= "<br />";
			$message .= "<u>Message :</u><br />".$this->input->post('message');
			$message .= '</body></html>';
			
			$this->load->library('email');
			$this->email->from($sub->email, $estab->name);
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			
			if($this->email->send(FALSE)==true){
				$this->form_validation->reset_field_data();
				$data['notifications'] = '<div class="hidden" id="mail_sended"></div>';
			} else{
				$data['errors'] = '<div class="hidden" id="contact_form_error"></div>';
			}
			$this->help($data);
		}
	}

	public function datas_missing(){
		//MOCHE :(
		if($this->router->fetch_method()!='establishment'&&$this->router->fetch_method()!='establishment_check_form'&&$this->router->fetch_method()!='help'){
			
			//Vérifie sont réellement manquante
			$this->load->model('establishments_model', 'est');
			$est = $this->est->select(array( 
				'id' => $this->est_id
			));
			if(!empty($est->name)&&!empty($est->url)&&!empty($est->adress)&&!empty($est->postal_code)&&!empty($est->city)){
				$this->layout->set_datas_missing(false);
				$this->session->unset_userdata('datas_missing');
			} else{
				$this->layout->set_datas_missing(true);
				$this->session->set_userdata('datas_missing', '1');
			}
		} else{
			$this->layout->set_datas_missing(false);
		}
	}

}