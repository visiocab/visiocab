<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';
class Ajax extends REST_Controller {

	public function __construct(  )
	{
		parent::__construct();
		$this->load->model('package');
		$this->load->model('user');
		$this->load->model('quiz');
	}

	public function saveProgress_post(){
		$newvalues = array();
		if (!empty($_POST['theinfo'])) {
			$itemarray = json_decode($_POST['theinfo'],true);
			#foreach ($mything as $k=> $v) {
				#print_r(json_decode($v,true));
			#}
			$q_order = 1;
			foreach ($itemarray as $thisitemdata) {
				$thisitem = json_decode($thisitemdata,true);
				if ($thisitem['id']) {
	#				print "INSERT INTO quiz_tour SET tour_id = ?, quiz_id = ?, question_id = ?, pan = ?, tilt = ?, question_order = ? <br />";
	#				print $_POST['tourid'].", ".$_POST['quizid'].", ".$question_id.", ".$_POST['panvals'][$question_id].", ".$_POST['tiltvals'][$question_id].", ".$q_order."<br />";
					$newvalues[] = array(
						'id' => '', 
						'package_id' => $_POST['package_id'], 
						'question_id' => $thisitem['id'], 
						'pan' => $thisitem['pan'], 
						'tilt' => $thisitem['tilt'], 
						'coordx' => $thisitem['x'], 
						'coordy' => $thisitem['y'], 
						'nexttext' => $thisitem['aftertext'],
						'date_added' => date('Y-m-d H:i:s'), 
						'question_order' => $q_order
					);
					$q_order++;
				
				}
			}
		}
		$rez = $this->package->saveTourQuiz($_POST['package_id'], $newvalues);
		if (!$rez) {
			$data['success'] = "success";
		} else {
			$data['error'] = $rez;
		}
		
		$this->response($data, 200);
		
		
#		print_r($newvalues);
	}
	
	public function allQuestions_get($package_id) {
		$data = $this->package->getQuestionsSorted($package_id);
		$this->response($data, 200);
		
	}
	
	public function checkQuestion_post() {
		$this->load->model('quiz');
		// is the provided key valid?
		$valid_key = $this->quiz->is_valid_key($this->input->post('key'));
		$theanswer = $this->quiz->checkQuizAnswer($this->input->post('packageid'), $this->input->post('question'));
		$useranswer = $this->quiz->getUserAnswer($this->input->post('packageid'), $this->input->post('question'), $this->input->post('answer'));

		if (empty($valid_key['student_id']) || empty($valid_key['assignment_id']) || empty($valid_key['package_id'])) {
			$data['incorrect'] = true;
			$data['realcorrect'] = 'incorrect data. yer killin me, smalls';
			$this->response($data, 200);
			exit;
		}
		// is this question already answered?
		$myqnum = $this->quiz->get_question_id_from_ajax($valid_key['package_id'], $this->input->post('question'));
		
		$is_answered = $this->quiz->is_question_answered($myqnum, $valid_key['assignment_id'], $valid_key['student_id']);
		// if yes, return that as an error
		if ($is_answered) {
			$data['alreadyanswered'] = true;
			$data['wasitcorrect'] = ($theanswer['correct_selection'] == $useranswer)? 'correct' : 'incorrect';
			$this->response($data, 200);
			exit;
		}
		// if no, continue
		// is it correct?
		

		// store the result 
		$this->quiz->record_answer($valid_key['student_id'], $valid_key['assignment_id'], $valid_key['package_id'], $theanswer['question_id'], $this->input->post('answer'), $useranswer);
		
		if ($theanswer['correct_selection'] == $this->input->post('answer')) {
			$data['correct'] = true;
		} else {
			$data['incorrect'] = true;
			$data['realcorrect'] = $theanswer;
		}
		$data['nexttext'] = $theanswer['nexttext'];
		if ($this->quiz->isQuizFinished($this->input->post('packageid'), $this->input->post('question'))) {
			$data['is_finished'] = 1;
		}
		$this->response($data, 200);
	}
	
