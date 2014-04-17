<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Export extends CI_Controller {

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
	public function index($quiz_id)
	{
		$doc = new DomDocument('1.0', 'UTF-8');
		$this->load->model('quiz');
		$questions = $this->quiz->questions_for_export($quiz_id);
#		$answers33 = $this->quiz->answers_for_export(33);
		$quizname = $this->quiz->getQuizName($quiz_id);

#		print "<pre>";
#		print_r($quizname);
#		print_r($answers33);
#		print_r($questions);
#		print "</pre>";
#		exit;
		
		// create root node
		$root = $doc->createElement('quiz');
		$root = $doc->appendChild($root);


		# create the question
		$thisquestion = $doc->createElement('question');
		$thisquestion = $root->appendChild($thisquestion);

		# add a type attribute
		$thisquestiontype = $doc->createAttribute('type');
		$thisquestiontype->value = 'category';
		$thisquestion->appendChild($thisquestiontype);
		
		#the dirty work
		$category = $doc->createElement('category');
		$categorytext = $doc->createElement('text');
		$categorytextvalue = $doc->createCDATASection($quizname);
		$categorytext->appendChild($categorytextvalue);
		$category->appendChild($categorytext);
		$category = $thisquestion->appendChild($category);


		foreach ($questions as $qitem) {
			$answers = $this->quiz->answers_for_export($qitem['id']);
			####################################
			# adding a question
			####################################
			# create the question
			$thisquestion = $doc->createElement('question');
			$thisquestion = $root->appendChild($thisquestion);

			# add a type attribute
			$thisquestiontype = $doc->createAttribute('type');
			$thisquestiontype->value = $qitem['qtype'];
			$thisquestion->appendChild($thisquestiontype);

			#the dirty work
			$name = $doc->createElement('name');
			$nametext = $doc->createElement('text');
			$nametextvalue = $doc->createCDATASection($qitem['qtext']);
			$nametext->appendChild($nametextvalue);
			$name->appendChild($nametext);
			$name = $thisquestion->appendChild($name);

			$questiontext = $doc->createElement('questiontext');
			$questiontexttext = $doc->createElement('text');
			$questiontexttextformat = $doc->createAttribute('format');
			$questiontexttextformat->value = 'html';
			$questiontexttext->appendChild($questiontexttextformat);
			$questiontexttextvalue = $doc->createCDATASection($qitem['qtext']);
			$questiontexttext->appendChild($questiontexttextvalue);
			$questiontext->appendChild($questiontexttext);
			$questiontext = $thisquestion->appendChild($questiontext);
		
			$image = $doc->createElement('image');
		
			$generalfeedback = $doc->createElement('generalfeedback');
			$generalfeedbacktext = $doc->createElement('text');
			$generalfeedbacktext->appendChild($doc->createCDATASection('feedbacking'));
			$generalfeedback->appendChild($generalfeedbacktext);
		
			$thisquestion->appendChild($generalfeedback);
		
			$thisquestion->appendChild($doc->createElement('defaultgrade',1));
		
			$thisquestion->appendChild($doc->createElement('penalty',0.1));
		
			$thisquestion->appendChild($doc->createElement('hidden',0));
		
			$thisquestion->appendChild($doc->createElement('shuffleanswers',1));
		
			$thisquestion->appendChild($doc->createElement('single','true'));
		
			$thisquestion->appendChild($doc->createElement('shuffleanswers','true'));
		
			$correctfeedback = $doc->createElement('correctfeedback');
			$correctfeedbacktext = $doc->createElement('text');
			$correctfeedbacktext->appendChild($doc->createCDATASection('feedbacking'));
			$correctfeedback->appendChild($correctfeedbacktext);

			$thisquestion->appendChild($correctfeedback);

			$partiallycorrectfeedback = $doc->createElement('partiallycorrectfeedback');
			$partiallycorrectfeedbacktext = $doc->createElement('text');
			$partiallycorrectfeedbacktext->appendChild($doc->createCDATASection('feedbacking'));
			$partiallycorrectfeedback->appendChild($partiallycorrectfeedbacktext);

			$thisquestion->appendChild($partiallycorrectfeedback);

			$incorrectfeedback = $doc->createElement('incorrectfeedback');
			$incorrectfeedbacktext = $doc->createElement('text');
			$incorrectfeedbacktext->appendChild($doc->createCDATASection('feedbacking'));
			$incorrectfeedback->appendChild($incorrectfeedbacktext);

			$thisquestion->appendChild($incorrectfeedback);

			$thisquestion->appendChild($doc->createElement('answernumbering','abc'));
		
		
			foreach ($answers as $aitem) {
				####################################
				# adding each answer
				####################################
				$answer = $doc->createElement('answer');
				$answerfraction = $doc->createAttribute('fraction');
				$answerfraction->value = $aitem['correct'];
				$answer->appendChild($answerfraction);

				$answertext = $doc->createElement('text');
				$answertext->appendChild($doc->createCDATASection($aitem['atext']));
				$answer->appendChild($answertext);
		
				$answerfeedback = $doc->createElement('feedback');
				$answerfeedbacktext = $doc->createElement('text');
#				$answerfeedbacktext->appendChild($doc->createCDATASection('feedback text'));
				$answerfeedback->appendChild($answerfeedbacktext);
				$answer->appendChild($answerfeedback);

				$thisquestion->appendChild($answer);

				####################################
				# end adding each answer
				####################################
			}
		
			####################################
			# end adding a question
			####################################
		
		}
		
		
		

		#$child = $doc->createElement('name');
	#	$child = $root->appendChild($child);

	#	$child = $doc->createElement('text');
	#	$child = $root->appendChild($child);
	#	$value = $doc->createCDATASection('four\'s a crowd');
	#	$value = $child->appendChild($value);

		
#		$value = $doc->createTextNode('two\'s a crowd');
#		$value = $child->appendChild($value);

 
		$xml_string = $doc->saveXML();
		header('Content-disposition: attachment; filename=quiz_export_'.$quiz_id.'_'.date('Y-m-d-h-i-s').'.xml');
		header('Content-type: application/xml');
		print $xml_string;
		
	}

	public function quizexporter($quiz_id)
	{

		$this->load->model('quiz');
		print 'exporting '.$quiz_id;
		$a = $this->quiz->getQuizInfo($quiz_id);
		print "<pre>";
		print_r($a);
		print "</pre>";
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
