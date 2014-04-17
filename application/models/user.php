<?php

class User extends CI_Model {

	function __construct ( ) {
		parent::__construct();
	}

	public function get_userdata($user_id) {
		if (!$user_id) return false;
		$this->db->where('id', $user_id)->from('users')->limit(1);
		$rez = $this->db->get();

		if (mysqli_error()) {
			return false;
		} else {
			$ret = $rez->row_array();
			# get extra stuff here
			$ret['role'] = $this->db->select('role_id')->from('users_roles')->where('user_id', $user_id)->get()->row()->role_id;
			return $ret;
		}
	}

	public function get_groups($user_id){
		if(!$user_id) return false;
		$res = $this->db->select('group.id, group.name, user_group_role.role_id')
						->from('user_group_role')
						->join('group', 'user_group_role.group_id = group.id')
						->where('user_id', $user_id)
						->get();
		if(mysqli_error()){
			return false;
		} else {
			return $res->result();
		}
	}

	public function get_group_role($user_id, $group_id){
		if(!$user_id  || !$group_id) return false;
		$res = $this->db->select('roles.id, roles.role_name')
						->from('user_group_role')
						->join('roles', 'user_group_role.role_id = roles.id')
						->where('user_group_role.user_id', $user_id)
						->where('user_group_role.group_id', $group_id)
						->get();
		if(mysqli_error()){
			return false;
		} else {
			return $res->result();
		}
	}

	public function get_group_quizzes($user_id, $group_id){
		if(!$user_id || !$group_id) return false;
		$res = $this->db->select('quiz.id, quiz.name, quiz.date_added, group_quiz.date_added AS date_assigned')
						->from('quiz')
						->join('group_quiz', 'quiz.id = group_quiz.group_id')
						->join('user_group_role', 'group_quiz.group_id = user_group_role.group_id')
						->where('user_group_role.user_id', $user_id)
						->where('group_quiz.group_id', $group_id)
						->order_by('group_quiz.date_added', 'desc')
						->get();
		if(mysqli_error()){
			return false;
		} else {
			return $res->result();
		}
	}

	public function get_group_active_quizzes($user_id, $group_id){
		if(!$user_id || !$group_id) return false;
		$res = $this->db->select('quiz.id, quiz.name, quiz.date_added, group_quiz.date_added AS date_assigned')
						->from('quiz')
						->join('group_quiz', 'quiz.id = group_quiz.group_id')
						->join('user_group_role', 'group_quiz.group_id = user_group_role.group_id')
						->where('group_quiz.is_active', 1)
						->where('user_group_role.user_id', $user_id)
						->where('group_quiz.group_id', $group_id)
						->order_by('group_quiz.date_added', 'desc')
						->get();
		if(mysqli_error()){
			return false;
		} else {
			return $res->result();
		}
	}

	public function set_role($user_id, $role_id) {
		$this->db->query("INSERT IGNORE into users_roles SET user_id = ?, role_id = ?", array($user_id, $role_id));
		return;
	}
	
	public function set_extra($user_id, $first_name, $last_name, $email='') {
		if ($email != '') {
			$this->db->query("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE id = ?", array($first_name, $last_name, $email, $user_id));
		} else {
			$this->db->query("UPDATE users SET first_name = ?, last_name = ? WHERE id = ?", array($first_name, $last_name, $user_id));
		}
		return;
	}