	public function checkQuestionPreview_post() {
		$this->load->model('quiz');
		// is the provided key valid?

		$infobox = $this->quiz->isInfoBox($this->input->post('packageid'), $this->input->post('question'));
		
		$theanswer = $this->quiz->checkQuizAnswer($this->input->post('packageid'), $this->input->post('question'));

		$useranswer = $this->quiz->getUserAnswer($this->input->post('packageid'), $this->input->post('question'), $this->input->post('answer'));
		$userresponse = $this->quiz->getUserResponse($this->input->post('packageid'), $this->input->post('question'), $this->input->post('answer'));

#		if (empty($valid_key['student_id']) || empty($valid_key['assignment_id']) || empty($valid_key['package_id'])) {
#			$data['incorrect'] = true;
#			$data['realcorrect'] = 'incorrect data. yer killin me, smalls';
#			$this->response($data, 200);
#			exit;
#		}
		// is this question already answered?
#		$myqnum = $this->quiz->get_question_id_from_ajax($valid_key['package_id'], $this->input->post('question'));
		
#		$is_answered = $this->quiz->is_question_answered($myqnum, $valid_key['assignment_id'], $valid_key['student_id']);
		// if yes, return that as an error
#		if ($is_answered) {
#			$data['alreadyanswered'] = true;
#			$data['wasitcorrect'] = ($theanswer['correct_selection'] == $useranswer)? 'correct' : 'incorrect';
#			$this->response($data, 200);
#			exit;
#		}
		// if no, continue
		// is it correct?
		

		// store the result 
#		$this->quiz->record_answer($valid_key['student_id'], $valid_key['assignment_id'], $valid_key['package_id'], $theanswer['question_id'], $this->input->post('answer'), $useranswer);
		
		if ($infobox['isinfobox']) {
			$data['correct'] = true; 
			$data['nexttext'] = $infobox['nexttext'];
			$data['isinfo'] = 1;
		} elseif ($theanswer['correct_selection'] == $this->input->post('answer')) {
			$data['correct'] = true;
			$data['nexttext'] = $userresponse;
		} else {
			$data['incorrect'] = true;
			$data['realcorrect'] = $theanswer;
			$data['nexttext'] = $userresponse;
		}
		if ($this->quiz->isQuizFinished($this->input->post('packageid'), $this->input->post('question'))) {
			$data['is_finished'] = 1;
		}
		$this->response($data, 200);
	}	

	public function Assignment_post() {
		$xdata = array(
			'name' => $this->input->post('assignmentname'),
			'start_date' => date('Y-m-d', strtotime($this->input->post('startdate'))),
			'end_date' => date('Y-m-d', strtotime($this->input->post('enddate'))),
			'package_id' => $this->input->post('package_id'),
			'creator_user_id' => $this->input->post('user_id')
		);
		if ($this->input->post('assignment_id')) {
			$this->user->update_assignment($xdata, $this->input->post('assignment_id'));
			$this->user->assign_class($this->input->post('class_id'), $this->input->post('assignment_id'));
			$newid = $this->input->post('assignment_id');
		} else {
			$newid = $this->user->create_assignment($xdata);
			$this->user->assign_class($this->input->post('class_id'), $newid);
		}
		$data['success'] = $newid;
		$this->response($data, 200);
	}
	
	public function Assignment_delete($idtodelete) {
		$this->package->delete_assignment($idtodelete);
		$data['success'] = 1;
		$this->response($data, 200);
	}
	
	public function Class_post() {
		$xdata = array(
			'name' => $this->input->post('classname'),
			'start_date' => date('Y-m-d', strtotime($this->input->post('startdate'))),
			'end_date' => date('Y-m-d', strtotime($this->input->post('enddate'))),
			'creator_user_id' => $this->input->post('user_id')
		);
		if ($this->input->post('class_id')) {
			$this->user->update_class($xdata, $this->input->post('class_id'));
			$newid = $this->input->post('class_id');
		} else {
			$newid = $this->user->create_class($xdata);
		}
		$data['success'] = $newid;
		$this->response($data, 200);
	}
	
	public function Class_delete($idtodelete) {
		$this->user->delete_class($idtodelete);
		$data['success'] = 1;
		$this->response($data, 200);
	}

