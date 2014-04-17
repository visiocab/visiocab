<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->model('user');

		if ($this->tank_auth->is_logged_in(FALSE) || !$this->tank_auth->is_logged_in()) {
			header('Location: /auth/login/manager');
			exit;
		}
		$this->data['userinfo'] = $this->user->get_userdata($this->tank_auth->get_user_id());
		if ($this->data['userinfo']['role'] != 1) {
			redirect('/');
		}

	}

	public function index() {
		$this->layout->show('account', $this->data);
	}

}