	public function list_students() {
		$rez = $this->db->query("SELECT * FROM users_roles UR 
			LEFT JOIN users U ON UR.user_id = U.id WHERE UR.role_id = 2 AND U.id IS NOT NULL");
		return $rez->result_array();
	}
	
	public function list_classes_for_teacher($teacher_id) {
		return $this->db->select('*')->from('classes')->where('creator_user_id', $teacher_id)->order_by('end_date')->get()->result_array();
	}
	
	public function list_packages_for_teacher($teacher_id) {
		return $this->db->select('*')->from('package')->where('creator_user_id', $teacher_id)->order_by('name')->get()->result_array();
	}
	
	public function list_classes($creator_user_id) {
		$rez = $this->db->query("SELECT C.*, 
		( SELECT COUNT(*) from classes_students CS WHERE CS.class_id =  C.id ) studentcount
		FROM classes C WHERE C.creator_user_id = ?", $creator_user_id);
		return $rez->result_array();
	}

	public function list_quizbanks($user_id='') {
		$myquery = $this->db->select('*')->from('quiz')
					->join('question', 'quiz.id = question.quiz_id', 'left')
					->group_by('quiz_id');
		if ($user_id != '') {
			$myquery->where('quiz.user_id', $user_id);
		}
		$rez = $myquery->get();
		#$rez = $this->db->query("SELECT * FROM quiz LEFT JOIN question ON quiz.id = question.quiz_id GROUP BY quiz.id");
		return $rez->result_array();
	}
	
	public function get_student_info($student_id) {
		return $this->db->select('*')->from('users')->where('id',$student_id)->get()->row_array();
	}
	
	public function list_assignments($creator_user_id) {
		$rez = $this->db->query("SELECT A.package_id, A.id assignment_id, P.name packagename, A.name assignmentname, C.id classid, C.name classname, 
					A.start_date asstartdate, A.end_date asenddate FROM assignments A 
					LEFT JOIN assignments_classes AC ON A.id = AC.assignment_id 
					LEFT JOIN classes C ON AC.class_id = C.id
					LEFT JOIN package P on A.package_id = P.id
					WHERE A.creator_user_id = ?", $creator_user_id);
		return $rez->result_array();
	}
	
	public function get_grades_for_classes($assignments) {
	}

	public function list_student_assignments($user_id) {
		$rez = $this->db->query("SELECT * FROM classes_students CS LEFT JOIN classes C ON CS.class_id = C.id 
			LEFT JOIN assignments_classes AC ON C.id = AC.class_id LEFT JOIN assignments A ON AC.assignment_id = A.id 
			WHERE CS.student_id = ?", $user_id);
		return $rez->result_array();
	}
	
	public function create_class($data) {
		$this->db->insert('classes', $data); 
		$newid = mysql_insert_id();
		return $newid;
	}

	public function delete_class($del_id) {
		$this->db->query('DELETE FROM classes WHERE id = ? LIMIT 1', $del_id);
		return true;
	}

	public function update_class($data, $class_id) {
		$this->db->where('id', $class_id)->update('classes', $data); 
		return true;
	}

	public function delete_student($del_id) {
		$this->db->query('DELETE FROM users WHERE id = ? LIMIT 1', $del_id);
		$this->db->query('DELETE FROM users_roles WHERE user_id = ? ', $del_id);
		return true;
	}
	
	public function update_assignment($data, $assignmentid) {
		$this->db->where('id', $assignmentid)->update('assignments', $data); 
		return true;
	}

	public function create_assignment($data) {
		$this->db->insert('assignments', $data); 
		$newid = mysql_insert_id();
		return $newid;
	}

	public function assign_class($classid, $assignmentid) {
		$this->db->query('DELETE FROM assignments_classes WHERE assignment_id = ?', $assignmentid);
		$this->db->query('INSERT INTO assignments_classes SET assignment_id = ?, class_id = ?', array($assignmentid, $classid));
		return true;
	}

	public function enrolled_classes($user_id) {
		$rez = $this->db->query("SELECT * FROM classes C  LEFT JOIN classes_students S ON S.class_id = C.id WHERE S.student_id = ?", $user_id);
		return $rez->result_array();
	}
	
	public function available_classes($user_id) {
		$rez = $this->db->query("SELECT * FROM classes C2 WHERE end_date > NOW() AND ID NOT IN( SELECT C.id FROM classes C  LEFT JOIN classes_students S ON S.class_id = C.id WHERE S.student_id = ? )", $user_id);
		return $rez->result_array();
	}
	
	public function add_class_for_user($classtoadd, $user_id) {
		$mycount = $this->db->select('COUNT(*) count')->from('classes_students')->where('student_id', $user_id)->where('class_id', $classtoadd)->get()->row()->count;
		if ($mycount == 0) {
			$xdata = array('class_id' => $classtoadd, 'student_id' => $user_id);
			$this->db->insert('classes_students',$xdata);
			return true;
		} else {
			return false;
		}
	}
	
	public function remove_class_for_user($classtoadd, $user_id) {
		$this->db->query('DELETE FROM classes_students WHERE student_id = ? AND class_id = ? LIMIT 1', array($user_id, $classtoadd));
		return true;
	}

	public function usercount() {
		return $this->db->query('SELECT COUNT(*) count FROM users')->row()->count;
	}
	
}
