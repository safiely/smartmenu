<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    function reset_field_data() {
        unset($this->_field_data);
        $this->_field_data = array();
        unset($_POST);
    }

    /**
     * Validate URL
     *
     * @access    public
     * @param    string
     * @return    string
     */
    function valid_url($url) {
        if (filter_var($url, FILTER_VALIDATE_URL) == false){
            return FALSE;
        } else {    
            return TRUE;
        }
    }
    
}
