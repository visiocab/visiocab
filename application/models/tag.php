<?php

class Tag extends CI_Model {

	function __construct ( ) {
		parent::__construct();
	}

	public function add($tagname, $package_id){
		$data = array(
			'tagname' => $tagname, 
			'package_id' => $package_id
		);
		$this->db->insert('tags', $data);
		return true;
	}

	public function delete($tagname, $package_id){
		$this->db->query('DELETE FROM tags WHERE package_id = ? AND tagname = ?', array($package_id, $tagname));
		return true;
	}

	public function getTags($package_id) {
		$rez = $this->db->select('tagname')->from('tags')->where('package_id', $package_id)->get();
		$ret = array();
		foreach($rez->result_array() as $k) {
			$ret[] = $k['tagname'];
		}
		return $ret;
	}
}
