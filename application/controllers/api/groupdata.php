<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';

class GroupData extends REST_Controller {
	public function __construct( ){
		parent::__construct();
		$this->load->model('group');
	}

	public function id_get($group_id){
		if($group_id && is_numeric($group_id)){
			$res = $this->group->get_groupdata($group_id);
			if(!$res){
				$data["error"] = "Error retrieving data";
			} else {
				$data["group"] = $res;
			}
			$this->response($data, 200);
		}
	}

	public function users_get($group_id, $role_id){
		if($group_id && is_numeric($group_id)){
			$res = $this->group->get_users($group_id, $role_id);
			if(!$res){
				$data["error"] = "Error retrieving data";
			} else {
				$data["users"] = $res->result();
			}
			$this->response($data, 200);
		}
	}

	public function quizzes_get($group_id){
		if($group_id && is_numeric($group_id)){
			$res = $this->group->get_group_quizzes($group_id);

			if(!$res){
					$data["error"] = "Error retrieving data";
			} else {
				$data["quizzes"] = $res->result();
			}
			$this->response($data, 200);
		}
	}

	public function active_quizzes_get($group_id){
		if($group_id && is_numeric($group_id)){
			$res = $this->group->get_active_quizzes($group_id);

			if(!$res){
					$data["error"] = "Error retrieving data";
			} else {
				$data["quizzes"] = $res->result();
			}
			$this->response($data, 200);
		}
	}
}
?>
