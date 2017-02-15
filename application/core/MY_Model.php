<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// -----------------------------------------------------------------------------

class MY_Model extends CI_Model
{
	/**
	 *	Insère une nouvelle ligne dans la base de données.
	 */
	public function insert($fields = array()){
		return $this->db->set($fields)->insert($this->table);
	}

	/**
	 *	Récupère des données dans la base de données.
	 *	RETOURNE UNE LIGNE SOUS FORME D'OBJET
	 */
	public function select($fields) {
		return $this->db->select()->from($this->table)->where($fields)->get()->row();
	}
	
	/**
	 *	Récupère des données dans la base de données.
	 *	RETOURNE UNE LIGNE SOUS FORME DE TABLEAU
	 */
	public function select_row_array($fields) {
		return $this->db->select()->from($this->table)->where($fields)->get()->row_array();
	}
	
	/**
	 *	Récupère des données dans la base de données.
	 *	RETOURNE PLUSIEURS LIGNE SOUS FORME D'OBJET (??)
	 */
	public function select_many($fields) {
		return $this->db->select()->from($this->table)->where($fields)->get()->result();
	}
	
	
	/**
	 *	Modifie une ou plusieurs lignes dans la base de données.
	 */
	public function update($fields, $data){
		return $this->db->where($fields)->update($this->table, $data);
	}
	
	/**
	 *	Supprime une ou plusieurs lignes de la base de données.
	 */
	public function delete($fields){
		$this->db->delete($this->table, $fields);
	}

	/**
	 *	Retourne le nombre de résultats.
	 */
	public function count($fields){
		return $this->db->where($fields)->from($this->table)->count_all_results();
	}
}

/* End of file MY_Model.php */
/* Location: ./system/application/core/MY_Model.php */