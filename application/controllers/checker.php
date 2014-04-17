<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checker extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->model('quiz');
		$this->load->model('tour');
		$this->load->model('package');
		$this->load->model('user');

		if ($this->tank_auth->is_logged_in(FALSE) || !$this->tank_auth->is_logged_in()) {
			header('Location: /');
			exit;
		}
		$this->data['userinfo'] = $this->user->get_userdata($this->tank_auth->get_user_id());
		if ($this->data['userinfo']['role'] == 1) {
			redirect('/teacher');
		} elseif ($this->data['userinfo']['role'] == 2) {
			redirect('/student');
		} else {
			redirect('/');
		}
	}


}
