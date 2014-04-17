<?php

class Quiz extends CI_Model {

	function __construct ( ) {
		parent::__construct();
	}

	public function getAllQuizzes($user_id) {
		$theres = $this->db->select('*')->from('quiz')->where('user_id', $user_id)->or_where('user_id', 0)->get();
		$retarray = array();
		foreach ($theres->result_array() as $k => $v) {
			$retarray[$v['id']] = $v['name'];
		}
		natsort($retarray);
		return $retarray;
	}
	
	public function getQuizInfo($quiz_id) {
		$rez = $this->db->query("SELECT *, A.id answerid, CONCAT(SUBSTRING(Q.qtext, 1, 12), '...') questionabbrev FROM answer A LEFT JOIN question Q ON Q.id = A.question_id LEFT JOIN quiz Z ON 	Z.id = Q.quiz_id WHERE Z.id = ? ORDER BY aorder ASC", $quiz_id);
		$retarray = array();
		foreach ($rez->result_array() as $k=>$v) {
			$answers[$v['question_id']]['qtext'] = $v['qtext'];
			$answers[$v['question_id']]['qtype'] = $v['qtype'];
			$answers[$v['question_id']]['questionabbrev'] = substr(strip_tags($v['qtext']), 0, 30);
			$answers[$v['question_id']]['answers'][] = array('aid' => $v['answerid'], 'correct' => $v['correct'], 'atext' => $v['atext'], 'aresp' => $v['response']);
		}
		return $answers;
	}
	
	public function getQuizName($quiz_id) {
		return $this->db->select('name')->from('quiz')->where('id', $quiz_id)->get()->row()->name;
	}
	
	public function getUserAnswer($pkgid, $qid, $answer) {
		$qry = "SELECT A.id user_answer, A.response user_response FROM package_items PI INNER JOIN answer A ON PI.question_id = A.question_id AND A.aorder = ? WHERE PI.package_id = ? and CONCAT('iq', PI.question_order) = ? ";
		$rez = $this->db->query($qry, array($answer, $pkgid, $qid))->row_array();
		return $rez['user_answer'];
	}

	public function getUserResponse($pkgid, $qid, $answer) {
		$qry = "SELECT A.id user_answer, A.response user_response FROM package_items PI INNER JOIN answer A ON PI.question_id = A.question_id AND A.aorder = ? WHERE PI.package_id = ? and CONCAT('iq', PI.question_order) = ? ";
		$rez = $this->db->query($qry, array($answer, $pkgid, $qid))->row_array();
		return $rez['user_response'];
	}

	public function isInfoBox($pkgid, $qid) {
		$qry = "SELECT IF(qtype='infobox', 1, 0) isinfobox, nexttext FROM 
					question Q LEFT JOIN package_items PI ON Q.id = PI.question_id 
					WHERE PI.package_id = ? AND CONCAT('iq', PI.question_order) = ?";
		$rez = $this->db->query($qry, array($pkgid, $qid));
		return $rez->row_array();
	}

	public function checkQuizAnswer($pkgid, $qid) {
		$qry = "SELECT A.aorder correct_selection, nexttext, A.question_id question_id FROM package_items PI INNER JOIN answer A ON PI.question_id = A.question_id AND A.correct = 100 WHERE PI.package_id = ? and CONCAT('iq', PI.question_order) = ? ";
		$rez = $this->db->query($qry, array($pkgid, $qid));
		if ($rez->num_rows) {
			return $rez->row_array();
		} else {
			return array();
		}
	}
	
	public function isQuizFinished($pkgid, $qid) {
#		$qry = "SELECT IF(MAX(question_order) - ? <= 0, 1, 0) x FROM package_items where package_id = ?";
		$qry = "SELECT IF(MAX(question_order) = (REPLACE(?, 'iq', '')*1), 1, 0) x FROM package_items where package_id = ?";
		return $this->db->query($qry, array($qid, $pkgid))->row()->x;
	}
	
