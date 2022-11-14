<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	function __construct() {
		parent::__construct();
	}

	public $user_groupe_ids = NULL;

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
			'title'=> "O'Mel | Profil", //titre de la page
			'content'=>'profil', //vue à afficher
			'user' => $user = $this->ivtmodel->getItem('users', 'user_id', $this->session->userdata('user_id'))[0]
		);
		$this->load->view('template/content', $data);
	}

	public function change_pass(){
        if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}
        $this->form_validation->set_error_delimiters("<span class='error_smg'>", "</span>");

        if($this->form_validation->run()){

            $user = $this->ivtmodel->getItem('users', 'user_id', $this->session->userdata('user_id'));

            if(password_verify($this->input->post('actuel_pass'), $user[0]->mdp)){

                $data = array(
                    'mdp' => password_hash($this->input->post('nouveau_pass'), PASSWORD_DEFAULT)
                );

                if($this->ivtmodel->update('users', $data, 'user_id', $this->session->userdata('user_id'))) {
                    echo json_encode(1);
                } else echo json_encode(2);

            }else echo json_encode(["<span class='error_smg'>Mot de passe actuel incorrect</span>"]);

        }else{
            echo json_encode([
				form_error('actuel_pass') !=  '' ? form_error('actuel_pass'): '',
                form_error('nouveau_pass') !=  '' ? form_error('nouveau_pass'): '',
                form_error('confirm_pass') !=  '' ? form_error('confirm_pass'): ''
			]);
        }
	}

	public function change_autre_info(){
        if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}

		($_POST['titre'] != '') ? $data['titre'] = htmlspecialchars($this->input->post('titre')) : '';
		($_POST['service'] != '') ? $data['service'] = htmlspecialchars($this->input->post('service')) : '';
		($_POST['matricule'] != '') ? $data['matricule'] = htmlspecialchars($this->input->post('matricule')) : '';
		($_POST['direction'] != '') ? $data['direction'] = htmlspecialchars($this->input->post('direction')) : '';

		if($this->ivtmodel->update('users', $data, 'id', $this->session->userdata('id'))) {
			$this->MAJ_Session();
			echo json_encode(1);
		} else echo json_encode(2);
	}

	public function change_preference(){
		if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}
		($_POST['tache_delais_critique'] != '') ? $data['tache_delais_critique'] = htmlspecialchars($this->input->post('tache_delais_critique')) : '';
		$data['t_kanban_archive'] = (isset($_POST['archive_kanban'])) ? 1 : 0;

		$check = $this->ivtmodel->getItem('user_preferences', 'user_id', $this->session->userdata('id'));

		if(!$check) $data['user_id'] = $this->session->userdata('id');

		if($check ? $this->ivtmodel->update('user_preferences', $data, 'id', $this->session->userdata('id')) : $this->ivtmodel->add('user_preferences', $data)) {
			$this->MAJ_Session();
			echo json_encode(1);
		} else echo json_encode(2);
	}

	private function MAJ_Session(){
		$user = $this->ivtmodel->getItem('users', 'id', $this->session->userdata('id'))[0];
		$preference = $this->ivtmodel->getItem('user_preferences', 'user_id', $this->session->userdata('id'))[0];
		$session = array(
			'nom'=>$user->nom,
			'prenoms'=>$user->prenoms,
			'titre'=>$user->titre,
			'matricule'=>$user->matricule,
			'direction'=>$user->direction,
			'service'=>$user->service,
			'tache_delais_critique'=>$preference->tache_delais_critique,
			't_kanban_archive'=>$preference->t_kanban_archive,
		);
		//mise en session des données
		$this->session->set_userdata($session);
	}

	public function getSessionData(){
		$session = $this->session->userdata();
		unset($session['__ci_last_regenerate']);
		echo json_encode([$session, base_url(), site_url(), 'kamal']);
	}


	public function get_fuse_priv($table_user, $table_groupe, $data_id_name){

		if($this->session->userdata('id') != 1){
			$data_priv = $this->ivtmodel->getListe($table_user, 'id', 'desc', null, ['user_id'=>$this->session->userdata('id')]);

			$data_user_priv_ids = [];

			if($data_priv){
				foreach ($data_priv as $single_priv) {
					$data_user_priv_ids[$single_priv->{$data_id_name}][] = $single_priv->priv;
				}
			}

			$groupe_ids = $this->session->userdata('user_groupes');

			$data_group_priv_ids = [];
			
			foreach ($groupe_ids as $id) {
				$list = $this->ivtmodel->getListe($table_groupe, 'id', 'desc', null, ['groupe_id'=>$id]);
				$list = ($list) ? $list : [];
				foreach ($list as $priv_g) {
					$data_group_priv_ids[$priv_g->{$data_id_name}][] = $priv_g->priv;
				}
			}

			foreach ($data_user_priv_ids as $key => $val) {
				if(isset($data_group_priv_ids[$key])) $data_user_priv_ids[$key] = array_unique(array_merge($data_group_priv_ids[$key], $data_user_priv_ids[$key]));
			}

			foreach ($data_group_priv_ids as $key => $val) {
				if(isset($data_user_priv_ids[$key])) $data_user_priv_ids[$key] = array_unique(array_merge($data_group_priv_ids[$key], $data_user_priv_ids[$key]));
			}
			
			return $data_user_priv_ids + $data_group_priv_ids;
		} return 'all';
	}

	public function get_priv_universel(){
		$data = $this->get_fuse_priv($this->input->post('tab_user'), $this->input->post('tab_groupe'), $this->input->post('id_name'));
		echo json_encode($data ? $data : []);
	}

}
