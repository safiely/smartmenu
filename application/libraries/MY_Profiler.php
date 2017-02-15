<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class MY_Profiler extends CI_Profiler{

	/**
	 * Compile $_POST Data
	 *
	 * @return string
	 */
	protected function _compile_post(){
		$output = "\n\n".'<fieldset id="ci_profiler_post" style="border:1px solid #009900;padding:6px 10px 10px 10px;margin:20px 0 20px 0;background-color:#eee;">'."\n".'<legend style="color:#009900;">&nbsp;&nbsp;'.$this->CI->lang->line('profiler_post_data')."&nbsp;&nbsp;</legend>\n";
		
		$post = (isset($_POST)) ? $_POST : array();
		$files = (isset($_FILES)) ? $_FILES : array();
		
		
		if(count($post)===0&&count($files)===0){
			$output .= '<div style="color:#009900;font-weight:normal;padding:4px 0 4px 0;">'.$this->CI->lang->line('profiler_no_post').'</div>';
		} else{
			$output .= "\n\n<table style=\"width:100%;\">\n";
			
			foreach($post as $key => $val){
				is_int($key) or $key = "'".$key."'";
				
				$output .= '<tr><td style="width:50%;padding:5px;color:#000;background-color:#ddd;">&#36;_POST['.$key.']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#009900;font-weight:normal;background-color:#ddd;">';
				
				if(is_array($val) or is_object($val)){
					$output .= '<pre>'.htmlspecialchars(stripslashes(print_r($val, TRUE))).'</pre>';
				} else{
					$output .= htmlspecialchars(stripslashes($val));
				}
				
				$output .= "</td></tr>\n";
			}
			
			foreach($files as $key => $val){
				is_int($key) or $key = "'".$key."'";
				
				$output .= '<tr><td style="width:50%;padding:5px;color:#000;background-color:#ddd;">&#36;_FILES['.$key.']&nbsp;&nbsp; </td><td style="width:50%;padding:5px;color:#009900;font-weight:normal;background-color:#ddd;">';
				
				if(is_array($val) or is_object($val)){
					$output .= '<pre>'.htmlspecialchars(stripslashes(print_r($val, TRUE))).'</pre>';
				}
				
				$output .= "</td></tr>\n";
			}
			
			$output .= "</table>\n";
		}
		
		return $output.'</fieldset>';
	}

}

?>