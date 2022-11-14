<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function index()	{
		
		if($this->ivtmodel->is_logged()){
			$this->dashboardPage();
		}else{
			$this->pageConnexion();
		}
	}

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

	public function dashboardPage(){
		
		$this->check();
		
		$data = array(
			"title" => "Mel | Dashboard",
			"content" => "dashboard",
		);

		$this->load->view('template/content', $data);
	}

	public function pageConnexion($error = NULL) {
	 	$data = array(
	 		"title" => "Mel | Connexion",
	 		"error"	=> $error
	 	);
	 	$this->load-> view("pageDeConnexion", $data);
	}

	public function connexion() {
		if(!isset($_POST)){
        	$this->index();
        } else {
        	$this->form_validation->set_error_delimiters('<span>', '</span>');
			if($this->form_validation->run()) {
				$email = $this->input->post('email');
				$mdp = $this->input->post("mdp");
				if ($this->ivtmodel->se_connecter( $email, $mdp )) {
					$this->dashboardPage();
				} else {
					$error = 'Mauvais identifiants ou compte désactivé';
					$this->pageConnexion($error);
				}
			} else $this->pageConnexion();
        }
	}

	public function deconnexion(){
		$this->ivtmodel->se_deconnecter();
		redirect("Dashboard");
	}

	public function tableDashboardAjax(){
		
		$search = $this->ivtmodel->get_search_data('dashboard', $_POST['start'], $_POST['length'], $_POST['search']['value'], $_POST['order'][0]['column'], $_POST['order'][0]['dir'], NULL);
		$output = array(  
                "draw"  => intval($_POST["draw"]),  
                "recordsTotal" => $this->ivtmodel->count_search_data('dashboard', NULL, NULL),
                "recordsFiltered" => $this->ivtmodel->count_search_data('dashboard', $_POST['search']['value'], NULL),
                "data" => $search, 
            ); 
		echo json_encode($output);
	}

	public function get_bar_chart_data(){
		echo json_encode($this->format_chart_data($this->ivtmodel->getDashData(isset($_POST['date']) ? $this->input->post('date') : NULL)));
	}

	private function format_chart_data($data){
		
		if($data){
			$dates = []; $montant = []; $nbr = [];
			foreach( $data as $item ){
				$dates[] = date('d/m/Y', strtotime($item->date));
				$montant[] = $item->montant;
				$nbr[] = $item->nbr_vente;
			}
			return ['dates' => $dates, 'montant' => $montant, 'nbr' => $nbr];
		}else return ['dates' => [], 'montant' => [], 'nbr' => []];
	}

}
