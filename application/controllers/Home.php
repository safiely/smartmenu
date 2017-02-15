<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		
		
		//Chargement du fichier langue (application/language)
		$this->lang->load('fr', $this->config->item('language'));
		$this->load->library(array('layout_home', 'form_validation'));
		$this->layout_home->set_theme('home');
		$this->theme_path = 'assets/theme_home';
	    
	    
		$common_css_files = array(
			base_url($this->theme_path.'/css/bootsrap.min.css'),
			base_url($this->theme_path.'/css/theme-bootsrap.min.css'),
			base_url($this->theme_path.'/css/style.css'),
			base_url($this->theme_path.'/css/material-design-iconic-font.min.css')
		);
		$this->layout_home->add_css_files($common_css_files);
		
		$common_js_files = array(
			base_url($this->theme_path.'/js/jquery-2.2.0.min.js'),
			base_url($this->theme_path.'/js/bootstrap-3.3.6.min.js'),
			base_url($this->theme_path.'/js/custom.js'),
			base_url('/assets/theme_user/vendor/jquery-ui/jquery-ui-1.11.4.min.js'),
			base_url($this->theme_path.'/js/function.js')
		);
	    
		$this->layout_home->add_js_files($common_js_files);
		$this->form_validation->set_error_delimiters("<div class='has-error'><small class='help-block'>","</small></div>");
		$this->layout_home->set_description('Avec Smartmenu.fr, découvrez une application conçue '.
						    'pour un nouvel usage des cartes de restauration. Restaurant, '.
						    'bar, fast-food,... accèdez à la carte depuis un smartphone, une tablette ou tout autre support, '.
						    'et bénéficiez des avantages qu\'offre la carte de restauration nouvelle génération.');
		$this->layout_home->set_keywords('cartes de restauration,restaurant,bar,fast-food,cartes,'.
						 'menu,produits,carte en ligne,appli carte de restaurant,resto,'.
						 'internet,carte de restaurant internet');
	    
	}
	
	
	public function index() {
		$this->load->library('user_agent');
		
		//Redirect the non-mobile device to the pro page
		if(!$this->agent->is_mobile()){
			$this->pros();
		} else {
			$specific_js_files = array('http://maps.google.com/maps/api/js',
						   base_url($this->theme_path.'/js/home.js')
						   );
			$this->layout_home->add_js_files($specific_js_files);
			$this->layout_home->set_pro(false);
			$this->layout_home->set_title('Vos cartes de restaurant en ligne.');
			$this->layout_home->view('home/home');
		}
	}
	
	public function geocoder(){
		$this->load->model('establishments_model','est');
		$establishments = $this->est->select_establishments_for_geocoding();
		$list = array();
		
		foreach($establishments as $k => $est){
			$data = array();
			$data['url'] = $est->url;
			$data['name'] = $est->name;
			$data['logo'] = $est->logo;
			$data['formatted_address'] = $est->adress.', '.$est->postal_code.', '.$est->city;
			$data['lat'] = $est->geo_lat;
			$data['lng'] = $est->geo_lng;
			$list[] = $data;
		}
		$json = json_encode($list);
		header('Content-Type: application/json');
		echo $json;
	}
	
	public function pros(){
		$specific_css_files = array(base_url($this->theme_path.'/css/demo.css'));
		$this->layout_home->add_css_files($specific_css_files);
		$specific_js_files = array(base_url($this->theme_path.'/js/demo.js'),
					   base_url($this->theme_path.'/js/pros.js'));
		$this->layout_home->add_js_files($specific_js_files);
		$this->layout_home->set_active_page('pros');
		$this->layout_home->set_title('Professionnels de la restauration, connectez votre carte à vos clients.');
		$this->layout_home->view('home/pros');
	}
	
	
	public function prices(){
		$this->layout_home->set_active_page('prices');
		$this->layout_home->set_title('Votre carte de restauration connectée pour 15€ par mois.');
		$this->layout_home->view('home/prices');
	}
	
	public function demos(){
		$specific_css_files = array(base_url($this->theme_path.'/css/demo.css'));
		$this->layout_home->add_css_files($specific_css_files);
		$specific_js_files = array(base_url($this->theme_path.'/js/demo.js'));
		$this->layout_home->add_js_files($specific_js_files);
		$this->layout_home->set_active_page('demos');
		$this->layout_home->set_title('Démonstration d\'une carte de restauration en ligne.');
		$this->layout_home->view('home/demos');
	}
	
	public function legal(){
		$this->layout_home->set_title('Mentions légales');
		$this->layout_home->view('home/legal');
	}
	
	public function contact($data = array()){
		$specific_js_files = array(base_url($this->theme_path.'/js/contact.js'));
		$this->layout_home->add_js_files($specific_js_files);
		$this->layout_home->set_active_page('contact');
		$data['message'] = (isset($data['message'])) ? $data['message'] : '';
		$this->layout_home->set_title('En savoir plus sur notre logiciel de carte de restauration.');
		$this->layout_home->view('home/contact', $data);
	}
	
	public function registration($data = array()){
		$specific_js_files = array(base_url($this->theme_path.'/js/registration.js'));
		$this->layout_home->add_js_files($specific_js_files);
		$this->layout_home->set_active_page('registration');
		$data['message'] = (isset($data['message'])) ? $data['message'] : '';
		$this->layout_home->set_title('Créer votre carte de restauration en ligne gratuitement.');
		$this->layout_home->view('home/registration', $data);
	}
	
	public function login($data = array()){
		$specific_js_files = array(base_url($this->theme_path.'/js/login.js'));
		$this->layout_home->add_js_files($specific_js_files);
		$this->layout_home->set_active_page('login');
		$data['message'] = (isset($data['message'])) ? $data['message'] : '';
		$data['mail'] = (isset($data['mail'])) ? $data['mail'] : '';
		$this->layout_home->set_title('Gérez votre carte de restauration connectée.');
		$this->layout_home->view('home/login', $data);
	}
	
	
	public function logout($sub_id = 0){
		$this->session->sess_destroy();
		
		if($sub_id>0){
			$this->load->model('subscribers_model','sub');
			$sub = $this->sub->select(array('id' => $sub_id));
			$data['message'] = 'À bientôt !';
			$data['mail'] = $sub->email;
		} else {
			$data['message'] = 'Vous devez être connecter à votre compte pour accéder à cette page.';
			$data['mail'] = '';
		}
		$this->layout_home->set_title('Gérez votre carte de restauration connectée.');
		$this->layout_home->view('home/login', $data);
	}
	
	
	
	public function registration_check_form($data = array()){
		$this->layout_home->set_active_page('registration');
                if ($this->form_validation->run()==FALSE){
			$data['message'] = '';
                        $this->layout_home->view('home/registration', $data);
                } else {
                        $this->load->model('subscribers_model','sub');
			$this->load->model('establishments_model','est');
			$this->load->model('link_sub_est_model','link_se');
			$this->load->model('customisation_model','custom');
			$this->load->model('modules_model','module');
			
			$result = array();
			
			
			$hash_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$str = $this->input->post('email').$this->input->post('password');
			$activation_hash = md5($str);
			
			//Insert new subscriber
			$fields = array('email' => $this->input->post('email'),
					'password' => $hash_password,
					'activation_hash' => $activation_hash
					);
			$this->db->set('creation', 'NOW()', FALSE);
			
			$result['sub'] = $this->sub->insert($fields);
			$result['sub_id'] = intval($this->db->insert_id());
			
			
			//Insert new establishment
			$fields = array('id'=>'');
			$result['est'] = $this->est->insert($fields);
			$result['est_id'] = intval($this->db->insert_id());
			$this->est->update(array('id' => $result['est_id']),
					   array('url' => $result['est_id'])
					   );
			
			//Insert new relation sub/est
			$fields = array('sub_id' => $result['sub_id'],
					'est_id' => $result['est_id']
					);
			$result['link_se'] = $this->link_se->insert($fields);
			
			
			//Insert new customisation
			$this->custom->insert(array('est_id' => $result['est_id']));
			
			//Insert new modules
			$this->module->insert(array('est_id' => $result['est_id']));
			
			
			//Send confirmation mail
			$this->load->library('email');
			$to = trim($this->input->post('email'));
			$subject  = 'Smartmenu.fr - confirmation de votre inscription';
			
			$file_attachment = getcwd()."/assets/theme_manager/img/smartmenu-logo-350px.png";
			$this->email->attach($file_attachment);
			$cid = $this->email->attachment_cid($file_attachment);
			
			$message  = '<html><head></head><body>';
			$message .= '<h3>Merci pour votre inscription sur Smartmenu.fr !</h3>';
			$message .= '<br />';
			$message .= 'Afin de finaliser votre inscription, merci de cliquer sur ce lien :';
			$message .= '<br />';
			$message .= '<a href="'.base_url().'home/activation_link/'.$result['sub_id'].'/'.$activation_hash.'" target="_blank">'.base_url().'home/activation_link/'.$result['sub_id'].'/'.$activation_hash.'</a>';
			$message .= '<br />';
			$message .= '<br />';
			$message .= 'A bientôt !';
			$message .= '<br />';
			$message .= "<img src='cid:".$cid."' /><br />";
			$message .= '</body></html>';
			
			$this->email->from('contact@smartmenu.fr', 'Smartmenu.fr');
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			
			if($this->email->send(FALSE)==true) {
				$data['message'] = 'Merci pour votre inscription. Veuillez activer votre compte grâce au lien de confirmation qui vient de vous être envoyé par mail.';
				$this->login($data);
				
			} else {
				/*
				$this->layout_home->debug($this->email->print_debugger());
				$this->layout_home->debug($this->email);
				$data = array();
				*/
				$data['message'] = 'Un problème est survenue durant la création de votre compte.';
				$this->registration($data);
			}
                }
	}
	
	
	
	
	
	public function login_check_form(){
		$this->layout_home->set_active_page('login');
		if ($this->form_validation->run()==FALSE){
                        $this->login();
                } else {
                        $this->load->model('subscribers_model','sub');
			$fields['email'] = $this->input->post('email');
			$sub = $this->sub->select($fields);
		
			if($sub == TRUE && $sub->id>0) {
				
				if($sub->active==0){
					$data['message'] = 'Votre compte est désactivé. Merci de cliquer sur le lien d\'activation envoyé par mail lors de votre inscription.';
					$this->login($data);
				} elseif(!password_verify($this->input->post('password'), $sub->password)){
					$data['message'] = 'Le mot de passe que vous avez saisi n\'est pas correct.';
					$this->login($data);
					
				} else {
					$this->session->set_userdata('sub_id',$sub->id);
					$this->load->model('link_sub_est_model','link_se');
					$fields = array('sub_id' => $sub->id);
					$link_se = $this->link_se->select($fields);
					$this->session->set_userdata('est_id', $link_se->est_id);
					
					//Récup liste catégorie et menu
					$this->load->model('categories_model','cat');
					$this->session->set_userdata('categories', $this->cat->select_all_cat_by_est($this->session->userdata('est_id')));
					
					$this->load->model('menus_model','menus');
					$this->session->set_userdata('menus', $this->menus->list_menus_by_est($this->session->userdata('est_id')));
					
					
					redirect('manager');
				}
			} else {
				$data['message'] = 'Cet email ne correspond à aucun de nos abonnés.';
				$this->login($data);
			}
                }
	}
	
	
	public function activation_link($sub_id, $activation_hash, $password = ''){
		$this->layout_home->set_active_page('login');
		$this->load->model('subscribers_model','sub');
		$sub = $this->sub->select(array('id' => $sub_id));
		$forgotten_password = (!empty($password)) ? true : false;
		
		if($sub->activation_hash == $activation_hash){
			$this->sub->update(array('id' => $sub_id),
					array('active' => '1',
					      'activation_hash' => '')
					);
			if($forgotten_password==false){
				$data['message'] = 'Votre compte est maintenant actif, vous pouvez vous connecter.';
			} else {
				$data['message'] = 'Votre mot de passe à bien été modifié, vous pouvez vous connecter.';
			}
			$data['mail'] = $sub->email;
			$this->login($data);
		} else {
			$data['message'] = 'Votre activation ne s\'est pas bien effectuée. Merci de nous contacter pour résoudre ce problème.';
			$this->login($data);
		}
		
	}
	
	
	public function forgotten_password($data = array()){
		$data['mail'] = '';
		$data['message'] = (!isset($data['message'])) ? '' : $data['message'];
		$this->layout_home->set_title('Mot de passe oublié');
		$this->layout_home->view('home/forgotten_password', $data);
	}
	
	
	public function forgotten_password_check_form($data = array()){
		$email = trim($this->input->post('email'));
		if ($this->form_validation->run()==FALSE){
			$data['mail'] = $email;
                        $this->forgotten_password($data);
                } else {
			$this->load->model('subscribers_model','sub');
			$sub = $this->sub->select(array('email' => $email));
			
			
			if($sub->id>0){
				$hash_password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
				$str = $this->input->post('email').$this->input->post('password');
				$activation_hash = md5($str);
				
				//Update password in database
				$this->sub->update(array('id' => $sub->id),
						   array('password' => $hash_password,
							'active' => '0',
							'activation_hash' => $activation_hash)
						   );
				
				//Send confirmation mail
				$this->load->library('email');
				
				$to = $email;
				$subject  = 'Smartmenu.fr - renouvellement de votre mot de passe';
				
				$file_attachment = getcwd()."/assets/theme_manager/img/smartmenu-logo-350px.png";
				$this->email->attach($file_attachment);
				$cid = $this->email->attachment_cid($file_attachment);
				
				$message  = '<html><head></head><body>';
				$message  = 'Vous venez de modifier votre mot de passe.';
				$message .= '<br />';
				$message .= '<br />';
				$message .= 'Afin de prendre cette modification en compte, merci de cliquer sur ce lien :';
				$message .= '<br />';
				$message .= '<a href="'.base_url().'home/activation_link/'.$sub->id.'/'.$activation_hash.'/forgotten_password" target="_blank">'.base_url().'home/activation_link/'.$sub->id.'/'.$activation_hash.'/forgotten_password</a>';
				$message .= '<br />';
				$message .= '<br />';
				$message .= 'A bientôt !';
				$message .= '<br />';
				$message .= "<img src='cid:".$cid."' /><br />";
				$message .= "</body></html>";
				
				$this->email->from('contact@smartmenu.fr', 'Smartmenu.fr');
				$this->email->to($to);
				$this->email->subject($subject);
				$this->email->message($message);
				
				if($this->email->send(FALSE)==true) {
					$data['message'] = 'La modification de votre mot de passe a bien été prise en compte. Pour finir cette procédure, cliquer sur le lien de confirmation qui vient de vous être envoyé par mail.';
					$this->login($data);
				} else {
					/*
					$this->layout_home->debug($this->email->print_debugger());
					$this->layout_home->debug($this->email);
					$data = array();
					*/
					$data['message'] = 'Un problème est survenue durant le changement de votre mot de passe.';
					$this->forgotten_password($data);
				}
			} else {
				$data['message'] = 'Cet email ne correspond à aucun de nos abonnés.';
				$this->forgotten_password($data);
			}
		}
	}
	
	
	public function contact_check_form(){
		$this->layout_home->set_active_page('contact');
		if ($this->form_validation->run()==FALSE){
			$this->contact();
                } else {
			$data = array();
			
			
			$to = 'contact@smartmenu.fr';
			$subject = 'Contact - '.$this->input->post('subject');
			$message = '<html><head></head><body>';
			$message .= "<h3>Contact : ".$this->input->post('email').'</h3>';
			$message .= "<h3>Titre : ".$this->input->post('subject').'</h3>';
			$message .= "<br />";
			$message .= "<u>Message :</u><br />".$this->input->post('message');
			$message .= '</body></html>';
			
			$this->load->library('email');
			$this->email->from($this->input->post('email'));
			$this->email->to($to);
			$this->email->subject($subject);
			$this->email->message($message);
			
			if($this->email->send(FALSE)==true) {
				$this->form_validation->reset_field_data();
				$data['message'] = '<p class="green">Votre message a bien été envoyé.</p>';
			} else {
				/*
				$this->layout->debug($this->email->print_debugger());
				$this->layout->debug($this->email);
				$data = array();
				*/
				$data['message'] = '<p class="red">Problème lors de l\'envoi de votre message.</p>';
			}
			$this->contact($data);
                }
	}
	
	public function search_establishment(){
		$name = strtolower(trim(urldecode($this->input->get('q'))));
		$this->load->model('establishments_model','establishment');
		$establishments = $this->establishment->select_all_establishments();
		$selection = array();
		foreach($establishments as $k => $est){
			$est_name = strtolower($est->name);
			similar_text($est_name, $name, $percent);
			if($percent>=75){
				$selection[] = $est;
			} elseif(strpos($est_name, $name)!==FALSE){
				$selection[] = $est;
			}
		}
		echo json_encode($selection);
	}
	
	public function maintenance(){
		$this->layout_home->set_title('Cette carte de restauration est en cours de maintenance.');
		$this->layout_home->view('home/maintenance');
	}
	
	
	
	public function demos_preview($type, $url){
		
		
		$types = array('mobile' => array('width' => 325, 'height' => 560, 'version' => 'version mobile'),
			       'tablet' => array('width' => 1024, 'height' => 768, 'version' => 'version tablette')
			       );
		
		
		$data['name'] = 'Démo';
		$data['type'] = $type;
		
		if($type!='user'){
			$data['sizes'] = $types[$type];
			$data['url'] = 'http://smartmenu.fr/'.$url;
		} else {
			$data['url'] = 'http://smartmenu.fr/'.$url;
		}
		
		if($type=='user'){
			redirect($data['url']);
		} else {
			$this->layout_home->set_title('Démonstration de notre logiciel de carte de restauration en ligne.');
			$this->load->view('manager/preview', $data);
		}
	}
	
}
