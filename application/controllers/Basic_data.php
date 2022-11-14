<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Basic_data extends CI_Controller {

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

	public function type_depense()
	{
		$this->check();
		$data = array(
			'title'=> "OMEL | Type de dépenses", //titre de la page
			'content'=>'type_depense', //vue à afficher
		);
		$this->load->view('template/content', $data);
	}

    public function produit()
	{
		$this->check();
		$data = array(
			'title'=> "OMEL | Produits", //titre de la page
			'content'=>'produit', //vue à afficher
		);
		$this->load->view('template/content', $data);
	}

    public function tableType_depensesAjax(){

        $search = $this->ivtmodel->get_search_data('type_depense', $_POST['start'], $_POST['length'], $_POST['search']['value'], $_POST['order'][0]['column'], $_POST['order'][0]['dir'], NULL);
		$output = array(  
                "draw"  => intval($_POST["draw"]),  
                "recordsTotal" => $this->ivtmodel->count_search_data('type_depense', NULL, NULL),
                "recordsFiltered" => $this->ivtmodel->count_search_data('type_depense', $_POST['search']['value'], NULL),
                "data" => $search, 
            ); 
		echo json_encode($output);
	}

    public function tableProduitsAjax(){

        $search = $this->ivtmodel->get_search_data('produits', $_POST['start'], $_POST['length'], $_POST['search']['value'], $_POST['order'][0]['column'], $_POST['order'][0]['dir'], NULL);
		$output = array(  
                "draw"  => intval($_POST["draw"]),  
                "recordsTotal" => $this->ivtmodel->count_search_data('produits', NULL, NULL),
                "recordsFiltered" => $this->ivtmodel->count_search_data('produits', $_POST['search']['value'], NULL),
                "data" => $search, 
            ); 
		echo json_encode($output);
	}

	public function ajout_type_depense(){
        
		if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}

        $flag = isset($_POST['type_depense_id']);
        
        if(!$flag){

            $this->form_validation->set_rules('libelle', 'Libelle', 'required|is_unique[type_depense.libelle]',
                array('required'=>'Ce champs %s est obligatoire', 'is_unique'=>'Un type du même nom existe déja.')
            );
            $this->form_validation->set_rules('description', 'Description', 'required',
                array('required'=>'Ce champs %s est obligatoire')
            );
            $this->form_validation->set_error_delimiters("<span class='error_smg' style='color: red'>", "</span>");

            $validate = $this->form_validation->run();

        } else $validate = true;
        
        if($validate){
            if($this->input->post('libelle')) $data['libelle'] = $this->input->post('libelle');
            if($this->input->post('description')) $data['description'] = $this->input->post('description');
            
                $check = ($flag) ? $this->ivtmodel->update('type_depense', $data, 'type_depense_id', $this->input->post('type_depense_id')) : $this->ivtmodel->add('type_depense', $data);
            
            if($check){
                echo json_encode($flag ? 1 : 0);
            }

        }else{

            echo json_encode([
                "<span class='error_smg'>Erreur lors de l'ajout du type : ".$this->input->post('libelle')."</span>",
				form_error('libelle') !=  '' ? form_error('libelle'): '',
			]);
        }
	}

    public function ajout_produit(){
        
		if($this->check()){
			echo json_encode(['ajax' => 'ajax']);
			exit;
		}

        $flag = isset($_POST['produit_id']);
        
        if(!$flag){

            $this->form_validation->set_rules('libelle', 'Libelle', 'required|is_unique[produits.libelle]',
                array('required'=>'Ce champs %s est obligatoire', 'is_unique'=>'Un type du même nom existe déja.')
            );

            // $this->form_validation->set_rules('prix_unitaire', 'Prix unitaire', 'required|integer',
            //     array('required'=>'Ce champs %s est obligatoire', 'integer'=>'Valeur saisie invalide')
            // );

            $this->form_validation->set_error_delimiters("<span class='error_smg'>", "</span>");

            $validate = $this->form_validation->run();

        } else $validate = true;
        
        if($validate){

            if($_POST['libelle']) $data['libelle'] = $this->input->post('libelle');
            if(isset($_POST['prix_unitaire']) && $_POST['prix_unitaire']) $data['prix_unitaire'] = $this->input->post('prix_unitaire');

            $check = ($flag) ? $this->ivtmodel->update('produits', $data, 'produit_id', $this->input->post('produit_id')) : $this->ivtmodel->add('produits', $data);
            
            if($check){
                echo json_encode($flag ? 1 : 0);
            }

        }else{

            echo json_encode([
                "<span class='error_smg'>Erreur lors de l'ajout du produit : ".$this->input->post('libelle')."</span>",
				form_error('libelle') !=  '' ? form_error('libelle'): '',
                form_error('prix_unitaire') !=  '' ? form_error('prix_unitaire'): '',
			]);
        }
	}

    public function delete_type_depense(){
        echo json_encode($this->ivtmodel->delete('type_depense', 'type_depense_id', $this->input->post('type_depense_id')));
    }

    public function delete_produit(){
        echo json_encode($this->ivtmodel->delete('produits', 'produit_id', $this->input->post('produit_id')));
    }

    // public function type_depense_seeder(){

	// 	// $b = [
	// 	// 	"GUINESS",
	// 	// 	"BEAUFORT ",
	// 	// 	"PILS TOGO",
	// 	// 	"BENINOISE",
	// 	// 	"PANACHE",
	// 	// 	"WORLD COLA",
	// 	// 	"DOPPEL LARGER",
	// 	// 	"TEQUILA",
	// 	// 	"EKU",
	// 	// 	"COCKTAIL / YOUZOU",
	// 	// 	"PAMPLEMOUSSE/MOKA",
	// 	// 	"XXL",
	// 	// 	"EAU MINERALE",
	// 	// 	"PRESSION(FUT)",
	// 	// 	"ROX",
	// 	// 	"HEINEKEN",
	// 	// 	"DESPERADOS",
	// 	// 	"CITRON",
	// 	// 	"NESCAFE",
	// 	// 	"MENTHE FRAICHE",
	// 	// 	"PURE WATER",
	// 	// 	"PAPIER TOILETTE",
	// 	// 	"PAPIER SERVIETTE",
	// 	// 	"PAPIER RAME",
	// 	// 	"PAPIER THERMIQUE",
	// 	// 	"SBEE",
	// 	// 	"JAVEL",
	// 	// 	"AGRAFE",
	// 	// 	"BALAI",
	// 	// 	"PELLE BALAI",
	// 	// 	"DESODORISANT TOILETTE",
	// 	// 	"CHIFFON",
	// 	// 	"LIQUIDE VAISSELLE",
	// 	// 	"THE VERT",
	// 	// 	"SUCRE ROUX",
	// 	// 	"TORCHON ",
	// 	// 	"ANANAS",
	// 	// 	"PASTEQUE",
	// 	// 	"PAPAYE",
	// 	// 	"POMME FRUIT",
	// 	// 	"SERPILLERE",
	// 	// 	"CAMPARI",
	// 	// 	"SUZE",
	// 	// 	"MARTINI ROUGE",
	// 	// 	"MARTINI BLANC",
	// 	// 	"RHUM BLANC",
	// 	// 	"RHUM BRUN",
	// 	// 	"SUCRE DE CANNE",
	// 	// 	"VODKA",
	// 	// 	"ORANGE SEC",
	// 	// 	"GLENFIDICH",
	// 	// 	"TEQUILA",
	// 	// 	"BLACK LABEL",
	// 	// 	"GIN ",
	// 	// 	"JB",
	// 	// 	"RICARD",
	// 	// 	"PASTIS",
	// 	// 	"RED LABEL",
	// 	// 	"SHERIDAN'S",
	// 	// 	"BAILEY's",
	// 	// 	"JACK DANIELS",
	// 	// 	"SIROP DE MENTHE",
	// 	// 	"SIROP DE GRENADINE",
	// 	// 	"MALIBU",
	// 	// 	"COINTREAU",
	// 	// 	"LAIT PEAK",
	// 	// 	"AMPOULE",
	// 	// 	"REABONNEMENT CANAL PLUS",
	// 	// 	"ESSENCE EN LITRES",
	// 	// 	"PAIN LIBANAIS",
	// 	// 	"PAIN HAMBURGER",
	// 	// 	"SAUCE SOJA",
	// 	// 	"POIVRE BLANC MOULU",
	// 	// 	"MAYONNAISE",
	// 	// 	"CHOUX",
	// 	// 	"PAPIER CHAWARMA",
	// 	// 	"KETCHUP PETIT",
	// 	// 	"KETCHUP GRAND",
	// 	// 	"VIANDE CHAWARMA",
	// 	// 	"VIANDE HAMBURGER",
	// 	// 	"LAITUE",
	// 	// 	"OIGNON",
	// 	// 	"TOMATE FRAICHE",
	// 	// 	"BLANC DE POULET",
	// 	// 	"POULET CHAIR",
	// 	// 	"ŒUFS",
	// 	// 	"SPAGHETTI",
	// 	// 	"POMME DE TERRE",
	// 	// 	"CONCOMBRE",
	// 	// 	"CAROTTE",
	// 	// 	"COURGETTE",
	// 	// 	"HARICOT VERT ",
	// 	// 	"BETTERAVE",
	// 	// 	"AIL",
	// 	// 	"GINGEMBRE",
	// 	// 	"ALOKO",
	// 	// 	"FRITES",
	// 	// 	"FRITES",
	// 	// 	"POIVRON",
	// 	// 	"PERSIL",
	// 	// 	"ŒUFS DE CAILLE",
	// 	// 	"THON",
	// 	// 	"CHAMPIGNON",
	// 	// 	"MAIS DOUX",
	// 	// 	"PETIT POIS",
	// 	// 	"CREVETTE FRAIS",
	// 	// 	"FARINE DE BLE",
	// 	// 	"LAIT EN POUDRE",
	// 	// 	"SUCRE",
	// 	// 	"SEL",
	// 	// 	"HUILE DE CUISSON",
	// 	// 	"HUILE DE FRITURE",
	// 	// 	"POISSON CARPE AU KG",
	// 	// 	"POISSON BAR AU KG",
	// 	// 	"SOLE AU KG",
	// 	// 	"GROS BAR AU KG",
	// 	// 	"POULET BICY",
	// 	// 	"CAILLE",
	// 	// 	"LAPIN FRAIS AU KG",
	// 	// 	"ROGNON DE BŒUF",
	// 	// 	"AILERON AU KG",
	// 	// 	"LANGUE DE BŒUF",
	// 	// 	"FILET DE BŒUF AU KG",
	// 	// 	"VIANDE DE MOUTON AU KG",
	// 	// 	"HERBES DE PROVENCE",
	// 	// 	"MOUTARDE",
	// 	// 	"CREME FRAICHE",
	// 	// 	"POIVRE VERT",
	// 	// 	"VINAIGRE",
	// 	// 	"SARDINE",
	// 	// 	"PAPIER ALUMINIUM",
	// 	// 	"PAPIER FILM",
	// 	// 	"BICARBONATE",
	// 	// 	"TOMATE CONCENTREE",
	// 	// 	"TELIBO",
	// 	// 	"MAIS POP CORN",
	// 	// 	"MAIS POUR FARINE",
	// 	// 	"BARQUE EMPORTER PETIT",
	// 	// 	"BARQUE EMPORTER  GRAND",
	// 	// 	"SACHET POUBELLE",
	// 	// 	"SACHET PORTION",
	// 	// 	"SACHET EMPORTER",
	// 	// 	"GARI",
	// 	// 	"TIGE BROCHETTE",
	// 	// 	"PATE D'ARACHIDE",
	// 	// 	"HUILE ROUGE",
	// 	// 	"ASSROKOUIN",
	// 	// 	"KPAMAN",
	// 	// 	"POISSON FUME",
	// 	// 	"CRABE",
	// 	// 	"FROMAGE",
	// 	// 	"GBOMAN",
	// 	// 	"AMANVIVE",
	// 	// 	"TCHIAYO",
	// 	// 	"GAMBAS AU KILO",
	// 	// 	"CALAMAR AU KILO",
	// 	// 	"JAMBON DE DINDE",
	// 	// 	"SAUCISSE",
	// 	// 	"OMO",
	// 	// 	"EPONGE",
	// 	// 	"SPATULE",
	// 	// 	"SAC DE RIZ",
	// 	// 	"KILO DE RIZ",
	// 	// 	"POISSON SECHE",
	// 	// 	"CORNICHON",
	// 	// 	"PIMENT VERT",
	// 	// 	"PIMENT MOULU",
	// 	// 	"CARTON PIZZA",
	// 	// 	"ASSAISONNEMENT COMPOSE",
	// 	// 	"CUBE",
	// 	// 	"MOZZARELLA",
	// 	// 	"COUPE PIZZA",
	// 	// 	"MANWE",
	// 	// 	"AGBELI",
	// 	// 	"ATCHEKE",
	// 	// 	"GBOTA",
	// 	// 	"GAZ",
	// 	// 	"4 EPICES",
	// 	// 	"DETENTEUR",
	// 	// 	"RACCORD",
	// 	// 	"PINCEAUX",
	// 	// 	"PAIN LIBANAIS",
	// 	// 	"PAIN HAMBURGER",
	// 	// 	"SAUCE SOJA",
	// 	// 	"POIVRE BLANC MOULU",
	// 	// 	"MAYONNAISE",
	// 	// 	"CHOUX",
	// 	// 	"PAPIER CHAWARMA",
	// 	// 	"KETCHUP PETIT",
	// 	// 	"KETCHUP GRAND",
	// 	// 	"VIANDE CHAWARMA",
	// 	// 	"VIANDE HAMBURGER",
	// 	// 	"LAITUE",
	// 	// 	"OIGNON",
	// 	// 	"TOMATE FRAICHE",
	// 	// 	"BLANC DE POULET",
	// 	// 	"POULET CHAIR",
	// 	// 	"ŒUFS",
	// 	// 	"SPAGHETTI",
	// 	// 	"POMME DE TERRE",
	// 	// 	"CONCOMBRE",
	// 	// 	"CAROTTE",
	// 	// 	"COURGETTE",
	// 	// 	"HARICOT VERT ",
	// 	// 	"BETTERAVE",
	// 	// 	"AIL",
	// 	// 	"GINGEMBRE",
	// 	// 	"ALOKO",
	// 	// 	"FRITES",
	// 	// 	"FRITES",
	// 	// 	"POIVRON",
	// 	// 	"PERSIL",
	// 	// 	"ŒUFS DE CAILLE",
	// 	// 	"THON",
	// 	// 	"CHAMPIGNON",
	// 	// 	"MAIS DOUX",
	// 	// 	"PETIT POIS",
	// 	// 	"CREVETTE FRAIS",
	// 	// 	"FARINE DE BLE",
	// 	// 	"LAIT EN POUDRE",
	// 	// 	"SUCRE",
	// 	// 	"SEL",
	// 	// 	"HUILE DE CUISSON",
	// 	// 	"HUILE DE FRITURE",
	// 	// 	"POISSON CARPE AU KG",
	// 	// 	"POISSON BAR AU KG",
	// 	// 	"SOLE AU KG",
	// 	// 	"GROS BAR AU KG",
	// 	// 	"POULET BICY",
	// 	// 	"CAILLE",
	// 	// 	"LAPIN FRAIS AU KG",
	// 	// 	"ROGNON DE BŒUF",
	// 	// 	"AILERON AU KG",
	// 	// 	"LANGUE DE BŒUF",
	// 	// 	"FILET DE BŒUF AU KG",
	// 	// 	"VIANDE DE MOUTON AU KG",
	// 	// 	"HERBES DE PROVENCE",
	// 	// 	"MOUTARDE",
	// 	// 	"CREME FRAICHE",
	// 	// 	"POIVRE VERT",
	// 	// 	"VINAIGRE",
	// 	// 	"SARDINE",
	// 	// 	"PAPIER ALUMINIUM",
	// 	// 	"PAPIER FILM",
	// 	// 	"BICARBONATE",
	// 	// 	"TOMATE CONCENTREE",
	// 	// 	"TELIBO",
	// 	// 	"MAIS POP CORN",
	// 	// 	"MAIS POUR FARINE",
	// 	// 	"BARQUE EMPORTER PETIT",
	// 	// 	"BARQUE EMPORTER  GRAND",
	// 	// 	"SACHET POUBELLE",
	// 	// 	"SACHET PORTION",
	// 	// 	"SACHET EMPORTER",
	// 	// 	"GARI",
	// 	// 	"TIGE BROCHETTE",
	// 	// 	"PATE D'ARACHIDE",
	// 	// 	"HUILE ROUGE",
	// 	// 	"ASSROKOUIN",
	// 	// 	"KPAMAN",
	// 	// 	"POISSON FUME",
	// 	// 	"CRABE",
	// 	// 	"FROMAGE",
	// 	// 	"GBOMAN",
	// 	// 	"AMANVIVE",
	// 	// 	"TCHIAYO",
	// 	// 	"GAMBAS AU KILO",
	// 	// 	"CALAMAR AU KILO",
	// 	// 	"JAMBON DE DINDE",
	// 	// 	"SAUCISSE",
	// 	// 	"OMO",
	// 	// 	"EPONGE",
	// 	// 	"SPATULE",
	// 	// 	"SAC DE RIZ",
	// 	// 	"KILO DE RIZ",
	// 	// 	"POISSON SECHE",
	// 	// 	"CORNICHON",
	// 	// 	"PIMENT VERT",
	// 	// 	"PIMENT MOULU",
	// 	// 	"CARTON PIZZA",
	// 	// 	"ASSAISONNEMENT COMPOSE",
	// 	// 	"CUBE",
	// 	// 	"MOZZARELLA",
	// 	// 	"COUPE PIZZA",
	// 	// 	"MANWE",
	// 	// 	"AGBELI",
	// 	// 	"ATCHEKE",
	// 	// 	"GBOTA",
	// 	// 	"GAZ",
	// 	// 	"4 EPICES",
	// 	// 	"DETENTEUR",
	// 	// 	"RACCORD",
	// 	// 	"PINCEAUX",
	// 	// ];

	// 	$b2 = [
	// 		"GUINESS",
	// 		"BEAUFORT ",
	// 		"PILS TOGO",
	// 		"BENINOISE",
	// 		"PANACHE",
	// 		"WORLD COLA",
	// 		"DOPPEL LARGER",
	// 		"TEQUILA",
	// 		"EKU",
	// 		"COCKTAIL / YOUZOU",
	// 		"PAMPLEMOUSSE/MOKA",
	// 		"XXL",
	// 		"EAU MINERALE",
	// 		"PRESSION(FUT)",
	// 		"ROX",
	// 		"HEINEKEN",
	// 		"DESPERADOS",
	// 		"CITRON",
	// 		"NESCAFE",
	// 		"MENTHE FRAICHE",
	// 		"PURE WATER",
	// 		"PAPIER TOILETTE",
	// 		"PAPIER SERVIETTE",
	// 		"PAPIER RAME",
	// 		"PAPIER THERMIQUE",
	// 		"SBEE",
	// 		"JAVEL",
	// 		"AGRAFE",
	// 		"BALAI",
	// 		"PELLE BALAI",
	// 		"DESODORISANT TOILETTE",
	// 		"CHIFFON",
	// 		"LIQUIDE VAISSELLE",
	// 		"THE VERT",
	// 		"SUCRE ROUX",
	// 		"TORCHON ",
	// 		"ANANAS",
	// 		"PASTEQUE",
	// 		"PAPAYE",
	// 		"POMME FRUIT",
	// 		"SERPILLERE",
	// 		"CAMPARI",
	// 		"SUZE",
	// 		"MARTINI ROUGE",
	// 		"MARTINI BLANC",
	// 		"RHUM BLANC",
	// 		"RHUM BRUN",
	// 		"SUCRE DE CANNE",
	// 		"VODKA",
	// 		"ORANGE SEC",
	// 		"TEQUILA",
	// 		"BLACK LABEL",
	// 		"GIN ",
	// 		"JB",
	// 		"RICARD",
	// 		"PASTIS",
	// 		"RED LABEL",
	// 		"SHERIDAN'S",
	// 		"BAILEY's",
	// 		"JACK DANIELS",
	// 		"SIROP DE MENTHE",
	// 		"SIROP DE GRENADINE",
	// 		"MALIBU",
	// 		"COINTREAU",
	// 		"LAIT PEAK",
	// 		"AMPOULE",
	// 		"REABONNEMENT CANAL PLUS",
	// 		"ESSENCE EN LITRES",
	// 		"PAILLE",
	// 		"PIQUE DENT",
	// 		"PAIN LIBANAIS",
	// 		"PAIN HAMBURGER",
	// 		"SAUCE SOJA",
	// 		"POIVRE BLANC MOULU",
	// 		"MAYONNAISE",
	// 		"CHOUX",
	// 		"PAPIER CHAWARMA",
	// 		"KETCHUP PETIT",
	// 		"KETCHUP GRAND",
	// 		"VIANDE CHAWARMA",
	// 		"VIANDE HAMBURGER",
	// 		"LAITUE",
	// 		"OIGNON",
	// 		"TOMATE FRAICHE",
	// 		"BLANC DE POULET",
	// 		"POULET CHAIR",
	// 		"ŒUFS",
	// 		"SPAGHETTI",
	// 		"POMME DE TERRE",
	// 		"CONCOMBRE",
	// 		"CAROTTE",
	// 		"COURGETTE",
	// 		"HARICOT VERT",
	// 		"BETTERAVE",
	// 		"AIL",
	// 		"GINGEMBRE",
	// 		"ALOKO",
	// 		"FRITES",
	// 		"FRITES",
	// 		"POIVRON",
	// 		"PERSIL",
	// 		"ŒUFS DE CAILLE",
	// 		"THON",
	// 		"CHAMPIGNON",
	// 		"MAIS DOUX",
	// 		"PETIT POIS",
	// 		"CREVETTE FRAIS",
	// 		"FARINE DE BLE",
	// 		"LAIT EN POUDRE",
	// 		"SUCRE",
	// 		"SEL",
	// 		"HUILE DE CUISSON",
	// 		"HUILE DE FRITURE",
	// 		"POISSON CARPE AU KG",
	// 		"POISSON BAR AU KG",
	// 		"SOLE AU KG",
	// 		"GROS BAR AU KG",
	// 		"POULET BICY",
	// 		"CAILLE",
	// 		"LAPIN FRAIS AU KG",
	// 		"ROGNON DE BŒUF",
	// 		"AILERON AU KG",
	// 		"LANGUE DE BŒUF",
	// 		"FILET DE BŒUF AU KG",
	// 		"VIANDE DE MOUTON AU KG",
	// 		"HERBES DE PROVENCE",
	// 		"MOUTARDE",
	// 		"CREME FRAICHE",
	// 		"POIVRE VERT",
	// 		"VINAIGRE",
	// 		"SARDINE",
	// 		"PAPIER ALUMINIUM",
	// 		"PAPIER FILM",
	// 		"BICARBONATE",
	// 		"TOMATE CONCENTREE",
	// 		"TELIBO",
	// 		"MAIS POP CORN",
	// 		"MAIS POUR FARINE",
	// 		"BARQUE EMPORTER PETIT",
	// 		"BARQUE EMPORTER  GRAND",
	// 		"SACHET POUBELLE",
	// 		"SACHET PORTION",
	// 		"SACHET EMPORTER",
	// 		"GARI",
	// 		"TIGE BROCHETTE",
	// 		"PATE D'ARACHIDE",
	// 		"HUILE ROUGE",
	// 		"ASSROKOUIN",
	// 		"KPAMAN",
	// 		"POISSON FUME",
	// 		"CRABE",
	// 		"FROMAGE",
	// 		"GBOMAN",
	// 		"AMANVIVE",
	// 		"TCHIAYO",
	// 		"GAMBAS AU KILO",
	// 		"CALAMAR AU KILO",
	// 		"JAMBON DE DINDE",
	// 		"SAUCISSE",
	// 		"OMO",
	// 		"EPONGE",
	// 		"SPATULE",
	// 		"SAC DE RIZ",
	// 		"KILO DE RIZ",
	// 		"POISSON SECHE",
	// 		"CORNICHON",
	// 		"PIMENT VERT",
	// 		"PIMENT MOULU",
	// 		"CARTON PIZZA",
	// 		"ASSAISONNEMENT COMPOSE",
	// 		"CUBE",
	// 		"MOZZARELLA",
	// 		"COUPE PIZZA",
	// 		"MANWE",
	// 		"AGBELI",
	// 		"ATCHEKE",
	// 		"GBOTA",
	// 		"GAZ",
	// 		"4 EPICES",
	// 		"DETENTEUR",
	// 		"RACCORD",
	// 		"CESAME",
	// 		"ANCHOIX",
	// 		"OLIVE NOIRE",
	// 		"LEVURE BOULANGERE",
	// 		"PINCEAUX"
	// 	];
       
    //     foreach ($b2 as $dep) { 
    //         $depense = [
	// 			'libelle' => $dep,
	// 			'description' => ''
    //         ];

    //         $this->ivtmodel->add('type_depense', $depense);
    //     }
    // }

    // public function produit_seeder(){

    //     $a = [
    //         "CHAWARMA VIANDE",
    //         "CHAWARMA POULET",
    //         "CHAWARMA CAILLE",
    //         "ASSIETTE CHAWARMA",
    //         "HAMBURGER",
    //         "ASSSIETTE HAMBURGER",
    //         "BROCHETTE DE FRUITS",
    //         "SALADE DE FRUITS",
    //         "BOULE DE GLACE",
    //         "ANANAS EN PIROGUE",
    //         "SANDWICH POISSON",
    //         "SANDWICH VIANDE",
    //         "SPAGHETTI AVEC OMELETTE",
    //         "SPAGHETTI AVEC VIANDE",
    //         "SALADE COMPOSEE",
    //         "SALADE AUX ŒUFS DE CAILLE",
    //         "SALADE O'MEL",
    //         "SALADE D'AVOCAT AU THON",
    //         "AVOCAT AUX CREVETTES",
    //         "CREPE FARCIE",
    //         "SOUPE DE POISSON",
    //         "SOUPE DE LEGUMES",
    //         "LANGUE DE BŒUF EN SAUCE",
    //         "CAILLE BRAISE OU GRILLE",
    //         "CAILLE A LA PROVENCALE",
    //         "YASSA DE CAILLE",
    //         "FRICASSE DE CAILLE O'MEL",
    //         "LAPIN BRAISE OU GRILLE",
    //         "AILERON BRAISE OU FRIT",
    //         "VIANDE DE MOUTON BRAISE",
    //         "BROCHETTE DE BŒUF",
    //         "FILET DE BŒUF A LA CREME",
    //         "FILET DE BŒUF AU POIVRE VERT",
    //         "ROGNON DE BŒUF A LA CREME",
    //         "LANGUE DE BŒUF BRAISE OU GRILLE",
    //         "ROGNON DE BŒUF A L'AIL",
    //         "BROCHETTE DE POISSON",
    //         "POISSON BRAISE",
    //         "FILET DE POISSON A LA CREME",
    //         "FILET DE SOLE PERSILLE",
    //         "SOLE MEUNIERE",
    //         "ACCOMPAGNEMENT SUPPLEMENTAIRE",
    //         "SAUCE TOMATE POISSON FRAIS",
    //         "SAUCE ARACHIDE (MOUTON)",
    //         "SAUCE ASSROKOUIN",
    //         "SAUCE LEGUMES",
    //         "DAKOUIN",
    //         "BOMIWO(POULET OU CAILLE)",
    //         "GAMBAS SAUTEES",
    //         "BROCHETTE DE GAMBAS",
    //         "CREVETTES GRILLEES OU EN SAUCE",
    //         "CALAMAR A LA PROVENCALE",
    //         "PIZZA VEGETARIENNE",
    //         "PIZZA MEXICAINE",
    //         "PIZZA MARGARITA",
    //         "PIZZA ASTERIX",
    //         "PIZZA AMERICAINE",
    //         "PIZZA RIO",
    //         "PIZZA HOT DOG",
    //         "PIZZA MARINIERE",
    //         "PIZZA FRUITS DE MER",
    //         "PIZZA O'MEL",
    //         "PIZZA MINI FORMAT",
    //         "CONSO MARTINI",
    //         "CONSO SUZE",
    //         "CONSO RICARD",
    //         "CONSO PASTIS",
    //         "CONSO CAMPARI",
    //         "CONSO MALIBU",
    //         "CONSO RHUM BRUM",
    //         "CONSO RHUM BLANC",
    //         "CONSO BAILEY'S",
    //         "CONSO SHERIDAN'S",
    //         "CONSO JB",
    //         "CONSO BLACK LABEL",
    //         "CONSO RED LABEL",
    //         "CONSO CHIVAS REGAL",
    //         "CONSO JACK DANIELS",
    //         "CONSO GLENFIDICH",
    //         "CONSO ORANGE SEC",
    //         "CONSO COINTREAU",
    //         "CONSO GIN/ TEQUILA / VODKA",
    //         "SOIF SANS ALCOOL",
    //         "CINDERELLA SANS ALCOOL",
    //         "CHANTACCO",
    //         "RIVERT",
    //         "AMERICANO",
    //         "TI PUNCH",
    //         "INDIAN SUMMER",
    //         "PERROQUET",
    //         "O'MEL",
    //         "CASTEL",
    //         "BENINOISE",
    //         "PILS",
    //         "BEAUFORT",
    //         "DOPPEL LARGER",
    //         "EKU",
    //         "GUINESS",
    //         "HEINEKEN",
    //         "DESPERADOS",
    //         "PRESSION 0,5L",
    //         "SUCRERIE",
    //         "PANACHE/ TEQUILA",
    //         "EAUX MINERALES GRAND",
    //         "POSSO CITRON",
    //         "POSSO GAZ",
    //         "ROX",
    //         "XXL",
    //         "JUS DE FRUITS NATURELS",
    //         "THE",
    //         "CAFE EXPRESSO",
    //         "NESCAFE",
    //         "SIROP MENTHE OU GRENADINE",
    //         "CONSO VIN",
    //         "BOUTEILLE DE VIN",
    //         "BOUTEILLE DE VIN",
    //         "BOUTEILLE DE VIN",
    //         "CONSO REMY MARTIN",
    //         "CONSO AMAGNAC",
    //         "CONSO CALVADOS",
    //         "CONSO COGNAC"
    //     ];
       
    //     foreach($a as $val){ 
    //         $prod = [
    //             'libelle' => $val
    //         ];

    //         $this->ivtmodel->add('produits', $prod);
    //     }
    // }
}
