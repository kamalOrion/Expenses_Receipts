<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Groupe extends CI_Controller {

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
			'title'=> "O'Mel | Groupe", //titre de la page
			'content'=>'groupe', //vue à afficher
		);
		$this->load->view('template/content', $data);
	}

    public function tableGroupesAjax(){

        $search = $this->ivtmodel->get_search_data('groupes', $_POST['start'], $_POST['length'], $_POST['search']['value'], $_POST['order'][0]['column'], $_POST['order'][0]['dir'], NULL);
		$output = array(  
                "draw"  => intval($_POST["draw"]),  
                "recordsTotal" => $this->ivtmodel->count_search_data('groupes', NULL, NULL),
                "recordsFiltered" => $this->ivtmodel->count_search_data('groupes', $_POST['search']['value'], NULL),
                "data" => $search, 
            ); 
		echo json_encode($output);
	}

	public function ajout(){
        
		if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}
        
        $a = [];
        
       if(isset($_POST['priv'])) $a = $this->input->post('priv');

        $flag = isset($_POST['groupe_id']);

        $priv_check = empty($a);
        
        if(!$flag){

            $this->form_validation->set_rules('nom', 'Nom', 'required|is_unique[groupes.nom]',
                array('required'=>'Ce champs %s est obligatoire', 'is_unique'=>'Un groupe du même nom existe déja.')
            );
            $this->form_validation->set_error_delimiters("<span class='error_smg' style='color: red'>", "</span>");

            $validate = $this->form_validation->run();

        } else if($priv_check) {
             $validate = false;
        } else $validate = true;
        
        if($validate){

            $data = array(
                'privileges'=>implode("/", $a)
            );

            if(!$flag)  $data['statut'] = 1;
            if($this->input->post('nom')) $data['nom'] = $this->input->post('nom');
            
            //Début transaction
            $this->ivtmodel->start_transaction();
                ($flag) ? $this->ivtmodel->update('groupes', $data, 'groupe_id', $this->input->post('groupe_id')) : $this->ivtmodel->add('groupes', $data);
                $this->maj_groupe_user($this->input->post('users'), ($flag ? $this->input->post('groupe_id') : NULL), $flag);
            $this->ivtmodel->complete_transaction();
            //Fin transaction

            //Transaction check
            if($this->ivtmodel->transaction_status()){
                echo json_encode($flag ? 1 : 3);
            }

        }else{

            $errors = [
                "<span class='error_smg'>Erreur lors de l'ajout du groupe : ".$this->input->post('nom')."</span>",
				form_error('nom') !=  '' ? form_error('nom'): '',
                form_error('priv[]') !=  '' ? form_error('priv[]'): '',
                form_error('droit_acces[]') !=  '' ? form_error('droit_acces[]'): '',
                form_error('users[]') !=  '' ? form_error('users[]'): ''
			];

            if($priv_check) $errors[] = "<span class='error_smg' style='color: red'>Les privilèges sont obligatoires</span>";

            echo json_encode($errors);
        }
	}

    private function maj_groupe_user($users_received, $groupe_id, $flag){

        $users_received = $users_received ? $users_received : [];

       if($flag){

            $users_in_groupe = $this->get_values_from_array($this->ivtmodel->getListeWhereArray('*', "jonction_user_groupe", ['groupe_id'=>$groupe_id]), 'user_id');

            foreach($users_in_groupe as $user_id){
                if(!in_array($user_id, $users_received)){
                    $this->ivtmodel->delete('jonction_user_groupe', null, ['groupe_id' => $groupe_id, 'user_id' => $user_id]);
                }
            }

            foreach($users_received as $user_id){
                if(!in_array($user_id, $users_in_groupe)){
                    $this->ivtmodel->add('jonction_user_groupe', ['groupe_id' => $groupe_id, 'user_id' => $user_id]);
                }
            }

       }else{
            $groupe = $this->ivtmodel->getLastItem('groupes', 'groupe_id')[0];
            foreach($users_received as $user_id){
                $this->ivtmodel->add('jonction_user_groupe', ['groupe_id' => $groupe->groupe_id, 'user_id' => $user_id]);
            }
       }

        return true;
    }

    private function get_values_from_array($array, $value_name){
        $data = [];
        if($array){
            foreach($array as $item){
                $data[] = (is_array($item)) ? $item[$value_name] : $item->$value_name;
            }
        }
        return $data;
    }
    
    public function get_users(){
        $all_users = $this->ivtmodel->getListe('users', 'nom_prenoms', 'asc');
        if(isset($_POST['groupe_id'])){
            $g_u_relation = $this->get_values_from_array($this->ivtmodel->getListeWhereArray('*', 'jonction_user_groupe', ['groupe_id' => $this->input->post('groupe_id')]), 'user_id');
            $users = [];
            if($g_u_relation){
                $result = [];
                foreach($all_users as $index => $user){
                    if(in_array($user->user_id, $g_u_relation)){
                        $user->selected = 'selected';
                        $result[] = $user;
                    }else  $result[] = $user;
                }
                echo json_encode($result);
            }else echo json_encode($all_users);
        }else echo json_encode($all_users);
    }

    public function get_privileges(){
        $priv = explode('/', $this->ivtmodel->getItem('groupes', 'groupe_id', $this->input->post('groupe_id'))[0]->privileges);
        echo json_encode($priv);
    }

    public function delete_groupe(){
        echo json_encode($this->ivtmodel->delete('groupes', 'groupe_id', $this->input->post('groupe_id')));
    }

    public function groupe_statut(){
        echo json_encode(($this->ivtmodel->update('groupes', ['statut' => ($this->input->post('statut') == 'Actif' ? 0 : 1)], 'groupe_id', $this->input->post('groupe_id'))) ? 1 : 2);
    }

    public function updatePrivilges(){
        $groupes = $this->ivtmodel->getListe('groupes', 'id', 'desc');
        foreach($groupes as $groupe){
            $priv_ids = explode('/', $groupe->privileges);
            foreach($priv_ids as $id => $priv_id){
                if(!$this->ivtmodel->getItem('privileges', 'id', $priv_id)) unset($priv_ids[$id]);
            }
            $data = ['privileges' => implode('/', $priv_id)];
            $this->ivtmodel->update('groupes', $data, 'id', $groupe->$id);
        }
    }
    
    public function getUsersHTML(){
        $ids = explode('/', $_GET['user']);
        $userHTML = "<ul>";
        foreach($ids as $id){
            $user = $this->ivtmodel->getItem('users', NULL, ['id' => $id]);
            $user = ($user) ? $user : NULL;
            if($user) $userHTML.= "<li class='in_table_user'>".$user->nom." ".$user->prenoms."</li>";
        }
        $userHTML .= "</ul>";
        echo json_encode([$userHTML]);        
    }

    public function corbeille_groupe($id){
        if($id != 1){
            $this->ivtmodel->update('groupes', ['statut' => '0'], 'id', $id);
            echo json_encode( 1 );   
        }else echo json_encode( 2 );   
    }

    public function getActivite_groupe(){
        $groupes = $this->ivtmodel->getListeWhereArray('*', "jonction_groupe_activite", ['activite_id'=>$this->input->post('id')]);
        $data = [];
        if($groupes){
            foreach($groupes as $groupe){
                $data[] = $this->ivtmodel->getItem('groupes', NULL, ['id' => $groupe->groupe_id])[0];
            }
        }
        echo json_encode(['groupe', $data]);   
    }

    public function getTache_groupe(){
        $groupes = $this->ivtmodel->getListeWhereArray('*', "jonction_groupe_tache", ['tache_id'=>$this->input->post('id')]);
        $data = [];
        if($groupes){
            foreach($groupes as $groupe){
                $data[] = $this->ivtmodel->getItem('groupes', NULL, ['id' => $groupe->groupe_id])[0];
            }
        }
        echo json_encode(['groupe', $data]);   
    }

    public function get_data_groupe(){
        switch ($this->input->post('flag')) {

            case 'projet':
                $table1 = 'projets';
                $table2 = 'privileges_groupe_projet';
                $field = 'projet_id';
            break;

            case 'activite':
                $table1 = 'activites';
                $table2 = 'privileges_groupe_activite';
                $field = 'activite_id';
            break;

            case 'tache':
                $table1 = 'taches';
                $table2 = 'privileges_groupe_tache';
                $field = 'tache_id';
            break;
        }
        $all_data = $this->ivtmodel->getListe($table1, 'libelle', 'asc', null, ['statut' => 1]);
        if(isset($_POST['id'])){
            $relation = $this->get_values_from_array($this->ivtmodel->getListeWhereArray('*', $table2, ['groupe_id' => $this->input->post('id')]), $field);
            $datas = [];
            if($relation){
                $result = [];
                foreach($all_data as $index => $data){
                    if(in_array($data->id, $relation)){
                        $data->selected = 'selected';
                        $result[] = $data;
                    }else  $result[] = $data;
                }
                echo json_encode($result);
            }else echo json_encode($all_data);
        }else echo json_encode($all_data);
    }

    public function maj_prev(){

        $destination_id = [
            'p_j' => 'projet_id',
            'a_t' => 'activite_id',
            't_e' => 'tache_id',
        ];

        $typographie = [
            'u_s' => 'user',
            'g_p' => 'groupe',
        ];

        $typographie_id = [
            'u_s' => 'user_id',
            'g_p' => 'groupe_id',
        ];

        switch ($this->input->post('typo')) {
            case 'g_p':
                if($this->input->post('dest') == 'p_j') $table = 'privileges_groupe_projet';
                if($this->input->post('dest') == 'a_t') $table = 'privileges_groupe_activite';
                if($this->input->post('dest') == 't_e') $table = 'privileges_groupe_tache';
                break;
            case 'u_s':
                if($this->input->post('dest') == 'p_j') $table = 'privileges_user_projet';
                if($this->input->post('dest') == 'a_t') $table = 'privileges_user_activite';
                if($this->input->post('dest') == 't_e') $table = 'privileges_user_tache';
                break;
        }

        if($this->input->post('action') == 'add'){
            $this->ivtmodel->add($table, [$typographie_id[$this->input->post('typo')] => $this->input->post('number'), $destination_id[$this->input->post('dest')] => $this->input->post('number2'), 'priv' => $this->input->post('value')]);
        } else if($this->input->post('action') == 'remove'){
            $this->ivtmodel->delete($table, null, [$typographie_id[$this->input->post('typo')] => $this->input->post('number'), $destination_id[$this->input->post('dest')] => $this->input->post('number2'), 'priv' => $this->input->post('value')]);
        }

        echo json_encode(1);
    }

    private function maj_privilege_element($data_table, $id_name, $data_received, $data_name, $data_id, $flag){

        if($flag){
             $data_in_groupe = $this->get_values_from_array($this->ivtmodel->getListeWhereArray('*', $data_table, [$data_name=>$data_id]), $id_name);
 
             foreach($data_in_groupe as $data_id){
                if(!in_array($data_id, $data_received)){
                $this->ivtmodel->delete($data_table, null, [$data_name => $data_id, $id_name => $data_id]);
                }
             }
 
             foreach($data_received as $data_id){
                if(!in_array($data_id, $data_in_groupe)){
                $this->ivtmodel->add($data_table, [$data_name => $data_id, $id_name => $data_id]);
                }
             }
 
        }else{
             $data = $this->ivtmodel->getLastItem($data_table)[0];
             foreach($data_received as $data_id){
                 $this->ivtmodel->add($data_table, [$data_name => $data->id, $id_name => $data_id]);
             }
        }
 
         return true;
     }

     public function groupes_seeder(){
       
        for ($i=0; $i < 200; $i++) { 
            $groupes = [
                'nom' => 'Groupe'.($i+1)
            ];

            $this->ivtmodel->add('groupes', $groupes);
        }
    }
}
