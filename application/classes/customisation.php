<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Customisation{
	private $CI;
	private $est_id;

	
	/**
	 * Customisation Constructor
	 *
	 * @param int $est_id        	
	 */
	public function __construct($est_id){
		$this->CI = & get_instance();
		$this->est_id = $est_id;
		$this->CI->load->model('customisation_model', 'custom');
	}
	
	/**
	 * Load the main customisation datas
	 * 
	 */
	public function load_customisation(){
		return $this->CI->custom->select(array(
			'est_id' => $this->est_id
		));
	}
	

	/**
	 * Update the establishment's customisation datas
	 * 
	 * @param array $post
	 *        	the global POST variable
	 */
	public function update_customisation($post){
		$image = (element('no_image', $post)=='on') ? '' : $post['image'];
		$this->CI->custom->update(array( 
			'est_id' => $this->est_id
		), array( 
			'presentation' => $post['presentation'],
			'background_image' => $image
		));
	}

	
	/**
	 * Upload, resize, and update table_customisation::image for the establishment's logo
	 */
	public function upload_customisation_logo($files){
		if(!empty($files['logo']['name'])){
			$config['upload_path'] = './uploads/logos';
			$config['file_name'] = 'logo_'.$this->est_id;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['overwrite'] = true;
			$this->CI->load->library('upload', $config);
			
			//Upload the file
			if(!$this->CI->upload->do_upload('logo')){
				$data = array( 
					'error' => $this->CI->upload->display_errors()
				);
				return $data;
			} else{
				//Update the database field
				$this->CI->custom->update(array( 
					'est_id' => $this->est_id
				), array( 
					'logo' => $this->CI->upload->data('file_name')
				));
				
				//Resizing			
				$path = './uploads/logos/';
				$file = $this->CI->upload->data('file_name');
				
				$this->CI->load->library('image_lib');
				$this->CI->image_lib->resize_to_1024_by_768_max($path, $file);
				$this->CI->image_lib->crop_image($path, $file);
				$this->CI->image_lib->thumbnailize_image($path, $file);
			}
		}
	}
	
	
	/**
	 * Fetch default image files for background-image
	 */	
	public function fetch_customisation_background_image(){
		$this->CI->load->helper('file');
		$data = array();
		$data['img_background_default'] = get_filenames('./assets/common/img/background/default');
		$data['img_background_default_path'] = '/assets/common/img/background/default';
		return $data;
	}

}

?>