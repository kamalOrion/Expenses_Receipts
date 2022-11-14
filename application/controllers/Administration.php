<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administration extends CI_Controller {

	public function check(){
		if(!$this->ivtmodel->is_logged()){
			if($this->input->is_ajax_request()){
				return true;
			}else{
				redirect("Dashboard/pageConnexion");//redirection vers le controlleur login
				exit;//sortie de code
			}
		}
	}

	public function index()
	{
		$this->check();
		$data = array(
			'title'=> "O'Mel | Administration", //titre de la page
			'content'=>'administration', //vue à afficher
		);
		$this->load->view('template/content', $data);
	}
}