	public function startQuiz($quizname, $user_id) {
		$this->db->query("INSERT INTO quiz SET name = ?, user_id = ?, date_added = NOW()", array($quizname, $user_id));
		return mysql_insert_id();
	}
	
	public function storeQuestion($qdata) {
		$this->db->insert('question', $qdata);
		return mysql_insert_id();
	}

	public function updateQuestion($qdata) {
		$this->db->where('id', $qdata['id'])->update('question', $qdata);
		return $qdata['id'];
	}
	
	public function answersForQuestion($qid, $answers) {
		// we're going to make this action transactional, so we don't delete stuff that doesn't get replaced
		if ($qid > 0 && sizeof($answers) > 0) {
			$this->db->trans_start();
			$this->db->query('DELETE FROM answer WHERE question_id = ?', $qid);
			$this->db->insert_batch('answer', $answers);
			$this->db->trans_complete();
		}
		return true;
	}
	
	public function copyQuestionSet($quiz_to_copy, $name, $user_id) {
		$datarray = array( 'name' => $name, 'user_id' => $user_id, 'date_added' => date('Y-m-d H:i:s'));
		$this->db->insert('quiz', $datarray);
		$newquizid = $this->db->insert_id();
		
		$oldquiz = $this->db->select('*')->from('question')->where('quiz_id', $quiz_to_copy)->get();
		foreach ($oldquiz->result_array() as $v) {
			#create a new question
			$qstdata = array(
				'quiz_id' => $newquizid,
				'qtext' => $v['qtext'],
				'qtype' => $v['qtype'],
				'date_added' => date('Y-m-d H:i:s')
			);
			$this->db->insert('question', $qstdata);
			$newqstnid = $this->db->insert_id();

			#insert all the answers for this question.  don't know how to do this in adodb terms, so here's a query
			$answerquery = "INSERT INTO answer (question_id, aorder, correct, atext, date_added) 
					SELECT $newqstnid, aorder, correct, atext, NOW() FROM answer 
					WHERE question_id = ?";
			$this->db->query($answerquery, $v['id']);
		}
		if (mysql_error()) {
			return false;
		} else {
			return $newquizid;
		}
	}
	
	public function storeAnswers($ansdata) {
		$this->db->insert_batch('answer', $ansdata);
		return true;
	}

	public function is_user_authorized($quiz_id, $user_id){
		$res = $this->db->select('user_group_role.user_id')
					->from('user_group_role')
					->join('group_quiz', 'user_group_role.group_id = group_quiz.group_id')
					->where('user_group_role.user_id', $user_id)
					->where('group_quiz.quiz_id', $quiz_id)
					->get();
		if($res->num_rows() > 0){
			return true;
		} else {
			return false;
		}
	}

	public function get_quiz_from_assignment_id($assignment_id) {
		return $this->db->select('package_id')->from('assignments')->where('id', $assignment_id)->get()->row()->package_id;
	}

	public function is_current_assignment($assignment_id) {
		// is this assignment between the specified dates?
		$query = "SELECT COUNT(*) count FROM `assignments` WHERE NOW() BETWEEN start_date and end_date and id = ?";
		$rez = $this->db->query($query, $assignment_id)->row_array();
		return $rez['count'];
	}

	public function is_valid_student($user_id,$assignment_id) {
		// is the user assigned to this assignment?
		$query = "SELECT COUNT(*) count FROM classes_students CS LEFT JOIN classes C ON CS.class_id = C.id 
					LEFT JOIN assignments_classes AC ON C.id = AC.class_id LEFT JOIN assignments A ON AC.assignment_id = A.id 
					WHERE CS.student_id = ? AND A.id = ?";
		return $this->db->query($query, array($user_id, $assignment_id))->row()->count;
#		return $rez['count'];
	}
	
