<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class UserData extends REST_Controller {
	public function __construct( ){
		parent::__construct();
		$this->load->model('user');
	}

	public function id_get($user_id){
		if($user_id && is_numeric($user_id)){
			$res = $this->user->get_userdata($user_id);

			if(!$res){
				$data["error"] = "Error retrieving data";
			} else {
				$data["user"] = $res;
			}
			$this->response($data, 200);
		}
	}

	public function groups_get($user_id){
		if($user_id && is_numeric($user_id)){
			$res = $this->user->get_groups($user_id);
			if($res){
				$data["groups"] = $res;
			} else {
				$data["groups"] = [];
			}
			$this->response($data, 200);
		}
	}

	public function group_role_get($user_id, $group_id){
		if($user_id && is_numeric($user_id) && $group_id && is_numeric($group_id)){
			$res = $this->user->get_group_role($user_id, $group_id);
			if($res){
				$data["roles"] = $res;
			} else {
				$data["roles"] = [];
			}
			$this->response($data, 200);
		}
	}

	public function group_quizzes_get($user_id, $group_id){
		if($user_id && is_numeric($user_id) && $group_id && is_numeric($group_id)){
			$res = $this->user->get_group_quizzes($user_id, $group_id);
			if($res){
				$data["quizzes"] = $res;
			} else {
				$data["quizzes"] = [];
			}
			$this->response($data, 200);
		}
	}

	public function group_active_quizzes_get($user_id, $group_id){
		if($user_id && is_numeric($user_id) && $group_id && is_numeric($group_id)){
			$res = $this->user->get_group_active_quizzes($user_id, $group_id);
			if($res){
				$data["quizzes"] = $res;
			} else {
				$data["quizzes"] = [];
			}
			$this->response($data, 200);
		}
	}
	
}
	
?>