	public function Student_delete($idtodelete) {
		$this->user->delete_student($idtodelete);
		$data['success'] = 1;
		$this->response($data, 200);
	}

	public function Package_delete($idtodelete) {
		$this->package->delete_package($idtodelete);
		$data['success'] = 1;
		$this->response($data, 200);
	}
	
	public function Quizbank_post() {
		$xdata = array(
			'name' => $this->input->post('name'),
		);

		$this->quiz->update_quizbank($xdata, $this->input->post('quiz_id'));
		$data['success'] = 1;
		$this->response($data, 200);
	}

	public function Quizbank_delete($idtodelete) {
		$this->quiz->delete_quizbank($idtodelete);
		$data['success'] = 1;
		$this->response($data, 200);
	}
	
	public function Visiocabs_get($user_id) {
		$data['payload'] = $this->user->list_packages_for_teacher($user_id);
		$this->response($data, 200);
	}
	
	public function Classes_get($user_id) {
		$data['payload'] = $this->user->list_classes_for_teacher($user_id);
		$this->response($data, 200);
	}

	public function Question_post($question_id) {
			$questiondata = array(
			'quiz_id' => $this->input->post('quiz_id'),
			'qtext' => $this->input->post('qtext'),
			'qtype' => $this->input->post('qtype'),
			'date_added' => date('Y-m-d H:i:s')
		);
		$answerdata = array();
		$anscounter = 1;
		if ($question_id) {
			// update
#			error_log('updating');
			$questiondata['id'] = $question_id;
			$result = $this->quiz->updateQuestion($questiondata);
		} else {
			//create
#			@error_log('creating');
			$result = $this->quiz->storeQuestion($questiondata);
		}
#		@error_log(print_r($this->input->post('answeroptions'), true));
		
		$responses = array();
		$respnum = 1;
		foreach($this->input->post('responseoptions') as $resp) {
			$responses[$respnum] = $resp;
			$respnum++;
		}

		foreach ($this->input->post('answeroptions') as $ans) {
#			@error_log('adding '.$ans);
			
			$is_correct = ($ans == $this->input->post('correctanswer'))? '100' : '0';
			$answerdata[] = array(
				'question_id' => $result,
				'aorder' => $anscounter,
				'correct' => $is_correct,
				'atext' => $ans,
				'response' => ($responses[$anscounter])? $responses[$anscounter] : '',
				'date_added' => date('Y-m-d H:i:s')
			);
			$anscounter++;
		}
#		@error_log('starting, '.print_r($answerdata,true));
		
		$this->quiz->answersForQuestion($result, $answerdata);
#		@error_log('ending'.mysql_error());
		if ($result) {
			$this->response(array('success' => $result, 'location'=>'/ajax/Question/'.$result), 201);
		} else {
			$this->response(NULL, 404);
		}
	}

	public function Question_delete($idtodelete) {
		$deleteresult = $this->quiz->delete_question($idtodelete);
		if (!$deleteresult) {
			$this->response(array(), 204);
		} else {
			$this->response(array(), 404);
		}
	}
	
	public function Answer_delete($idtodelete) {
		$deleteresult = $this->quiz->delete_answer($idtodelete);
		if (!$deleteresult) {
			$this->response(array(), 204);
		} else {
			$this->response(array(), 404);
		}
	}

	public function Tag_post($tagid) {
		$this->load->model('tag');
		$result = $this->tag->add($tagid, $this->input->post('package_id'));
		$this->response(NULL, 200);
	}
	
	public function TagDel_post($tagid) {
		$this->load->model('tag');
		$result = $this->tag->delete($tagid, $this->input->post('package_id'));
		$this->response(NULL, 200);
	}
	
	public function visiocab_put($id, $setval) {
		$newval = ($setval == 'true')? 1 : 0;
		if ($this->package->setpublic($id, $newval)) {
			$this->response(NULL, 404);
		} else {
			$this->response(NULL, 200);
		}
	}

	public function visiocab_delete($id) {
		$this->package->remove($id);
		$this->response(NULL, 204);
	}
}
