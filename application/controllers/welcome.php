<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->model('quiz');
		$this->load->model('tour');
		$this->load->model('package');
		$this->load->model('user');

		if ($this->tank_auth->is_logged_in(TRUE) || $this->tank_auth->is_logged_in()) {
#			header('Location: /auth/login/');
#			exit;
			$this->data['userinfo'] = $this->user->get_userdata($this->tank_auth->get_user_id());
			if ($this->data['userinfo']['role'] == 1) {
				#redirect('/teacher');
			} elseif ($this->data['userinfo']['role'] == 2) {
				$this->layout->template('mainstudent');
				redirect('/student');
			} else {
				redirect('/');
			}
		}
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$usercount = $this->user->usercount();
		if (!$usercount) {
			redirect('/install');
		}
		$this->layout->template('front');
		$this->layout->show('frontpage', $this->data);
	}

	public function login() {
		$this->layout->template('wlogin');

		$this->data['message'] = $_GET['msg'];
		$this->layout->show('loginpage', $this->data);
	}

	public function register() {
		$this->layout->template('wlogin');
		$this->layout->show('registerpage', $this->data);
	}

	public function disclaimer() {
		$this->layout->template('wlogin');
		$this->layout->show('disclaimerpage', $this->data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
