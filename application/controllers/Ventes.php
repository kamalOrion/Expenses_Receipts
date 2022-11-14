<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventes extends CI_Controller {

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
			'content'=>'vente', //vue à afficher
		);
		$this->load->view('template/content', $data);
	}

	public function get_produits(){
		echo json_encode($this->set_select2_format(!isset($_GET['q']) || $_GET['q'] == '' ? $this->ivtmodel->getListe('produits', 'produit_id', 'DESC') : $this->ivtmodel->getListe('produits', 'produit_id', 'DESC', ['libelle', $_GET['q']])));
	}

	public function get_produit(){
		echo json_encode($this->ivtmodel->getItem('produits', 'produit_id', $this->input->post('produit_id')));
	}

	public function delete_vente(){
		echo json_encode(allowed('SV') && $this->ivtmodel->delete('ventes', 'vente_id', $this->input->post('vente_id')));
	}

	private function set_select2_format($data){
		$result = [];
		foreach ($data as $item) {
			$a['id'] = $item->produit_id;
			$a['text'] = $item->libelle;
			$result[] = $a;
		}
		return ['results' => $result];
	}

	public function get_ventes_non_groupe(){
		echo json_encode($this->ivtmodel->get_ventes_non_groupe(isset($_POST['vente_id']) ? $this->input->post('vente_id') : NULL, isset($_POST['text']) ? $this->input->post('text') : NULL));
	}

	public function ajout(){
        
		if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}

		$this->form_validation->set_error_delimiters("<span class='error_smg'>", "</span>");

		$config = array(
			array(
					'field' => 'produit',
					'label' => 'Produit',
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
			),
			array(
					'field' => 'date_vente',
					'label' => 'Date de le vente',
					'rules' => 'required',
					'errors' => ['required'=>'Le champ %s est obligatoire']
			)
		);

		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run()){
			
			$data = array(
				'produit_id' => $this->input->post('produit'),
				'user_id' => $this->session->userdata('user_id'),
				'qte' => $this->input->post('qte'),
				'prix_unitaire' => $this->input->post('prix_unitaire'),
				'mode_paiement'  => $this->input->post('mode_paiement'),
				'date_vente' => date('Y-m-d', strtotime($this->input->post('date_vente'))),
				'commentaire' => htmlspecialchars($this->input->post('commentaire')),
				'statut' => 0
			); 

			allowed('MV') && isset($_POST['vente_id']) ? 
			$this->ivtmodel->update('ventes', $data, 'vente_id', $this->input->post('vente_id')) : 
			(allowed('AV') ? $this->ivtmodel->add('ventes', $data) : 
			function(){
				echo json_encode([
					"<span class='error_smg'>Vous n'etes pas autorisé a éffectué cette action</span>"
				]);
				return;
			});
			echo json_encode(isset($_POST['vente_id']) ? 2 : 1);

		}else echo json_encode([
			"<span class='error_smg'>Erreur lors de l'enrégistrement de la vente</span>",
			form_error('produit') !=  '' ? form_error('produit'): '',
			form_error('qte') !=  '' ? form_error('qte'): '',
			form_error('date_vente') !=  '' ? form_error('date_vente'): '',
			form_error('commentaire') !=  '' ? form_error('commentaire'): '',
		]);
	}

	public function groupe_as_recette(){
		if(allowed('GVR')){
			//Début transaction
			$this->ivtmodel->start_transaction();
				$this->ivtmodel->add('recettes', ['auteur_id' => $this->session->userdata('user_id'),'date_recette' => date('Y-m-d', strtotime($this->input->post('date_recette')))]);
				$recette_id = $this->ivtmodel->getLastItem('recettes', 'recette_id')[0]->recette_id;
				foreach ($this->input->post('selected_vente') as $vente_id) {
					$this->ivtmodel->update('ventes', ['recette_id' => $recette_id, 'statut' => 1], 'vente_id', $vente_id);
				}
			$this->ivtmodel->complete_transaction();
			//Fin transaction

			//Transaction check
			echo json_encode($this->ivtmodel->transaction_status() ? 1 : 0);

		} else echo json_encode(0);	
	}

	public function degroupe_recette(){
		if(allowed('DVR')){
			//Début transaction
			$this->ivtmodel->start_transaction();
				$this->ivtmodel->update('ventes', ['recette_id' => NULL, 'statut' => 0], 'recette_id', $this->input->post('recette_id'));
				$this->ivtmodel->delete('recettes', 'recette_id', $this->input->post('recette_id'));
			$this->ivtmodel->complete_transaction();
			//Fin transaction

			//Transaction check
			echo json_encode($this->ivtmodel->transaction_status() ? 1 : 0);
			
		} else echo json_encode(0);
	}

	public function get_recette(){
		echo json_encode($this->ivtmodel->get_recette());
	}

	public function get_liste_vente_recette(){
		echo json_encode($this->ivtmodel->get_liste_vente_recette($this->input->post('recette_id')));
	}

	public function get_last_price(){
		$last = $this->ivtmodel->get_last_price('ventes', 'vente_id', 'produit_id', $this->input->post('produit_id'));
		echo json_encode($last ? $last : 0);
	}
	

}
