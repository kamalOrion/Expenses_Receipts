<?php

class User {
    
    public $useri_id;
    public $nom;
    public $email;
    public $mdp;
    public $role;
    public $statut;
    public $tel;
    public $type;
    public $privilege;


    private $table = 'users';
    private $user;

    public function __construct($identifier){

        $this->ci =& get_instance();
        $this->ci->load->model('ivtmodel');
        $this->ivtmodel = $this->ci->ivtmodel; 

        $user = (is_numeric($identifier)) ? $this->ivtmodel->getItem($this->table, 'user_id', $identifier) : ((is_string($identifier) && strpos($identifier, '@')) ? $this->ivtmodel->getItem($this->table, 'email', $identifier) : '');

        if($user){
            $this->useri_id = $user->useri_id;
            $this->nom = $user->nom;
            $this->email = $user->email;
            $this->mdp = $user->mdp;
            $this->role = $user->role;
            $this->statut = $user->statut;
            $this->tel = $user->tel;
            $this->type = $user->type;
            $this->privilege = $user->privilege;
        }

        $this->user = $user;

    }

    public function getId(){
        return $this->user;
    }

    public function setId($value){
        $this->user = $value;
    }

    public function se_connecter( $email, $password ) {

        $user = $this->ivtmodel->getItem("users", "email", $email)[0]; //from base de données   
        $acc = explode("§", $user->access);
        $access = array();
        if(!empty($acc)){
        	foreach ($acc as $key) {
        	$a = explode("/", $key);
            	foreach ($a as $key) {
            		array_push($access, $key);
            	}
            }  
        }  
        if (( $user != NULL) && password_verify($password, $user->mdp) && $user->statut == "Actif") {
            $this->session->user = [
                'id' => $user->id,
                'email' => $user->email,
                'nom' => $user->nom,
                'prenoms' => $user->prenom,
                'tel' =>$user->tel,
                'civilite' =>$user->civilite,
                'privilege' =>$user->privilege,
                'access' => $access,
                'access0' => $user->access
            ];
            return true;
              
        } else {
            $this->se_deconnecter();
            return false;
        }
    }

}