<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct()
	{
		parent::__construct();

		$this->load->model('quiz');
		$this->load->model('tour');
		$this->load->model('package');
		$this->load->model('user');
		$this->load->model('media');

		if ($this->tank_auth->is_logged_in(FALSE) || !$this->tank_auth->is_logged_in()) {
			header('Location: /auth/login/manager');
			exit;
		}
		$this->data['userinfo'] = $this->user->get_userdata($this->tank_auth->get_user_id());
		if ($this->data['userinfo']['role'] != 1) {
			redirect('/');
		}
	}

	public function index()
	{
#		$this->load->view('admin/index');
		$this->data['current_packages'] = $this->package->listPackages($this->data['userinfo']['id']);
		$this->layout->show('teachers/index', $this->data);

	}

	public function import() {
		$this->data['errors'] = '';
		$config = array(
		        'upload_path' => '/vhosts/lms/upload',
		        'allowed_types' => 'xml'
		    );

	    $this->load->library('upload', $config);

		$this->load->helper('form');

		if (!empty($_FILES)) {
			$x = file_get_contents($_FILES['xml_upload']['tmp_name']);
			$x = preg_replace('/’/', "'", $x);
			$xml = new SimpleXMLElement($x);
		
			if (!empty($xml)) {
				$quiz_id = $this->quiz->startQuiz($_POST['quizname'], $this->data['userinfo']['id']);
		
				$mquestions = $xml->xpath('//quiz/question[@type="multichoice"]');

				foreach ($mquestions as $k=>$v) {
					$thisqdata = array(
						'quiz_id' => $quiz_id,
						'qtext' => "{$v->{'questiontext'}->{'text'}}", 
						'qtype' => 'multichoice', 
						'date_added' => date('Y-m-d H:i:s')
					);
					$qid = $this->quiz->storeQuestion($thisqdata);
					$ord = 1;
					$ansdata = array();
					foreach ($v->{'answer'} as $ans) {
						$ansdata[] = array(
							'question_id' => $qid,
							'aorder' => $ord,
							'atext' => "{$ans->{'text'}}", 
							'correct' => $ans['fraction'],
							'date_added' => date('Y-m-d H:i:s')
						);
						$ord++;
					}
					$this->quiz->storeAnswers($ansdata);
				}
		
				$tquestions = $xml->xpath('//quiz/question[@type="truefalse"]');

				foreach ($tquestions as $k=>$v) {
					$thisqdata = array(
						'quiz_id' => $quiz_id,
						'qtext' => "{$v->{'questiontext'}->{'text'}}", 
						'qtype' => 'truefalse', 
						'date_added' => date('Y-m-d H:i:s')
					);
					$qid = $this->quiz->storeQuestion($thisqdata);
					$ord = 1;
					$ansdata = array();
					foreach ($v->{'answer'} as $ans) {
						$ansdata[] = array(
							'question_id' => $qid,
							'aorder' => $ord,
							'atext' => "{$ans->{'text'}}", 
							'correct' => $ans['fraction'],
							'date_added' => date('Y-m-d H:i:s')
						);
						$ord++;
					}
					$this->quiz->storeAnswers($ansdata);
				}
				$this->session->set_flashdata( 'message', array('text' => "File successfully imported.", 'newid' => $quiz_id));
				#redirect('/teacher/managequizbanks');
				redirect('/admin/start');
			}
		}
		$this->layout->show('admin/import',$this->data);
	}

	public function importm() {
		$this->data['errors'] = '';
		$config = array(
		        'upload_path' => '/vhosts/lms/upload',
		        'allowed_types' => 'jpg'
		    );

	    $this->load->library('upload', $config);

		$this->load->helper('form');

		if (!empty($_FILES)) {
			if (is_file($_FILES['img_upload']['tmp_name'])) {
				$newname = preg_replace('/[^a-zA-Z0-9]/', '', $_POST['imgname']);
				if (is_file($_SERVER['DOCUMENT_ROOT'].'/othermdeia/'.$newname.'.jpg')) {
					$counter = 1;
					while (is_file($_SERVER['DOCUMENT_ROOT'].'/othermdeia/'.$newname.$counter.'.jpg')) {
						$counter++;
					}
					$newname .= $counter;
				}
				move_uploaded_file($_FILES['img_upload']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/othermdeia/'.$newname);
				$new_id = $this->media->insertmedia($newname, $_POST['imgname']);
				$this->session->set_flashdata( 'message', "File successfully imported.");

			}
			
		}
		$this->layout->show('admin/importm',$this->data);
	}

	
	public function start() {
		#this page picks the quiz_id and pano_id that are sent to dragdrop()
		#get list of tours

		$this->data['quizzes'] = $this->quiz->getAllQuizzes($this->data['userinfo']['id']);
		$this->data['tours'] = $this->tour->getAllTours();
		$this->data['othermedia'] = $this->media->get_other_media($this->data['userinfo']['id']);
		$this->data['message'] = $this->session->flashdata('message');
		
		$this->layout->show('admin/start',$this->data);
	}
	
	public function setup() {
		if (!empty($_POST)) {
			ini_set("upload_max_filesize", "100M");

			if (is_uploaded_file($_FILES['newmedia']['tmp_name'])) {

				$counter = '';
				preg_match('/^(.*)(\....)$/', $_FILES['newmedia']['name'], $matches);
				$main = $matches[1];
				$suffix = $matches[2];
				while(is_file($_SERVER['DOCUMENT_ROOT'].'/othermedia/'.$main.$count.$suffix)) {
					$count++;
				}
				move_uploaded_file($_FILES['newmedia']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/othermedia/'.$main.$count.$suffix);
				$othermedia_id = $this->media->insertmedia($main.$count.$suffix, $_POST['name'], $this->data['userinfo']['id']);
			}
			$newquiz = $this->quiz->copyQuestionSet($_POST['quiz'], $_POST['name'], $this->data['userinfo']['id']);
			if ($othermedia_id) {
				$this->data['package_id'] = $this->package->selectPackage($newquiz, $othermedia_id, $this->data['userinfo']['id'], $_POST['name'],1);
			} else {
				$this->data['package_id'] = $this->package->selectPackage($newquiz, $_POST['whichtour'], $this->data['userinfo']['id'], $_POST['name'],$_POST['isothermedia']);
			}
			$rez = $this->package->getInfo($this->data['package_id']);
			redirect('/admin/dragdrop/'.$this->data['package_id']);
			exit;
		}
	}
	
	public function dragdrop($package_id) {
		#$this->data['package_id'] = $this->package->selectPackage($quiz_id, $pano_id, $this->data['userinfo']['id']);
		$pkg = $this->package->getFromPackage($package_id);
		
		$this->data['package_id'] = $package_id;
		$this->data['quiz_id'] = $pkg['quiz_id'];
		$this->data['tour_id'] = $pkg['tour_scene_id'];
		$this->data['quiz'] = $this->quiz->getQuizInfo($pkg['quiz_id']);
		$this->data['quizname'] = $this->quiz->getQuizName($pkg['quiz_id']);
		$this->data['package'] = $this->package->getPackageInfo($package_id);
		$this->load->model('tag');
		$this->data['tags'] = $this->tag->getTags($package_id);
		if ($pkg['tour_scene_id']) {
			$this->data['packageinfo'] = $this->package->getInfo($package_id);
			$this->data['tour'] = $this->tour->getPanoInfo($pkg['tour_scene_id']);
		} elseif ($pkg['othermedia_id']) {
			$this->data['packageinfo'] = $this->media->getPkgInfo($pkg['othermedia_id']);
			$this->data['tour'] = $this->media->getOtherInfo($pkg['othermedia_id']);
		}
		$this->layout->show('admin/dragdrop', $this->data);
	}

	public function dragdropper($package_id) {
		#$this->data['package_id'] = $this->package->selectPackage($quiz_id, $pano_id, $this->data['userinfo']['id']);
		$pkg = $this->package->getFromPackage($package_id);

		$this->data['package_id'] = $package_id;
#		print "<pre>";
#		print_r($pkg);
#		print "</pre>";
		$this->data['quiz_id'] = $pkg['quiz_id'];
		$this->data['tour_id'] = $pkg['tour_scene_id'];
		$this->data['quiz'] = $this->quiz->getQuizInfo($pkg['quiz_id']);
		$this->data['quizname'] = $this->quiz->getQuizName($pkg['quiz_id']);
		$this->data['package'] = $this->package->getPackageInfo($package_id);
		$this->data['packageinfo'] = $this->package->getInfo($package_id);
		$this->data['tour'] = $this->tour->getPanoInfo($pkg['tour_scene_id']);
		$this->layout->show('admin/dragdropper', $this->data);
	}

	public function assigntest() {

		$this->layout->show('admin/assigntest', $this->data);
	}
	
	public function adduser() {
		if ($this->input->post('username') != '') {
			$this->data['user'] = $this->tank_auth->create_user($this->input->post('username'), $this->input->post('email'), $this->input->post('password'), FALSE);
		}
		
		$this->layout->show('admin/adduser_form', $this->data);
	}

	public function editquiz($quizid, $backtopackage) {
		$this->data['quiz'] = $this->quiz->getQuizInfo($quizid);
		$this->data['backtopackage'] = $backtopackage;
		$this->data['quiz_id'] = $quizid;
		$this->layout->show('admin/editquiz', $this->data);
	}

	public function iframer($package_id) {
		$data['package_id'] = $package_id;
		$this->layout->show('admin/iframer', $data);
	}
}
