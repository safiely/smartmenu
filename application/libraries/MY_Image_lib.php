<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class MY_Image_lib extends CI_Image_lib{

	
	/**
	 * Resize an image with this constraint : max width 1024px OR max height 768px *
	 *
	 * @param string $path
	 *        	The path of the folder containg the file
	 * @param string $file
	 *        	The file
	 */
	public function resize_to_1024_by_768_max($path, $file){
		$full_path = $path.$file;
		$img = getimagesize($path.$file);
		$img_width = $img[0];
		$img_height = $img[1];
		$config['image_library'] = 'gd2';
		$config['source_image'] = $full_path;
		$config['width'] = 1024;
		$config['height'] = 768;
		$config['overwrite'] = true;
		$config['new_image'] = $full_path;
		$this->initialize($config);
		
		if($img_width>1024||$img_height>768){
			if(!$this->resize()){
				return false;
			} else{
				return true;
			}
		} else{
			return true;
		}
	}

	
	/**
	 * Transforme une image afin d'obtenir une image carré au final avant de la thumbnailiser
	 * Utile pour avoir un format standard carré
	 * En gros :
	 * - si l'image est plus large que haute, on coupe en largeur
	 * - si l'image est plus haute que large, on coupe en hauteur
	 *
	 * !! Ne redimenssionne pas l'image !! (un des coté restera le même)
	 * !! Créé une nouvelle image (avec suffixe _cropped) mais ne la supprimer pas !!!!
	 * 
	 * @param string $path
	 *        	The folder path
	 * @param string $file
	 *        	The file in the folder
	 * @return boolean
	 */
	public function crop_image($path, $file){
		$full_path = $path.$file;
		$img = getimagesize($path.$file);
		$img_width = $img[0];
		$img_height = $img[1];
		$side_to_crop = ($img_width>$img_height) ? 'width' : 'height';
		$standard_size = ($img_width>$img_height) ? $img_height : $img_width;
		$too_much_pixels = abs($img_width-$img_height);
		$to_cut = intval($too_much_pixels/2);
		
		$config = array();
		$config['image_library'] = 'gd2';
		$config['source_image'] = $full_path;
		
		if($side_to_crop=='width'){
			$config['x_axis'] = $to_cut;
			$config['y_axis'] = 0;
			$config['width'] = $standard_size;
			$config['height'] = $img_height;
		} elseif($side_to_crop=='height'){
			$config['x_axis'] = 0;
			$config['y_axis'] = $to_cut;
			$config['width'] = $img_width;
			$config['height'] = $standard_size;
		}
		$config['maintain_ratio'] = FALSE;
		$config['new_image'] = $path.'cropped_'.$file;
		$this->initialize($config);
		
		if(!$this->crop()){
			return false;
		}
		return true;
	}

	
	/**
	 * Prends une image et la force aux dimensions 100px * 100px
	 * A utiliser après crop_image (histoire d'avoir une image carré et non déformée, et centrée)
	 *
	 * @param string $path
	 *        	The folder path
	 * @param string $file
	 *        	The file in the folder
	 * @return boolean
	 */
	public function thumbnailize_image($path, $file){
		$config['image_library'] = 'gd2';
		$config['source_image'] = $path.'cropped_'.$file;
		$config['create_thumb'] = TRUE;
		$config['width'] = 100;
		$config['height'] = 100;
		$config['overwrite'] = true;
		$config['new_image'] = $path.'thumbnails/thumb_'.$file;
		$this->initialize($config);
		
		if(!$this->resize()){
			return false;
		} else{
			if(file_exists($path.'cropped_'.$file)==true){
				unlink($path.'cropped_'.$file);
			}
			return true;
		}
	}

}

?>