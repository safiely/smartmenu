<?php
if(!defined('BASEPATH'))
	exit('No direct script access allowed');
class Establishment{
	private $CI;
	private $est_id;

	
	/**
	 * Menu Constructor
	 *
	 * @param int $est_id        	
	 */
	public function __construct($est_id){
		$this->CI = & get_instance();
		$this->est_id = $est_id;
		$this->CI->load->model('establishments_model', 'est');
	}

	public function load_establishment(){
		return $this->CI->est->select(array( 
			'id' => $this->est_id
		));
	}

	public function update_establishment($post){
		$post['url'] = strtolower($post['url']);
		$data = array();
		
		if($this->url_is_free($post['url'])){
			$this->CI->est->update(array( 
				'id' => $this->est_id
			), $post);
			
			$data['notifications'] = '<div class="hidden" id="datas_modified"></div>';
			//Geocode establishment adress
			$geo_coords = $this->geocode_adress($post['adress'], $post['postal_code'], $post['city']);
			$this->CI->est->update(array(
				'id' => $this->est_id
			), array(
				'geo_lat' => $geo_coords['lat'],
				'geo_lng' => $geo_coords['lng']
			));
		} else{
			$data['errors'] = '<div class="hidden" id="existing_url"></div>';
		}
				

		return $data;
	}

	public function url_is_free($url){
		$url = $this->CI->est->select(array( 
			'url' => $url,
			'id !=' => $this->est_id
		));
		return (count($url)>0) ? false : true;
	}

	
	/**
	 * Translate a human postal adress in GPS coordonates
	 *
	 * @param str $addr        	
	 * @param str $cp        	
	 * @param
	 *        	str$city
	 */
	public function geocode_adress($addr, $cp, $city){
		$address = $addr.', '.$cp.', '.$city;
		$geocoder = "https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=AIzaSyC00YMfe4e3PPHpUNs-Zvhw5GvIy-yY3qY";
		$url_address = urlencode($address);
		$query = sprintf($geocoder, $url_address);
		$results = json_decode(file_get_contents($query));
		$coords = array( 
			'lat' => 0,
			'lng' => 0
		);
		if(isset($results->results[0])&&!empty($results->results[0]->formatted_address)){
			$coords['lat'] = $results->results[0]->geometry->location->lat;
			$coords['lng'] = $results->results[0]->geometry->location->lng;
		}
		return $coords;
	}

}

?>