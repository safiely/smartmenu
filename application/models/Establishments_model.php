<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Establishments_model extends MY_Model
{
	
	protected $table = 'establishments';
	
	
	public function select_all_establishments() {
		return $this->db
			->select('url, name, city')
			->from($this->table)
			->where('url != "" AND name !=""')
			->get()
			->result();
	}
	
	public function select_est_by_sub_id($sub_id){
		return $this->db
		->select()
		->from($this->table.' AS est, link_sub_est AS link_se, subscribers AS sub')
		->where('est.id = link_se.est_id AND link_se.sub_id = sub.id AND sub.id = '.$sub_id)
		->get()
		->row();
	}
	
	public function select_establishments_for_geocoding() {
		return $this->db
			->select('url, name, adress, postal_code, city, logo, geo_lat, geo_lng')
			->from('modules, '.$this->table)
			->join('customisation', 'customisation.est_id = establishments.id', 'left')
			->where('url!= "" AND name!="" AND adress!="" AND postal_code!="" AND city!="" AND geo_lat!="0.000000" AND geo_lng!="0.000000" AND establishments.id = modules.est_id AND modules.geoloc=1')
			->get()
			->result();
	}
}