	public function is_question_answered($question, $assignment, $user_id) {
#		print "SELECT COUNT(*) count FROM `responses` where question_id = ? and student_id = ? and assignment_id = ? $question, $assignment, $user_id";
		return $this->db->query("SELECT COUNT(*) count FROM `responses` where question_id = ? and student_id = ? and assignment_id = ?", array($question, $user_id, $assignment ))->row_array();
	}
	
	public function get_question_id_from_ajax($pkgid, $qnum) {
		$query = "SELECT PI.question_id FROM assignments A LEFT JOIN package_items PI ON A.package_id = PI.package_id where A.package_id = ? and concat('iq', PI.question_order ) = ?";
		$rez = $this->db->query($query, array($pkgid, $qnum));
		$fez = $rez->row_array();
		return $fez['question_id'];
	}
	
	public function record_answer($student, $assignment, $package, $question, $answer, $correct_answer) {
		$insertdata = array(
			'student_id' => $student, 
			'assignment_id' => $assignment, 
			'package_id' => $package, 
			'question_id' => $question, 
			'answer_id' => $answer, 
			'correct_answer_id' => $correct_answer, 
			'date_recorded' => date('Y-m-d H:i:s')
		);
		$this->db->insert('responses', $insertdata);
		return true;
	}
	
	public function is_valid_key($key) {
		$qry = "SELECT S.id student_id, AST.assignment_id, A.package_id FROM assignments_students AST 
		LEFT JOIN users S ON AST.student_id = S.id
		LEFT JOIN assignments A ON AST.assignment_id = A.id
		WHERE SHA1(CONCAT(S.id, AST.assignment_id, A.package_id, S.created)) = ?";
		$rez = $this->db->query($qry, $key);
		return $rez->row_array();
	}
	
	public function quiz_scenes($quiz_id){
		$res = $this->db->select('scene.name, scene.tour_id, scene.thumbnail, scene.path, scene.scene_order')
					->from('scene')
					->join('package', 'scene.id = package.tour_scene_id')
					->where('package.quiz_id', $quiz_id)
					->order_by('scene.scene_order')
					->get();
		if($res->num_rows() > 0){
			return $res->result();
		} else {
			return false;
		}
	}

	public function question_scenes($question_id){
		$res = $this->db->select('scene.name, scene.tour_id, scene.thumbnail, scene.path, scene.scene_order')
					->from('scene')
					->join('package', 'scene.id = package.tour_scene_id')
					->join('package_items', 'package.id = package_items.package_id')
					->where('package_items.question_id', $question_id)
					->order_by('scene.scene_order')
					->get();
		if($res->num_rows() > 0){
			return $res->result();
		} else {
			return false;
		}			
	}

	public function new_quiz($newname) {
		$datax = array('name' => $newname);
		$this->db->insert('quiz', $datax);
		return mysql_insert_id();
	}

	public function insert_quiz_result($user_id, $quiz_id, $result, $date_completed = '00-00-0000'){
		$data = array(
				'user_id'        => $user_id,
				'quiz_id'        => $quiz_id,
				'result'         => $result,
				'date_completed' => $date_completed,
				'date_added'     => date('Y-m-d H:i:s'),
				'date_modified'  => date('Y-m-d H:i:s')
			);
		$this->db->insert('user_quiz_result', $data);
		return $this->db->insert_id();
	}

	public function update_quiz_result($result_id, $user_id, $quiz_id, $result, $date_completed = '00-00-0000'){
		$data = array(
				'user_id'        => $user_id,
				'quiz_id'        => $quiz_id,
				'result'         => $result,
				'date_completed' => $date_completed,
				'date_modified'  => date('Y-m-d H:i:s')
			);
		$this->db->where('id', $result_id);
		$this->db->update('user_quiz_result', $data);

		if(mysqli_error()){
			return array('error' => mysqli_error());
		}
	}

	public function delete_quiz_result($result_id){
		$this->db->where('id', $result_id);
		$this->db->delete('user_quiz_result');
	}

	public function get_quiz_result($result_id = 0){
		$res = $this->db->select(array(
						'id',
						'user_id',
						'quiz_id',
						'result',
						'date_added',
						'date_modified'
					))
					->from('user_quiz_result')
					->where('id', $result_id);
		return $res->get();
	}

