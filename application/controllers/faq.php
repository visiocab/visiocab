<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function index($package_id)
	{
		$this->layout->show('faq', $this->data);
	}
}