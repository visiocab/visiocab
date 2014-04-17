<?php

class Group extends CI_Model {

	function __construct ( ) {
		parent::__construct();
	}

	public function get_groupdata($group_id){
		if (!$group_id) return false;
		$res = $this->db->from('group')
						->where('id', $group_id)
						->get();
		if (mysqli_error()) {
			return false;
		} else {
			return $res->row();
		}
	}

	public function get_users($group_id, $role_id){
		if(!$group_id) return false;
		$res = $this->db->select("users.*")
						->from("users")
						->join("user_group_role", "users.id", "user_group_role.user_id")
						->where("user_group_role.group_id", $group_id)
						->where("user_group_role.role_id", $role_id)
						->get();
		if (mysqli_error()) {
			return false;
		} else {
			return $res;
		}				
	}

	public function get_group_quizzes($group_id){
		if(!$group_id) return false;
		$res = $this->db->select('quiz.id, quiz.name, quiz.date_added, group_quiz.date_added AS date_assigned')
						->from('quiz')
						->join('group_quiz', 'quiz.id = group_quiz.group_id')
						->where('group_quiz.group_id', $group_id)
						->order_by('group_quiz.date_added', 'desc')
						->get();
		if(mysqli_error()){
			return false;
		} else {
			return $res;
		}				
	}

	public function get_active_quizzes($group_id){
		if(!$group_id) return false;
		$res = $this->db->select('quiz.id, quiz.name, quiz.date_added, group_quiz.date_added AS date_assigned')
						->from('quiz')
						->join('group_quiz', 'quiz.id = group_quiz.group_id')
						->where('group_quiz.group_id', $group_id)
						->where('is_active', 1)
						->order_by('group_quiz.date_added', 'desc')
						->get();
		if(mysqli_error()){
			return false;
		} else {
			return $res;
		}
	}

}

?>
