<?php

class Tour extends CI_Model {

	function __construct ( ) {
		parent::__construct();
	}

	public function getAllTours() {
		$rez = $this->db->query("SELECT *, scene.id sid, scene.name sname, scene.path spath, tour.id tid, tour.name tname, tour.path tpath FROM scene left join tour on scene.tour_id = tour.id");
		$retarray = array();
		foreach ($rez->result_array() as $k=>$v) {
			$retarray[$v['tname']]['path'] = $v['tpath'];
			$retarray[$v['tname']]['id'] = $v['tid'];
			$retarray[$v['tname']]['scenes'][$v['sid']]['title'] = $v['sname'];
			$retarray[$v['tname']]['scenes'][$v['sid']]['path'] = $v['spath'];
			$retarray[$v['tname']]['scenes'][$v['sid']]['image'] = $v['thumbnail'];
		}
		return $retarray;
	}
	
	public function getPanoInfo($tour_id) {
		return $this->db->query("SELECT *, scene.name sname, scene.path spath, tour.name tname, tour.path tpath FROM scene LEFT JOIN tour ON scene.tour_id = tour.id WHERE scene.id = ?", $tour_id)->row_array();
		
	}
	
	public function parseTourPath() {
		$retarray = array();
		$this->load->helper('directory');
		$map = directory_map('./tour/');
#		print "<ul>";
		foreach ($map as $k=>$v) {
			$tourid = mysql_insert_id();
			if (!is_numeric($k)) {
#				$this->db->query("INSERT INTO tour SET name= ?, date_added = NOW()", array($k));
				$counter = 0;
				$retarray[$k][$counter] = array();
#				print "<li>$k</li> \n<ul>";
				foreach ($v as $p=>$q) {
					if (!is_numeric($p)) {
						$retarray[$k][$counter]['title'] = $p;
#						print "<li>$p</li>\n";
						if (is_file($_SERVER['DOCUMENT_ROOT'].'/tour/'.$k.'/'.$p.'/pano.preview.jpg')) {
							$retarray[$k][$counter]['image'] = '/tour/'.$k.'/'.$p.'/pano.preview.jpg';
							$image = '/tour/'.$k.'/'.$p.'/pano.preview.jpg';
#							print '<img src="/tour/'.$k.'/'.$p.'/pano.preview.jpg" width="100" height="30" />';
						}
#						$this->db->query("INSERT INTO scene SET tour_id = ?, name = ?, scene_order = ?, date_added = NOW()", array($k, $image, $counter));
					}
					$counter++;
				}
#				print "</ul>";
			}
		}
#		print "</ul>";
		
		return $retarray;
	}
	
}
