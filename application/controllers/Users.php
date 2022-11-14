<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

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
			'title'=> "O'Mel | Utilisateurs", //titre de la page
			'content'=>'users', //vue à afficher
		);
		$this->load->view('template/content', $data);
	}

	public function tableUsersAjax(){

        $search = $this->ivtmodel->get_search_data('users', $_POST['start'], $_POST['length'], $_POST['search']['value'], $_POST['order'][0]['column'], $_POST['order'][0]['dir'], NULL);
		$output = array(  
                "draw"  => intval($_POST["draw"]),  
                "recordsTotal" => $this->ivtmodel->count_search_data('users', NULL, NULL),
                "recordsFiltered" => $this->ivtmodel->count_search_data('users', $_POST['search']['value'], NULL),
                "data" => $search, 
            ); 
		echo json_encode($output);
	}

	public function ajout(){
        
		if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}

        $this->form_validation->set_error_delimiters("<span class='error_smg'>", "</span>");

        $config = array(
            array(
                    'field' => 'nom_prenoms',
                    'label' => 'Nom et prenoms',
                    'rules' => 'required',
                    'errors' => ['required'=>'Le champ %s est obligatoire']
            ),
            array(
                    'field' => 'structure',
                    'label' => 'Structure',
                    'rules' => 'required',
                    'errors' => ['required'=>'Le champ %s est obligatoire']
            ),
            array(
                    'field' => 'tel',
                    'label' => 'Téléphone',
                    'rules' => 'required|integer',
                    'errors' => ['required'=>'Le champ %s est obligatoire', 'integer'=>'Seul les chiffres sont autorisés pour le champ %s']
            ),
        );

        $flag = isset($_POST['user_id']);
        
        if(!$flag){
            $config[] =  [
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => ['required'=>'Le champ %s est obligatoire', 'valid_email'=>'Le champ %s est invalide', 'is_unique'=>"L'email saisis est déja utilisé"]
            ];
        }

        //var_dump($_POST, $flag, !$flag, $config, $this->form_validation->run()); exit;
        $this->form_validation->set_rules($config);

        $check = true;
        
        if($this->form_validation->run()){
            
            $data = array(
                'nom_prenoms'=> $this->input->post('nom_prenoms'),
                'email'=> $this->input->post('email'),
                'structure_id' => $this->input->post('structure'),
                'tel'=> $this->input->post('tel')
            );  
            
            if($flag){

                $user_to_update_id = $this->input->post('user_id');

                $this->update_and_protect_admin($user_to_update_id, $data);

                echo json_encode( 1);

            } else if(!$flag){

                $ramdom_str = $this->rand_chars('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890', 10);
                $data['mdp'] = 'to_set-$/'.password_hash($ramdom_str, PASSWORD_DEFAULT);

                $this->ivtmodel->add('users', $data);
                echo json_encode($ramdom_str);

            } else echo json_encode(2);

        }else{
            $errors = [
                "<span class='error_smg'>Erreur lors de l'ajout de l'utilsateur : ".$this->input->post('nom_prenoms')."</span>",
				form_error('nom') !=  '' ? form_error('nom_prenoms'): '',
                form_error('email') !=  '' ? form_error('email'): '',
                form_error('role') !=  '' ? form_error('role'): '',
                form_error('tel') !=  '' ? form_error('tel'): '',
			];
            echo json_encode($errors);
        }
	}

    private function update_and_protect_admin($user_to_update_id, $data){
        $user_to_update_id == 1 && $this->session->userdata('user_id') == 1 ? 
        $this->ivtmodel->update('users', $data, 'user_id', $user_to_update_id) : 
        ($user_to_update_id != 1 ? $this->ivtmodel->update('users', $data, 'user_id', $user_to_update_id) : NULL);
    }

    public function reinit_pwd($user_id){

        $random_string = $this->rand_chars('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890', 10);

        $user = $this->ivtmodel->getItem('users', 'user_id', $user_id)[0];
            
        $data = array(

            'mdp' => 'to_set-$/'.password_hash($random_string, PASSWORD_DEFAULT)
        );  

        if($user_id != 1){
            $this->ivtmodel->update('users', $data, 'user_id', $user_id);
            echo json_encode($this->activate_and_notify_user($user_id, $user->email, $random_string, 'ajx'));
        } else echo json_encode(false);
        
    } 

    public function rand_chars($c, $l, $u = FALSE) {
        if (!$u) for ($s = '', $i = 0, $z = strlen($c)-1; $i < $l; $x = rand(0,$z), $s .= $c[$x], $i++);
        else for ($i = 0, $z = strlen($c)-1, $s = $c[rand(0,$z)], $i = 1; $i != $l; $x = rand(0,$z), $s .= $c[$x], $s = ($s[$i] == $s[$i-1] ? substr($s,0,-1) : $s), $i=strlen($s));
        return $s;
    } 

    public function notify_user_added($random_string = NULL){
        $random_string = $random_string ? $random_string : $this->input->post('str');

        $last_added = $this->ivtmodel->getLastItem('users', 'user_id')[0];
        return ($this->activate_and_notify_user($last_added->user_id, $last_added->email, $random_string, false)) ? 'user' : false;
    }

    private function activate_and_notify_user($user_id, $email, $random_string = NULL, $flag = NULL){
          
        if($random_string){

            $user = $this->ivtmodel->getItem("users", "user_id", $user_id)[0];
            
            $this->notification->send_email($email, "Créaction de compte O'Mel", activate_user($email, "Créaction de compte O'Mel", $user->nom_prenoms, $random_string, $this->ivtmodel->getItem('params_plateforme', 'id', 1)[0]->entreprise));
            if($flag){
                echo '1';
            }else return true;
            
        } else {
            if($flag){
                echo '0';
            }else return false;
        }
    }

    public function user_statut(){

        echo json_encode(($this->input->post('user_id') != 1 && $this->ivtmodel->update('users', ['statut' => ($this->input->post('statut') == 'Actif' ? 'Desactive' : 'Actif')], 'user_id', $this->input->post('user_id'))) ? 1 : 2);
    }

    public function get_privileges_ajax($id){
        echo json_encode($this->ivtmodel->getItem('users', NULL, 'id', $id)[0]->privileges);
    }

    public function mdp_user(){
        $this->form_validation->set_error_delimiters("<span class='error_smg'>", "</span>");
        if($this->form_validation->run()){
            $data = array(
                'mdp'=>password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
            );
            echo ($this->input->post('user_id') == $this->session->userdata('user_id') || $this->session->userdata('user_id') == 1) ? $this->ivtmodel->update('users', $data, 'user_id', $this->input->post('user_id')) :  json_encode(['Action impossible']);
        }else{
            echo json_encode([
				form_error('pass') !=  '' ? form_error('pass'): '',
                form_error('confirme') !=  '' ? form_error('confirme'): '',
			]);
        }
    }

    public function get_user(){
        echo json_encode($this->ivtmodel->getItem('users', 'user_id', $this->input->post('user_id')));
    }

    public function get_groupes(){
        $all_groupes = $this->ivtmodel->getListe('groupes ', 'groupe_id', 'DESC', null, ['statut' => 1]);
        if(isset($_POST['user_id'])){
            $g_u_relation = $this->get_values_from_array($this->ivtmodel->getListeWhereArray('*', 'jonction_user_groupe', ['user_id' => $this->input->post('user_id')]), 'groupe_id');
            $groupes = [];
            if($g_u_relation){
                $result = [];
                foreach($all_groupes as $index => $groupe){
                    if(in_array($groupe->groupe_id, $g_u_relation)){
                        $groupe->selected = 'selected';
                        $result[] = $groupe;
                    }else  $result[] = $groupe;
                }
                echo json_encode($result);
            }else echo json_encode($all_groupes);
        }else echo json_encode($all_groupes);
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

    public function maj_user_groupe(){

        $users_groupe = $this->get_values_from_array($this->ivtmodel->getListeWhereArray('*', "jonction_user_groupe", ['user_id'=>$this->input->post('user_id')]), 'groupe_id');

        foreach($users_groupe as $groupe_id){
            if(!in_array($groupe_id, $this->input->post('groupe'))){
                $this->ivtmodel->delete('jonction_user_groupe', null, ['groupe_id' => $groupe_id, 'user_id' => $this->input->post('user_id')]);
            }
        }

        foreach($this->input->post('groupe') as $groupe_id){
            if(!in_array($groupe_id, $users_groupe)){
                $this->ivtmodel->add('jonction_user_groupe', ['groupe_id' => $groupe_id, 'user_id' => $this->input->post('user_id')]);
            }
        }
        
        echo json_encode(1);
    }

    public function get_structures(){
		echo json_encode($this->set_select2_format(!isset($_GET['q']) || $_GET['q'] == '' ? $this->ivtmodel->getListe('structures', 'structure_id', 'DESC') : $this->ivtmodel->getListe('structures', 'structure_id', 'DESC', ['nom', $_GET['q']])));
	}

    private function set_select2_format($data){
		$result = [];
		foreach ($data as $item) {
			$a['id'] = $item->structure_id;
			$a['text'] = $item->nom;
			$result[] = $a;
		}
		return ['results' => $result];
	}

    // public function users_seeder(){
    //     $role = ['Administrateur', "Employer"];
       
    //     for ($i=0; $i < 200; $i++) { 
    //         $users = [
    //             'nom_prenoms' => 'user'.($i+1),
    //             'email' => 'user'.($i+1).'@gmail.com',
    //             'role' => $role[rand(0,1)],
    //             'statut' => rand(0,1),
    //             'tel' => '12345678',
    //         ];

    //         $this->ivtmodel->add('users', $users);
    //     }
    // }
}
