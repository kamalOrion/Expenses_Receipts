<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Corbeille extends CI_Controller {

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
			'title'=> "O'Mel | Corbeille", //titre de la page
			'content'=>'corbeille', //vue à afficher
		);
		$this->load->view('template/content', $data);
	}

	public function tableCorbeilleAjax(){

        if(($_POST['search_text'] != null && $_POST['search_text'] != '')){
            $search = array_merge(
                $this->ivtmodel->get_search_data('projets', $_POST['start'], $_POST['length'], $_POST['search_text'], 0, NULL, $_POST['col_num'], $_POST['order'][0]['dir'], ['statut' =>0], true),
                $this->ivtmodel->get_search_data('phases', $_POST['start'], $_POST['length'], $_POST['search_text'], 0, NULL, $_POST['col_num'], $_POST['order'][0]['dir'], ['statut' =>0], true),
                $this->ivtmodel->get_search_data('activites', $_POST['start'], $_POST['length'], $_POST['search_text'], 0, NULL, $_POST['col_num'], $_POST['order'][0]['dir'], ['statut' =>0], true),
                $this->ivtmodel->get_search_data('taches', $_POST['start'], $_POST['length'], $_POST['search_text'], 0, NULL, $_POST['col_num'], $_POST['order'][0]['dir'], ['statut' =>0], true),
                $this->ivtmodel->get_search_data('point_bloquants', $_POST['start'], $_POST['length'], $_POST['search_text'], 0, NULL, $_POST['col_num'], $_POST['order'][0]['dir'], ['statut' =>0], true),
                $this->ivtmodel->get_search_data('groupes', $_POST['start'], $_POST['length'], $_POST['search_text'], 0, NULL, $_POST['col_num'], $_POST['order'][0]['dir'], ['statut' =>0], true)
            );        
        }else{
            $search = array_merge(
                $this->ivtmodel->get_search_data('projets', $_POST['start'], $_POST['length'], $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], ['statut' =>0]),
                $this->ivtmodel->get_search_data('phases', $_POST['start'], $_POST['length'], $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], ['statut' =>0]),
                $this->ivtmodel->get_search_data('activites', $_POST['start'], $_POST['length'], $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], ['statut' =>0]),
                $this->ivtmodel->get_search_data('taches', $_POST['start'], $_POST['length'], $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], ['statut' =>0]),
                $this->ivtmodel->get_search_data('point_bloquants', $_POST['start'], $_POST['length'], $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], ['statut' =>0]),
                $this->ivtmodel->get_search_data('groupes', $_POST['start'], $_POST['length'], $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], ['statut' =>0])
            );
        }
		$output = array(  
            "draw"  => intval($_POST["draw"]),  
            "recordsTotal" => (
                $this->ivtmodel->count_search_data('projets', NULL, 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('phases', NULL, 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('activites', NULL, 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('taches', NULL, 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('point_bloquants', NULL, 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('groupes', NULL, 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0)
            ),
            "recordsFiltered" => (
                $this->ivtmodel->count_search_data('projets', $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('phases', $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('activites', $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('taches', $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('point_bloquants', $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0) +
                $this->ivtmodel->count_search_data('groupes', $_POST['search']['value'], 0, NULL, $_POST['order'][0]['column'], $_POST['order'][0]['dir'], 0)
            ),
            "data" => $search
        );  
		echo json_encode($output);
	}

    public function restaurer(){
        $tables = [
            'Projet' => 'projets',
            'Phase' => 'phases',
            'Activité' => 'activites',
            'Tâche' => 'taches',
            'Point bloquant' => 'point_bloquants',
            'Document' => 'documents',
            'Groupe' => 'groupes'
            
        ];

        $data = [
            'statut' => 1
        ];

        $this->ivtmodel->update($tables[$this->input->post('nature')], $data, 'id', $this->input->post('id'));
        echo json_encode(1);
    }

	
}
