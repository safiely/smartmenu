<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Module_social {

	private $CI;
    public $est_id;
    public $facebook;
    public $twitter;
    public $instagram;


	public function __construct($est_id) {
		$this->CI =& get_instance();		
        $this->CI->load->model('module_social_model','model_social');
        $this->est_id = intval($est_id);
    }
    
    /**
     Load the establishment's social datas.
     */
    public function load(){
        $social_datas = $this->CI->model_social->select(array('est_id' => $this->est_id));
        $this->facebook = $social_datas->facebook;
        $this->twitter = $social_datas->twitter;
        $this->instagram = $social_datas->instagram;
    }





    
    public function update($social_datas){
        /*Update the establishment's social datas*/
		$this->CI->model_social->update(array('est_id' => $this->est_id), $social_datas);
    }
	
    
	public function insert(){
        /*Create the establishment's entry in the mod_social table*/
		$this->CI->model_social->insert(array('est_id' => $this->est_id));
	}
    
    
	public function delete(){
        /*Delete the establishment's entry in the mod_social table*/
		$this->CI->model_social->delete(array('est_id' => $this->est_id));
	}
    
    

}