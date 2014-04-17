<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class QuizData extends REST_Controller {
	public function __construct( ){
		parent::__construct();
		$this->load->model('quiz');
	}

	public function info_get($quiz_id){
		if($quiz_id && is_numeric($quiz_id)){
			$res = $this->quiz->getQuizInfo($quiz_id);
			if($res){
				$data["quiz_info"] = $res;
			} else {
				$data["quiz_info"] = array();
			}
			$this->response($data, 200);
		}
	}

	public function addqset_post() {
		if ($this->input->post('newname')) {
			$data['success'] = $this->quiz->new_quiz($this->input->post('newname'));
			$this->response($data, 200);
		} else {
			return false;
		}
	}

	public function is_authorized_get($quiz_id, $user_id){
		if($quiz_id && is_numeric($quiz_id) && $user_id && is_numeric($user_id)){
			$res = $this->quiz->is_user_authorized($quiz_id, $user_id);
			$this->response($res, 200);
		}
	}

	public function scenes_get($quiz_id){
		if($quiz_id && is_numeric($quiz_id)){
			$res['scenes'] = $this->quiz->quiz_scenes($quiz_id);
			$this->response($res, 200);
		}
	}

	public function question_scenes_get($question_id){
		if($question_id && is_numeric($question_id)){
			$res['scenes'] = $this->quiz->question_scenes($question_id);
			$this->response($res, 200);
		}
	}

}

?>
