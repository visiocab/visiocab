<?php

class Media extends CI_Model {

	function __construct ( ) {
		parent::__construct();
	}

	public function get_other_media($user_id) {
		$rez = $this->db->select('*')->from('othermedia')->where('user_id', $user_id)->get();
		$ret = array();
		foreach ($rez->result_array() as $v) {
			$ret[$v['id']] = array('title' => $v['name'], 'image' => $v['media']);
		}
		return $ret;
	}

	public function getOtherInfo($media_id) {
		return $this->db->query("SELECT name sname, media spath, name tname, media tpath, media composite FROM othermedia  WHERE id = ?", $media_id)->row_array();
	}
	
	public function getPkgInfo($media_id) {
		$qry = "SELECT id package_id, 1 is_other, name package_name, media fullpath FROM othermedia WHERE id = ?";
		return $this->db->query($qry, $media_id)->row_array();
	}

	public function getPkgInfoFromPkgId($package_id) {
		$other = $this->db->select('othermedia_id')->from('package')->where('id', $package_id)->get()->row()->othermedia_id;
		$qry = "SELECT id package_id, name package_name, media fullpath FROM othermedia WHERE id = ?";
		return $this->db->query($qry, $other)->row_array();
	}
	
	public function insertmedia($file, $name, $user_id) {
		$data = array(
			'name' => $name,
			'user_id' => $user_id,
			'media' => '/othermedia/'.$file
		);
		$this->db->insert('othermedia', $data);
		$new_id = $this->db->insert_id();
		return $new_id;
	}
}