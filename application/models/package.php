<?php

class Package extends CI_Model {

	function __construct ( ) {
		parent::__construct();
	}
	
	public function selectPackage($quiz_id, $pano_id, $creator='', $name='', $isother=false) {
		$pid = $this->db->select('id')->from('package')->where(array('quiz_id' => $quiz_id, 'tour_scene_id' => $pano_id, 'creator_user_id' => $creator))->get()->row()->id;
		if (!$pid) {
			$newarray = array('id'=>'','name' => $name, 'quiz_id'=> $quiz_id, 'date_added' => date('Y-m-d H:i:s'), 'creator_user_id' => $creator);
			if ($isother) {
				$newarray['tour_scene_id'] = 0;
				$newarray['othermedia_id'] = $pano_id;
			} else {
				$newarray['tour_scene_id'] = $pano_id;
				$newarray['othermedia_id'] = 0;
			}
			$this->db->insert('package', $newarray);
			$pid = mysql_insert_id();
		}
		return $pid;
	}
	
	public function getFromPackage($package_id) {
		return $this->db->select('*')->from('package')->where('id', $package_id)->get()->row_array();
	}
	
	public function saveTourQuiz($package, $newvalues) {
		$this->db->query("DELETE FROM package_items WHERE package_id = ? ", $package);
		if (!empty($newvalues)) {
			$this->db->insert_batch('package_items', $newvalues); 
		}
		if (mysql_error()) {
			return mysql_error();
		} else {
			return false;
		}
	}

	public function getInfo($package_id) {
		$qry = "SELECT *, P.id package_id, P.name package_name, CONCAT('/tour/',T.path,'/',S.path,'/') fullpath FROM package P LEFT JOIN scene S ON P.tour_scene_id = S.id LEFT JOIN tour T ON T.id = S.tour_id WHERE P.id = ?";
		return $this->db->query($qry, $package_id)->row_array();
	}

	public function getPackageInfo($package_id) {
		$rez = $this->db->select('P.*, Q.qtext questiontext', false)->from('package_items P')->join('question Q', 'P.question_id = Q.id', 'left')->where('package_id', $package_id)->order_by('question_order')->get();
		$retarray = array();
		foreach ($rez->result_array() as $k => $v) {
			$tmparray = $v;
			$tmparray['questionabbrev'] = substr(strip_tags($tmparray['questiontext']), 0, 30);
			$retarray[] = $tmparray;
		}
		return $retarray;
	}

	public function getQuestions($package_id) {
		$qry = "SELECT * FROM answer A LEFT JOIN question Q ON A.question_id = Q.id LEFT JOIN quiz QZ ON Q.quiz_id = QZ.id INNER JOIN package_items PI ON Q.id = PI.question_id LEFT JOIN package P ON PI.package_id = P.id WHERE P.id = ?";
		return $this->db->query($qry, $package_id)->result_array();
	}
	
	public function getQuestionsSorted($package_id) {
		$qry = "SELECT * FROM answer A LEFT JOIN question Q ON A.question_id = Q.id LEFT JOIN quiz QZ ON Q.quiz_id = QZ.id INNER JOIN package_items PI ON Q.id = PI.question_id LEFT JOIN package P ON PI.package_id = P.id WHERE P.id = ?";
		$fullq = array();
		$fulla = array();
		foreach($this->db->query($qry, $package_id)->result_array() as $k=>$v) {
			$fullq['iq'.$v['question_order']] = array('qtext' => $v['qtext'], 'qtype' => $v['qtype']);
			$fulla['iq'.$v['question_order']][$v['aorder']] = array('atext' => $v['atext'], 'correct' => $v['correct']);
		}
		return array('questions' => $fullq, 'answers' => $fulla);
	}

	public function findXmlFile($package_id) {
		$qry = "SELECT *, CONCAT('/tour/',T.path,'/',S.path,'/project_out.xml') XmlFile FROM package P LEFT JOIN scene S ON P.tour_scene_id = S.id LEFT JOIN tour T ON S.tour_id = T.id WHERE P.id = ?";
		$rez = $this->db->query($qry, $package_id)->row();
		if (!is_file($_SERVER['DOCUMENT_ROOT'].$rez->XmlFile)) {
			$qry = "SELECT *, CONCAT('/tour/',T.path,'/',S.path,'/pano_out.xml') XmlFile FROM package P LEFT JOIN scene S ON P.tour_scene_id = S.id LEFT JOIN tour T ON S.tour_id = T.id WHERE P.id = ?";
			$rez = $this->db->query($qry, $package_id)->row();
		}
		return $rez->XmlFile;
	}

	public function findPath($package_id) {
		$qry = "SELECT *, CONCAT('/tour/',T.path,'/',S.path) FilePath FROM package P LEFT JOIN scene S ON P.tour_scene_id = S.id LEFT JOIN tour T ON S.tour_id = T.id WHERE P.id = ?";
		return $this->db->query($qry, $package_id)->row()->FilePath;
	}

