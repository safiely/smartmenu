<?php defined('BASEPATH') OR exit('No direct script access allowed');


//A AMELIORER//A AMELIORER//A AMELIORER//A AMELIORER//A AMELIORER

class Dispatch extends CI_Controller {
    
    private $request;
    private $est;
    
    public function __construct(){
        
            parent::__construct();
            
            $this->request = str_replace('/','',$_SERVER['REQUEST_URI']);
            $this->load->model('establishments_model','establishment');
	    $this->est = $this->establishment->select_row_array(array('url' => $this->request));
            
    }
    
    public function index(){
        if(empty($this->est)){
	    redirect('/home');
        } else {
            redirect('user?est_id='.$this->est['id'], 'location');
        }
    }
    
    
}
