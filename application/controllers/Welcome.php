<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{

		$this->load->view('welcome_message');


	// 	$this->_rules();

	// 	if($this->form->validation->run()==FALSE) {
	// 		$data['title'] = "Form Login";
	// 		$this->load->view('template/header', $data);
	// 		$this->load->view('login_view');
	// 	}else{
	// 		$username = $this->input->post('username');
	// 		$password = $this->input->post('password');
	// 	}
	// }

	// public function _rules()
	// {
	// 	$this->form_validation->set_rules('username','username','required');
	// 	$this->form_validation->set_rules('password','password','required');
	// }
}
}
