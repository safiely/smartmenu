<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout_home {
	
	
	private $CI;
	private $var = array();
	private $theme = "";
	private $enable_profiler = false;
	
	
	
	public function __construct() {
		
		$this->CI =& get_instance();
		$this->var['output'] = '';
		$this->var['title'] = '';
		$this->var['description'] = '';
		$this->var['keywords'] = '';
		$this->var['css'] = array();
		$this->var['js'] = array();
		$this->var['pro'] = true;
		$this->var['active_page'] = '';
		
		//$this->CI->load->helper('word');
		/*
		if(ENVIRONMENT == 'development'){
			$this->enable_profiler = true;
		}*/
		
	}
	

	
	
	public function view($name, $data = array()) {
		
		$this->var['output'] .= $this->CI->load->view($name, $data, true);		
		
		//Profiler
		if($this->enable_profiler){
			$this->CI->load->library('profiler');
	
			if ( ! empty($this->CI->output->_profiler_sections)){
			    $this->CI->profiler->set_sections($this->CI->output->_profiler_sections);
			}
		
			// If the output data contains closing </body> and </html> tags
			// we will remove them and add them back after we insert the profile data
			if (preg_match("|</body>.*?</html>|is", $this->var['output'])){
				$this->var['output']  = preg_replace("|</body>.*?</html>|is", '', $this->var['output']);
				$this->var['output'] .= $this->CI->profiler->run();
				$this->var['output'] .= '</body></html>';
			} else {
				$this->var['output'] .= $this->CI->profiler->run();
			}
		}
		
		$this->CI->load->view('../views/'.$this->theme.'/layout.php', $this->var);
	}
	
	public function views($name, $data = array()) {
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
	}
	
	public function debug($str) {
		if(!isset($this->var['debug']) && ENVIRONMENT!='production') {
			$this->var['debug'] = '<pre>'.print_r($str, true).'</pre>';
		}
		elseif(ENVIRONMENT!='production'){
			$this->var['debug'] .= '<pre>'.print_r($str, true).'</pre>';
		}
		return true;
		
	}
	
	
	public function set_theme($theme) {
		if(is_string($theme) AND !empty($theme) AND file_exists('./application/views/'.$theme.'/layout.php')) {
			$this->theme = $theme;
			return true;
		}
		return false;
	}
	
	
	public function set_title($title) {
		//max 20 characters
		if(is_string($title) AND !empty($title)) {
			$this->var['title'] = $title;
			return true;
		}
		return false;
	}
	public function set_description($desc) {
		if(is_string($desc) AND !empty($desc)) {
			$this->var['description'] = $desc;
			return true;
		}
		return false;
	}
	public function set_keywords($keywords) {
		if(is_string($keywords) AND !empty($keywords)) {
			$this->var['keywords'] = $keywords;
			return true;
		}
		return false;
	}
	
	
	public function add_css_files($css_files) {
		if(is_array($css_files)) {
			foreach($css_files as $path){
				$this->var['css'][] = $path;
			}
			return true;
		}
		return false;
	}
	
	
	public function add_js_files($js_files) {
		if(is_array($js_files)) {
			foreach($js_files as $path){
				$this->var['js'][] = $path;
			}
			return true;
		}
		return false;
	}
	
	
	public function set_pro($bool){
		$this->var['pro'] = $bool;
	}
	
	public function set_active_page($str){
		$this->var['active_page'] = $str;
	}
	
	/*public function set_sub_id($sub_id) {
		if($sub_id>0) {
			$this->var['sub_id'] = $sub_id;
			return true;
		}
		return false;
	}
	
	public function set_datas_missing($data) {
		$this->var['datas_missing'] = $data;
		return true;
	}
	
	public function set_header($header) {
		if(is_string($header)) {
			$this->var['header'] = $header;
			return true;
		}
		return false;
	}
	
	public function set_active_menu($str, $root=''){
		if(is_string($str)) {
			$this->var['active_menu'] = $str;
			if(is_string($root) && !empty($root)){
				$this->var['toggle_menu'] = $root;
			}
			return true;
		}
		return false;
	}
	
	public function categories_list($categories){
		if(is_array($categories)) {
			$this->var['cat_list'] = $categories;
		}
		return false;
	}
	
	public function menus_list($menus){
		if(is_array($menus)) {
			$this->var['menus_list'] = $menus;
		}
		return false;
	}
	
	
	public function set_maintenance($bool){
		$this->var['maintenance'] = $bool;
	}
	*/
	
}