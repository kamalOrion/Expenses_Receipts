<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(

    'Dashboard/connexion' => array(
        
        array(
            'field' => 'email',
            'label' => 'E-mail',
            'rules' => 'required|valid_email',
            'errors' =>  array(
                'valid_email' => 'E-mail invalide',
                'required' => 'Ce champs est obligatoire'
            )
        ),

        array(
            'field' => 'mdp',
            'label' => 'Mot de passe',
            'rules' => 'required',
            'errors' =>  array(
                'required' => 'Ce champs est obligatoire'
            )
        ),   
    ),

    'Users/mdp_user' => array(  /// (controleur/methode)
        array(
            'field' => 'pass',
            'label' => 'Mot de passe',
            'rules' => 'matches[confirme]|required',
            'errors' =>  array('matches'=>'Mot de passe non identique', 'required' => 'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'confirme',
            'label' => 'Confirmer mot de passe',
            'rules' => 'matches[pass]|required',
            'errors' =>  array('matches'=>'Mot de passe non identique', 'required' => 'Ce champ est obligatoire')
        )     //|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#?§\$%\^&\*])(?=.{8,})/]; 'regex_match' => "Le mot de passe doit être de 8 caractères minimum et doit contenir au moins: une lettre minuscule; une lettre majuscule; un chiffre et un caractère spécial. Ex: Motdepass1@"
    ), 
    
//____________________________________________________________________________________________________________________________________________________________
//Not use
    'Login/create_mdp' => array(  /// (controleur/methode)
        array(
            'field' => 'pwd',
            'label' => 'Mot de passe',
            'rules' => 'required|matches[conf_pwd]',
            'errors' =>  array('required'=>'Ce champ est obligatoire', 'matches'=>'Mots de passe non identiques')
        ), 
        array(
            'field' => 'conf_pwd',
            'label' => 'Confirmer mot de passe',
            'rules' => 'required|matches[pwd]',
            'errors' =>  array('required'=>'Ce champ est obligatoire', 'matches'=>'Mots de passe non identiques')
        ), 
    ), 

    // 'Groupe/ajout' => array(  /// (controleur/methode)
    //     array(
    //         'field' => 'nom',
    //         'label' => 'Nom',
    //         'rules' => 'required|is_unique[groupes.nom]',
    //         'errors' =>  array('required'=>'Ce champ est obligatoire', 'is_unique'=>'Un groupe du même nom existe déja')
    //     ), 
    //     // array(
    //     //     'field' => 'users[]',
    //     //     'label' => 'Utilisateurs',
    //     //     'rules' => 'required',
    //     //     'errors' =>  array('required'=>'Ce champ est obligatoire')
    //     // ), 
        
    // ),


    
    
    'Profil/change_pass' => array(  /// (controleur/methode)
        array(
            'field' => 'actuel_pass',
            'label' => 'Mot de passe actuel',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'nouveau_pass',
            'label' => 'Nouveau mot de passe',
            'rules' => 'required|matches[confirm_pass]',
            'errors' =>  array('required'=>'Ce champ est obligatoire', 'matches'=>'Mot de passe non identique')
        ), 
        array(
            'field' => 'confirm_pass',
            'label' => 'Confirmez le mot de passe',
            'rules' => 'required|matches[nouveau_pass]',
            'errors' =>  array('required'=>'Ce champ est obligatoire', 'matches'=>'Mot de passe non identique')
        )        
    ),

    'Projet/ajout' => array(  /// (controleur/methode)
        array(
            'field' => 'libelle',
            'label' => 'Libelle',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'date_debut',
            'label' => 'Date de début',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'date_fin',
            'label' => 'Date de fin',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        array(
            'field' => 'reference',
            'label' => 'Référence',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        array(
            'field' => 'description',
            'label' => 'Descritopn',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        // array(
        //     'field' => 'superviseur_projet[]',
        //     'label' => 'Superviseur',
        //     'rules' => 'required',
        //     'errors' =>  array('required'=>'Ce champ est obligatoire')
        // ),
    ),

    'Phases/ajout' => array(  /// (controleur/methode)
        array(
            'field' => 'libelle',
            'label' => 'Libelle',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'budget',
            'label' => 'Budget',
            'rules' => 'required|integer',
            'errors' =>  array('required'=>'Ce champ est obligatoire', 'integer'=>'Seul les chiffres sont autorisés')
        ), 
        array(
            'field' => 'poid',
            'label' => 'Poid',
            'rules' => 'required|integer',
            'errors' =>  array('required'=>'Ce champ est obligatoire', 'integer'=>'Seul les chiffres sont autorisés')
        ), 
        array(
            'field' => 'date_debut',
            'label' => 'Date de début',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'date_fin',
            'label' => 'Date de fin',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        array(
            'field' => 'reference',
            'label' => 'Référence',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        array(
            'field' => 'description',
            'label' => 'Descritopn',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        // array(
        //     'field' => 'superviseur_phase[]',
        //     'label' => 'Superviseur',
        //     'rules' => 'required',
        //     'errors' =>  array('required'=>'Ce champ est obligatoire')
        // ),
    ),

    'Activites/ajout' => array(  /// (controleur/methode)
        array(
            'field' => 'libelle',
            'label' => 'Libelle',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
        array(
            'field' => 'budget',
            'label' => 'Budget',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
        // array(
        //     'field' => 'poid',
        //     'label' => 'Poid',
        //     'rules' => 'required',
        //     'errors' =>  array('required'=>'Ce champ est obligatoire')
        // ),
        array(
            'field' => 'priorite',
            'label' => 'Priorite',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        array(
            'field' => 'date_debut',
            'label' => 'Date de début',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'date_fin',
            'label' => 'Date de fin',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        array(
            'field' => 'description',
            'label' => 'Descritopn',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
    ),

    'Activites/affecter_activite_a_projet' => array(  /// (controleur/methode)
        array(
            'field' => 'affect_projet',
            'label' => 'Projet',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'affect_phase',
            'label' => 'Phase',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
    ),

    'Taches/affecter_tache_a_projet' => array(  /// (controleur/methode)
        array(
            'field' => 'affect_projet',
            'label' => 'Projet',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'affect_phase',
            'label' => 'Phase',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
    ),

    'Documents/affecter_document_a_projet' => array(  /// (controleur/methode)
        array(
            'field' => 'affect_projet',
            'label' => 'Projet',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'affect_phase',
            'label' => 'Phase',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
    ),

    'Points_bloquants/affecter_pbloquant_a_phase' => array(  /// (controleur/methode)
        array(
            'field' => 'affect_projet',
            'label' => 'Projet',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'affect_phase',
            'label' => 'Phase',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
    ),

    'Commentaires/ajout' => array(  
        array(
            'field' => 'commentaire',
            'label' => 'Commentaire',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        )
    ),

    'Taches/affecter_tache_a_activite' => array(  
        array(
            'field' => 'tache_activite',
            'label' => 'Activité',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
    ),

    'Documents/affecter_document_a_activite' => array(  
        array(
            'field' => 'document_activite',
            'label' => 'Activité',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
    ),

    'Documents/affecter_document_a_tache' => array(  
        array(
            'field' => 'document_tache',
            'label' => 'Tâche',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
    ),

    'Documents/affecter_document_a_pbloquant' => array(  
        array(
            'field' => 'document_pbloquant',
            'label' => 'Point bloquant',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
    ),

    'Points_bloquants/affecter_pbloquant_a_groupe' => array(  
        array(
            'field' => 'pbloquant_groupe',
            'label' => 'Point bloquant',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
    ),

    'Points_bloquants/affecter_pbloquant_a_activite' => array(  
        array(
            'field' => 'pbloquant_activite',
            'label' => 'Activité',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
    ),

    'Points_bloquants/affecter_pbloquant_a_tache' => array(  
        array(
            'field' => 'pbloquant_tache',
            'label' => 'Tâche',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),
    ),

    'Taches/ajout' => array(  
        array(
            'field' => 'libelle',
            'label' => 'Libelle',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        array(
            'field' => 'date_limite',
            'label' => 'Date limite',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        array(
            'field' => 'priorite',
            'label' => 'priorite',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
        // array(
        //     'field' => 'superviseur_tache[]',
        //     'label' => 'Superviseur',
        //     'rules' => 'required',
        //     'errors' =>  array('required'=>'Ce champ est obligatoire')
        // ),  
        array(
            'field' => 'description',
            'label' => 'Descritopn',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
    ),

    'Documents/ajout' => array(  
        array(
            'field' => 'libelle',
            'label' => 'Libelle',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ) 
    ),

    'Documents/affecter_document_a_groupe' => array(  
        array(
            'field' => 'document_groupe',
            'label' => 'Groupe',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ) 
    ),

    'Points_bloquants/ajout' => array(  /// (controleur/methode)
        array(
            'field' => 'libelle',
            'label' => 'Libelle',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ), 
        // array(
        //     'field' => 'superviseur_pbloquant',
        //     'label' => 'Superviseur',
        //     'rules' => 'required',
        //     'errors' =>  array('required'=>'Ce champ est obligatoire')
        // ),
        array(
            'field' => 'description',
            'label' => 'Descritopn',
            'rules' => 'required',
            'errors' =>  array('required'=>'Ce champ est obligatoire')
        ),  
    ),
);

    

/* End of file ivt_config.php */
/* Location: ./application/config/ivt_config.php */