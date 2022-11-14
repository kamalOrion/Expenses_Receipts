<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Depenses extends CI_Controller {

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
			'title'=> "O'Mel | Dépenses", //titre de la page
			'content'=> "depense", 
		);
		
		$this->load->view('template/content', $data);
	}

	public function get_type_depenses(){
		echo json_encode($this->set_select2_format(!isset($_GET['q']) || $_GET['q'] == '' ? $this->ivtmodel->getListe('type_depense', 'type_depense_id', 'DESC') : $this->ivtmodel->getListe('type_depense', 'type_depense_id', 'DESC', ['libelle', $_GET['q']])));
	}

	public function get_type_depense(){
		echo json_encode($this->ivtmodel->getItem('type_depense', 'type_depense_id', $this->input->post('type_depense_id')));
	}

	public function delete_depense(){
		echo json_encode(allowed('SD') && $this->ivtmodel->delete('depenses', 'depense_id', $this->input->post('depense_id')));
	}

	public function invalide_depense(){
		echo json_encode(allowed('ID') && $this->ivtmodel->update('depenses', ['statut' => 0], 'depense_id', $this->input->post('depense_id')));
	}

	private function set_select2_format($data){
		$result = [];
		foreach ($data as $item) {
			$a['id'] = $item->type_depense_id;
			$a['text'] = $item->libelle;
			$result[] = $a;
		}
		return ['results' => $result];
	}

	public function ajout(){
		if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}
		
        $this->form_validation->set_error_delimiters("<span class='error_smg'>", "</span>");

        $config = array(
            array(
                    'field' => 'type_depense',
                    'label' => 'Type de dépense',
                    'rules' => 'required',
                    'errors' => ['required'=>'Le champ %s est obligatoire']
            ),
            array(
                    'field' => 'qte',
                    'label' => 'Quantité',
                    'rules' => 'required|integer',
                    'errors' => ['required'=>'Le champ %s est obligatoire', 'integer'=>'Seul les chiffres sont autorisés pour le champ %s']
            ),
            array(
                    'field' => 'prix_unitaire',
                    'label' => 'Prix unitaire',
                    'rules' => 'required|integer',
                    'errors' => ['required'=>'Le champ %s est obligatoire', 'integer'=>'Seul les chiffres sont autorisés pour le champ %s']
            )
        );

        $this->form_validation->set_rules($config);
        
        if($this->form_validation->run()){
            
            $data = array(
                'type_depense_id' => $this->input->post('type_depense'),
				'user_id' => $this->session->userdata('user_id'),
                'qte' => $this->input->post('qte'),
                'prix_unitaire' => $this->input->post('prix_unitaire'),
				'mode_paiement' => $this->input->post('mode_paiement'),
				'echeance' => date('Y-m-d', strtotime($this->input->post('echeance'))),
                'commentaire' => htmlspecialchars($this->input->post('commentaire')),
				'statut' => 0
            );  

			allowed('MD') && isset($_POST['depense_id']) ? 
			$this->ivtmodel->update('depenses', $data, 'depense_id', $this->input->post('depense_id')) : 
				(allowed('AD') ? $this->ivtmodel->add('depenses', $data) : 
				function(){
					echo json_encode([
						"<span class='error_smg'>Vous n'etes pas autorisé a éffectué cette action</span>"
					]);
					return;
				});
				echo json_encode(isset($_POST['depense_id']) ? 2 : 1);

        }else echo json_encode([
			"<span class='error_smg'>Erreur lors de l'ajout de la dépense </span>",
			form_error('type_depense') !=  '' ? form_error('type_depense'): '',
			form_error('qte') !=  '' ? form_error('qte'): '',
			form_error('prix_unitaire') !=  '' ? form_error('prix_unitaire'): '',
			form_error('commentaire') !=  '' ? form_error('commentaire'): '',
		]);
	}

	public function dissocier_depense_effectue(){

		if(allowed('DDE')){
			//Début transaction
			$this->ivtmodel->start_transaction();
				$this->ivtmodel->update('depenses', ['liste_depense_valide_id' => 0], 'liste_depense_valide_id', $this->input->post('liste_depenses_valides_id'));
				$this->ivtmodel->delete('liste_depenses_valides', 'liste_depenses_valides_id', $this->input->post('liste_depenses_valides_id'));
			$this->ivtmodel->complete_transaction();
			//Fin transaction

			//Transaction check
			echo json_encode($this->ivtmodel->transaction_status() ? 1 : 0);

		} else echo json_encode(0);

		
	}

	public function get_depenses_non_valide(){
		echo json_encode($this->ivtmodel->get_depenses_non_valide(isset($_POST['depense_id']) ? $this->input->post('depense_id') : NULL, isset($_POST['text']) ? $this->input->post('text') : NULL));
	}

	public function get_depenses_effectue(){
		echo json_encode($this->ivtmodel->get_depenses_effectue());
	}

	public function get_depenses_valide(){
		echo json_encode($this->ivtmodel->get_depenses_valide(isset($_POST['text']) ? $this->input->post('text') : NULL));
	}

	public function get_depenses_valide_list(){
		echo json_encode($this->ivtmodel->get_depenses_valide_list($this->input->post('list_valid_id')));
	}

	public function effectue_depense(){

		if(allowed('GDE')){
			//Début transaction
			$this->ivtmodel->start_transaction();
				$this->ivtmodel->add('liste_depenses_valides', ['auteur_id' => $this->session->userdata('user_id')]);
				$liste_depenses_valides_id = $this->ivtmodel->getLastItem('liste_depenses_valides', 'liste_depenses_valides_id')[0]->liste_depenses_valides_id;
				foreach ($this->input->post('selected_valide_depense') as $depense_id) {
					$this->ivtmodel->update('depenses', ['liste_depense_valide_id' => $liste_depenses_valides_id], 'depense_id', $depense_id);
				}
			$this->ivtmodel->complete_transaction();
			//Fin transaction

			//Transaction check
			echo json_encode($this->ivtmodel->transaction_status() ? 1 : 0);
			
		} else echo json_encode(0);

		
	}

	public function validate_depense(){

		if(allowed('VD')){
			//Début transaction
			$this->ivtmodel->start_transaction();
				foreach ($this->input->post('selected_depense') as $depense_id) {
					$this->ivtmodel->update('depenses', ['statut' => 1], 'depense_id', $depense_id);
				}
			$this->ivtmodel->complete_transaction();
			//Fin transaction

			//Transaction check
			echo json_encode($this->ivtmodel->transaction_status() ? 1 : 0);

		} else echo json_encode(0);
		
	}

	public function get_last_price(){
		$last = $this->ivtmodel->get_last_price('depenses', 'depense_id', 'type_depense_id', $this->input->post('type_depense_id'));
		echo json_encode($last ? $last : 0);
	}


	// public function depense_seeder(){
       
    //     for ($i=0; $i < 20; $i++) { 
    //         $depense = [
	// 			'user_id' => 1,
	// 			'liste_depense_valide_id' => rand(1,3),
	// 			'qte' => rand(1,10),
	// 			'prix_unitaire' => rand(500, 15000),
	// 			'echeance' => date('Y-m-d h:i:s'),
	// 			'commentaire' => $this->generateRandomString(),
	// 			'statut' => 1
    //         ];

    //         $this->ivtmodel->add('depenses', $depense);
    //     }
    // }

	// public function liste_depenses_valides_seeder(){
       
    //     for ($i=0; $i < 20; $i++) { 
    //         $liste_depenses_valides = [
	// 			'document_id' => $i
    //         ];

    //         $this->ivtmodel->add('liste_depenses_valides', $liste_depenses_valides);
    //     }
    // }

	// public function documents_seeder(){
       
    //     for ($i=0; $i < 20; $i++) { 
    //         $documents = [
	// 			'libelle' => 'document'.$i,
	// 			'url' => 'assets/img/test'.$i.'.pdf',
	// 			'parent' => $this->generateRandomString(10)
    //         ];

    //         $this->ivtmodel->add('documents', $documents);
    //     }
    // }

	// private function generateRandomString($length = 200) {
	// 	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
	// 	$charactersLength = strlen($characters);
	// 	$randomString = '';
	// 	for ($i = 0; $i < $length; $i++) {
	// 		$randomString .= $characters[rand(0, $charactersLength - 1)];
	// 	}
	// 	return $randomString;
	// }

}