	public function getHotspots($package_id) {
		$qry = "SELECT * FROM package_items PI LEFT JOIN package P ON PI.package_id = P.id WHERE P.id = ? ORDER BY question_order";
		return $this->db->query($qry, $package_id)->result_array();
	}
	
	public function listPackages($user_id=0) {
		/*$rez = $this->db->query("SELECT *, 
									P.id xpackageid, 
									P.name xpackagename, 
									Q.id xquizid, 
									Q.name xquizname, 
									T.id xtourid, 
									T.name xtourname, 
									S.id xsceneid, 
									S.name xscenename 
								FROM package P 
								LEFT JOIN quiz Q 
									ON P.quiz_id = Q.id 
								LEFT JOIN scene S 
									ON P.tour_scene_id = S.id 
								LEFT JOIN tour T 
									ON S.tour_id = T.id 
								WHERE P.creator_user_id = ?", $user_id); 
								
SELECT *,  P.id xpackageid,  P.name xpackagename,  Q.id xquizid,  Q.name xquizname,  T.id xtourid,  T.name xtourname,  IF(O.id IS NULL, S.id, O.id) xsceneid,  IF(O.name IS NULL, S.name, O.name) xscenename, O.*  FROM package P  LEFT JOIN quiz Q  ON P.quiz_id = Q.id  LEFT JOIN scene S  ON P.tour_scene_id = S.id  LEFT JOIN tour T  ON S.tour_id = T.id LEFT JOIN othermedia O ON P.othermedia_id = O.id								
								
								*/
		$rez = $this->db->select('*, P.id xpackageid, P.name xpackagename, Q.id xquizid, Q.name xquizname, T.id xtourid, T.name xtourname, IF(O.id IS NULL, S.id, O.id) xsceneid,  IF(O.name IS NULL, S.name, O.name) xscenename', false)
			->from('package P')
			->join('quiz Q','P.quiz_id = Q.id ','left')
			->join('scene S','P.tour_scene_id = S.id','left')
			->join('tour T', 'S.tour_id = T.id', 'left')
			->join('othermedia O', 'P.othermedia_id = O.id', 'left');
		if ($user_id) {
			$rez->where('P.creator_user_id', $user_id);
		}
		$rez2 = $rez->get();
		return $rez2->result_array();
	}
	
	public function delete_package($pkg_id) {
		$this->db->query('DELETE FROM package WHERE id = ? LIMIT 1', $pkg_id);
		$this->db->query('DELETE FROM package_items WHERE package_id = ?', $pkg_id);
		return true;
	}

	public function delete_assignment($idtodelete) {
		$this->db->query('DELETE FROM assignments WHERE id = ? LIMIT 1', $idtodelete);
		$this->db->query('DELETE FROM assignments_classes WHERE assignment_id = ?', $idtodelete);
		return true;
	}

	public function remove($packageid) {
		# SELECT quiz_id from package WHERE id = $id
		$quizid = $this->db->select('quiz_id')->from('package')->where('id', $packageid)->get()->row()->quiz_id;
		# SELECT id FROM question WHERE quiz_id = $quizid
		$questions = $this->db->select('id')->from('question')->where('quiz_id', $quizid)->get()->result_array();
		$qstodelete = array();
		foreach ($questions as $k) {
			$qstodelete[] = $k['id'];
		}
		if (sizeof($qstodelete)) {
			#delete questions
			# DELETE FROM question WHERE id IN(quiz questions)
			$this->db->query('DELETE FROM question WHERE id IN('.join(',',$qstodelete).')');
			#delete answers
			# DELETE FROM answer WHERE question_id IN(quiz questions)
			$this->db->query('DELETE FROM answer WHERE question_id IN('.join(',',$qstodelete).')');
		}
		#delete quizbank
		# DELETE FROM quiz WHERE id = $quizid
		$this->db->query("DELETE FROM quiz WHERE id = $quizid");
		#delete package items
		$this->db->query("DELETE FROM package_items WHERE package_id = $packageid");
		#delete visiocab
		# DELETE FROM package WHERE id = $id
		$this->db->query("DELETE FROM package WHERE id = $packageid");
		return true;
	}

	private function _getanswers($quizid) {
		$rez = $this->db->query("SELECT A.id from answer A LEFT JOIN question Q ON Q.id = A.question_id where Q.quiz_id = ?", $quizid);
		$ret = array();
		foreach ($rez->result_array() as $k=>$v) {
			$ret[] = $v['id'];
		}
		return $ret;
	}

	public function setpublic($id, $value) {
		$newval = array('is_public' => $value);
		$this->db->where('id', $id)->update('package', $newval);
		if (mysql_error()) {
			return mysql_error();
		} else {
			return false;
		}
	}

}
