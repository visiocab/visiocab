<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller {

	public function index()
	{
		$this->layout->template('wlogin')->show('usersetup', $this->data);
	}
}