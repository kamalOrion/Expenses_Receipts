<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Structures extends CI_Controller {

	public function check(){
		if(!$this->ivtmodel->is_logged()){
			if($this->input->is_ajax_request()){
				return true;
			}else{
				redirect('dashboard/');//redirection vers le controlleur login
				exit;//sortie de code
			}
		}
	}

	public function index()
	{
		$this->check();
		$data = array(
			'title'=> "OMEL | Structures", //titre de la page
			'content'=>'structure', //vue à afficher
		);
		$this->load->view('template/content', $data);
	}

    public function tableStructuresAjax(){

        $search = $this->ivtmodel->get_search_data('structures', $_POST['start'], $_POST['length'], $_POST['search']['value'], $_POST['order'][0]['column'], $_POST['order'][0]['dir'], NULL);
		$output = array(  
                "draw"  => intval($_POST["draw"]),  
                "recordsTotal" => $this->ivtmodel->count_search_data('structures', NULL, NULL),
                "recordsFiltered" => $this->ivtmodel->count_search_data('structures', $_POST['search']['value'], NULL),
                "data" => $search, 
            ); 
		echo json_encode($output);
	}

    public function get_users(){
		echo json_encode($this->set_select2_format(!isset($_GET['q']) || $_GET['q'] == '' ? $this->ivtmodel->getListe('users', 'user_id', 'DESC') : $this->ivtmodel->getListe('users', 'user_id', 'DESC', ['nom_prenoms', $_GET['q']])));
	}

    private function set_select2_format($data){
		$result = [];
		foreach ($data as $item) {
			$a['id'] = $item->user_id;
			$a['text'] = $item->nom_prenoms;
			$result[] = $a;
		}
		return ['results' => $result];
	}

	public function ajout_structure(){
        
		if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}

        $flag = isset($_POST['structure_id']);

        $this->form_validation->set_rules('nom', 'Nom', 'required|is_unique[structures.nom]',
            array('required'=>'Ce champs %s est obligatoire', 'is_unique'=>'Une structure du même nom existe déja.')
        );
        $this->form_validation->set_rules('administrateur', 'Administrateur', 'required',
            array('required'=>'Ce champs %s est obligatoire')
        );
        $this->form_validation->set_error_delimiters("<span class='error_smg'>", "</span>");

        $validate = $this->form_validation->run();
        
        if($validate){
            if($this->input->post('nom')) $data['nom'] = $this->input->post('nom');
            if($this->input->post('administrateur')) $data['admin_id'] = $this->input->post('administrateur');
            if(!$flag) $data['statut'] = 0;
            
                $check = ($flag) ? $this->ivtmodel->update('structures', $data, 'structure_id', $this->input->post('structure_id')) : $this->ivtmodel->add('structures', $data);
            
            if($check){
                echo json_encode($flag ? 1 : 0);
            }

        }else{

            echo json_encode([
                "<span class='error_smg'>Erreur lors de l'ajout de la structure : ".$this->input->post('nom')."</span>",
				form_error('nom') !=  '' ? form_error('nom'): '',
                form_error('administrateur') !=  '' ? form_error('administrateur'): '',
			]);
        }
	}

    public function get_structure(){
		echo json_encode($this->ivtmodel->getItem('structures', 'structure_id', $this->input->post('structure_id')));
	}

    public function structure_statut(){
        echo json_encode(($this->ivtmodel->update('structures', ['statut' => ($this->input->post('statut') == 'Actif' ? 0 : 1)], 'structure_id', $this->input->post('structure_id'))) ? 1 : 2);
    }
}
