<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Display extends CI_Controller {
	public function __construct(  )
	{
		parent::__construct();
		$this->load->model('package');
		$this->load->model('user');
		$this->load->model('quiz');

#		if ($this->tank_auth->is_logged_in(FALSE) || !$this->tank_auth->is_logged_in()) {
#			header('Location: /auth/login/');
#			exit;
#		}

		$this->data['userinfo'] = $this->user->get_userdata($this->tank_auth->get_user_id());

	}

	public function index($package_id)
	{
#		print "<pre>";
#		print_r($this->data['userinfo']);
#		print "</pre>";
		
		$this->data['user_key'] = $this->data['userinfo']['id'].$package_id.
		
		$this->data['package_id'] = $package_id;
		$this->data['package'] = $this->package->getInfo($package_id);
		if (!$this->data['package']['tour_scene_id'] && $this->data['package']['othermedia_id']) {
			$this->previewother($package_id);
		} else {
			$this->load->view('display/index', $this->data);
		}
	}

	public function assignment($assignment_id)
	{
		$this->data['package_id'] = $this->quiz->get_quiz_from_assignment_id($assignment_id);
		if (!$this->data['package_id']) redirect('/student');
		
		$this->data['user_key_seed'] = $this->data['userinfo']['id'].$assignment_id.$this->data['package_id'].$this->data['userinfo']['created'];
		$this->data['package'] = $this->package->getInfo($this->data['package_id']);

		$this->data['is_current_assignment'] = $this->quiz->is_current_assignment($assignment_id);
		$this->data['is_valid_student'] = $this->quiz->is_valid_student($this->data['userinfo']['id'],$assignment_id);
		if ($this->data['is_valid_student'] && $this->data['is_current_assignment'] && is_numeric($this->data['package_id'])) {
			$this->load->view('display/index', $this->data);
		} else {
			redirect('/student');
		}
		
	}

	public function preview($package_id)
	{
		$this->data['package_id'] = $package_id;
		$this->data['package'] = $this->package->getInfo($package_id);
		$this->data['preview'] = 1;
		if (!$this->data['package']['tour_scene_id'] && $this->data['package']['othermedia_id']) {
			$this->previewother($package_id);
		} else {
			$this->load->view('display/index', $this->data);
		}
	}
	
	public function previewother($package_id) {
		$this->data['package_id'] = $package_id;
		$this->load->model('media');
		$this->data['package'] = $this->media->getPkgInfoFromPkgId($package_id);
		$this->data['items'] = $this->package->getQuestionsSorted($package_id);
		$this->data['hotspots'] = $this->package->getHotspots($package_id);
#		print "<!-- ";
#		print_r($this->data['hotspots']);
#		print_r($this->data['items']);
#		print " -->";
		$this->data['preview'] = 1;
		$this->load->view('display/indexother', $this->data);
	}
}
