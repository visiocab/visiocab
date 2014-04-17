<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teacher extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->model('quiz');
		$this->load->model('tour');
		$this->load->model('package');
		$this->load->model('user');

		if ($this->tank_auth->is_logged_in(FALSE) || !$this->tank_auth->is_logged_in()) {
			header('Location: /auth/login/');
			exit;
		}
		$this->data['userinfo'] = $this->user->get_userdata($this->tank_auth->get_user_id());
		if ($this->data['userinfo']['role'] != 1) {
			redirect('/');
		}
	}

	public function index() {
		# this is just an alias for /admin now
		redirect('/admin');
		exit;
#		$this->data['current_packages'] = $this->package->listPackages($this->data['userinfo']['id']);
#		$this->data['assignments'] = $this->user->list_assignments($this->data['userinfo']['id']);
#		$this->data['classes'] = $this->user->list_classes($this->data['userinfo']['id']);
#		$this->layout->show('teachers/index', $this->data);
	}

	public function gradebook() {
		$this->data['assignments'] = $this->user->list_assignments($this->data['userinfo']['id']);
#		$this->data['grades'] = $this->user->get_grades_for_classes($this->data['assignments']);
		$this->layout->show('teachers/gradebook', $this->data);
	}

	public function managestudents() {
		$this->data['students'] = $this->user->list_students();
		$this->data['classes'] = $this->user->list_classes($this->data['userinfo']['id']);
		$this->layout->show('teachers/managestudents', $this->data);
	}

	public function manageclasses() {
#		$this->data['students'] = $this->user->list_students();
		$this->data['classes'] = $this->user->list_classes($this->data['userinfo']['id']);
		$this->data['assignments'] = $this->user->list_assignments($this->data['userinfo']['id']);
		$this->layout->show('teachers/manageclasses', $this->data);
	}
	
	public function managequizbanks() {
		$this->data['quizbanks'] = $this->user->list_quizbanks($this->data['userinfo']['id']);
		$this->data['message'] = $this->session->flashdata('message');
		$this->layout->show('teachers/managequizbanks', $this->data);
	}
	
	public function manageassignments() {
		$this->layout->show('teachers/manageassignments', $this->data);
	}
	
	public function editstudent($student_id) {
		if (!empty($_POST)) {
			if ($student_id) {
				#update first and last name
				$this->user->set_extra($student_id, $_POST['first_name'], $_POST['last_name'], $_POST['email']);
				# add this user to the "student" role
				$this->data['message'] = "User edited successfully. <a href=\"/teacher/managestudents\">Return to Manage Students</a>";
			}
		}
		$this->data['existinginfo'] = $this->user->get_student_info($student_id);
#		print_r($this->data['existinginfo']);
		$this->layout->show('teachers/addstudents', $this->data);
	}
	
	public function addstudents() {
		if (!empty($_POST)) {
			$rez = $this->tank_auth->create_user('', $_POST['email'], $_POST['password'], FALSE);
			if ($rez['user_id'] != '') {
				#update first and last name
				$this->user->set_extra($rez['user_id'], $_POST['first_name'], $_POST['last_name']);
				# add this user to the "student" role
				if ($_POST['is_teacher']) {
					$this->user->set_role($rez['user_id'], 1);
				} else {
					$this->user->set_role($rez['user_id'], 2);
				}
				$this->data['message'] = "User added successfully. <a href=\"/teacher/managestudents\">Return to Manage Students</a>";
			}
		}
		$this->layout->show('teachers/addstudents', $this->data);
	}
}
