<?php

if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Layout_user{
	private $CI;
	private $var = array();
	private $theme = "";
	private $enable_profiler = false;

	public function __construct(){
		$this->CI = & get_instance();
		$this->var['output'] = '';
		$this->var['title'] = '';
		$this->var['nav_icon'] = '';
		$this->var['nav_icon_href'] = '';
		$this->var['header'] = '';
		$this->var['css'] = array();
		$this->var['js'] = array();
		$this->var['js_spec'] = array();
		$this->var['main_menu'] = array();
		
		$this->CI->load->helper('word');
		
		if(ENVIRONMENT=='development'){
			$this->enable_profiler = false;
		}
	}

	public function view($name, $data = array()){
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		
		//PROFILER
		if($this->enable_profiler){
			$this->CI->load->library('profiler');
			
			if(!empty($this->CI->output->_profiler_sections)){
				$this->CI->profiler->set_sections($this->CI->output->_profiler_sections);
			}
			
			// If the output data contains closing </body> and </html> tags
			// we will remove them and add them back after we insert the profile data
			if(preg_match("|</body>.*?</html>|is", $this->var['output'])){
				$this->var['output'] = preg_replace("|</body>.*?</html>|is", '', $this->var['output']);
				$this->var['output'] .= $this->CI->profiler->run();
				$this->var['output'] .= '</body></html>';
			} else{
				$this->var['output'] .= $this->CI->profiler->run();
			}
		}
		

		$this->CI->load->view('../views/'.$this->theme.'/layout.php', $this->var);
	}

	public function views($name, $data = array()){
		$this->var['output'] .= $this->CI->load->view($name, $data, true);
		return $this;
	}

	public function debug($debug){
		if(!isset($this->var['debug'])&&ENVIRONMENT!='production')
			$this->var['debug'] = '<pre>'.print_r($debug, true).'</pre>';
		elseif(ENVIRONMENT!='production')
			$this->var['debug'] .= '<pre>'.print_r($debug, true).'</pre>';
		return true;
	}

	public function set_establishment($est){
		$this->var['est'] = $est;
		return true;
	}
	
	public function set_customisation($custom){
		$this->var['customisation'] = $custom;
		return true;
	}
	
	public function set_modules($modules){
		$this->var['modules'] = $modules;
		return true;
	}
	
	public function set_categories($categories){
		$this->var['categories'] = $categories;
		return true;
	}
	
	public function set_menus($menus){
		$this->var['menus'] = $menus;
		return true;
	}
	

	public function set_theme($theme){
		if(is_string($theme) and !empty($theme) and file_exists('./application/views/'.$theme.'/layout.php')){
			$this->theme = $theme;
			return true;
		}
		return false;
	}

	function set_nav_icon($icon){
		if(is_string($icon)){
			$this->var['nav_icon'] = "<i class='zmdi zmdi-".$icon."'></i>";
			return true;
		}
		return false;
	}

	function set_panel_id($id){
		
		$this->var['panel_id'] = $id;
		return true;
		
		return false;
	}
	
	
	function set_nav_icon_href($link){
		if(is_string($link)){
			$this->var['nav_icon_href'] = $link;
			return true;
		}
		return false;
	}

	public function add_css_files($css_files){
		if(is_array($css_files)){
			foreach($css_files as $path){
				$this->var['css'][] = $path;
			}
			return true;
		}
		return false;
	}

	public function add_js_files($js_files){
		if(is_array($js_files)){
			foreach($js_files as $path){
				$this->var['js'][] = $path;
			}
			return true;
		}
		return false;
	}

	public function add_specific_js_files($js_files){
		if(is_array($js_files)){
			foreach($js_files as $path){
				$this->var['js_spec'][] = $path;
			}
			return true;
		}
		return false;
	}

	public function set_header($header){
		if(is_string($header)){
			$this->var['header'] = $header;
			return true;
		}
		return false;
	}

	public function is_ordering($order){
		if(is_bool($order)){
			$this->var['order'] = $order;
			return true;
		}
		return false;
	}

	
	
	public function collapse_main_menus($menus, $categories){
		if(is_string($menus)&&is_string($categories)){
			$this->var['main_menu']['menus'] = $menus;
			$this->var['main_menu']['categories'] = $categories;
			return true;
		}
		return false;
	}
	

}