	public function get_user_quiz_result($user_id = 0, $quiz_id = 0){
		$res = $this->db->select(array(
						'id',
						'user_id',
						'quiz_id',
						'result',
						'date_added',
						'date_modified'
					))
					->from('user_quiz_result')
					->where('user_id', $result_id)
					->where('quiz_id', $quiz_id);
		return $res->get();			
	}

	public function insert_user_quiz_answer($quiz_result_id, $question_id, $points){
		$data = array(
				'quiz_result_id' => $quiz_result_id,
				'question_id'    => $question_id,
				'points'         => $points,
				'date_added'     => date('Y-m-d H:i:s'),
				'date_modified'  => date('Y-m-d H:i:s')
			);
		$this->db->insert('user_quiz_answer', $data);
		return $this->db->insert_id();
	}

	public function update_user_quiz_answer($quiz_result_id, $question_id, $points) {
		$data = array(
				'points'        => $points,
				'date_modified' => date('Y-m-d H:i:s')
			);
		$where = array(
				'quiz_result_id' => $quiz_result_id,
				'question_id'    => $question_id
			);

		$this->db->where($where);
		$this->db->update('user_quiz_result', $data);
	}

	public function delete_user_quiz_answer($quiz_result_id, $question_id){
		$where = array(
				'quiz_result_id' => $quiz_result_id,
				'question_id'    => $question_id
			);
		$this->db->where($where);
		$this->db->delete('user_quiz_answer');
	}

	public function get_user_quiz_answer($quiz_result_id, $question_id){
		$res = $this->db->select(array(
				'user_quiz_answer.quiz_result_id',
				'user_quiz_answer.question_id',
				'user_quiz_answer.points',
				'user_quiz_answer.date_added',
				'user_quiz_answer.date_modified'
			))
				->from('user_quiz_answer')
				->where('quiz_result_id', $quiz_result_id)
				->where('question_id', $question_id);
		return $res->get();		
	}

	public function get_user_quiz_result_list($result_id){
		$res = $this->db->select(array(
				'user_quiz_answer.quiz_result_id',
				'user_quiz_answer.question_id',
				'user_quiz_answer.points',
				'user_quiz_answer.date_added',
				'user_quiz_answer.date_modified'
			))
				->from('user_quiz_answer')
				->join('user_quiz_result', 'user_quiz_answer.quiz_result_id = user_quiz_result.id')
				->join('package', 'user_quiz_result.quiz_id = package.quiz_id')
				->join('pakcage_items', 'package.id = package_items.package_id')
				->order_by('package.id')
				->order_by('package_items.question_order');
		return $res->get();		
	}
	
	public function update_quizbank($data, $quiz_id) {
		$this->db->where('id', $quiz_id)->update('quiz', $data); 
		return true;
	}

	public function delete_quizbank($idtodelete) {
		$answers = $this->_getanswers($idtodelete);
		$this->db->where_in('id', $answers)->delete('answer');
		$this->db->query('DELETE FROM quiz WHERE id = ? LIMIT 1', $idtodelete);
		$this->db->query('DELETE FROM question WHERE quiz_id = ?', $idtodelete);
		return true;
	}
	
	public function delete_question($question_id) {
		$this->db->where('id', $question_id)->delete('question');
		$this->db->where('question_id', $question_id)->delete('answer');
		return false;
	}

	public function delete_answer($answer_id) {
		$this->db->where('id', $answer_id)->delete('answer');
		return false;
	}

	public function questions_for_export($quiz_id) {
		$rez = $this->db->query("SELECT * FROM question WHERE quiz_id = ?", $quiz_id);
		return $rez->result_array();
	}
	
	public function answers_for_export($question_id) {
		$rez = $this->db->query("SELECT * FROM answer A WHERE question_id = ?", $question_id);
		return $rez->result_array();
	}

}
