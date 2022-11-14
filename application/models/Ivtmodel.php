<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ivtmodel extends CI_Model {

	public function __construct()
	{
		parent::__construct();//contructeur de la classe
	}

	private $dashboard_vue = "(select d.date_enreg AS date,s.nom AS structure,'Dépense' AS type,td.libelle AS intitule,(d.prix_unitaire * d.qte) AS montant,u.nom_prenoms AS auteur,d.mode_paiement AS mode_paiement from depenses d join type_depense td on((d.type_depense_id = td.type_depense_id))) join users u on((d.user_id = u.user_id))) join structures s on((s.structure_id = u.structure_id))) union select v.date_enreg AS date,s.nom AS structure,'Vente' AS type,p.libelle AS intitule,(v.prix_unitaire * v.qte) AS montant,u.nom_prenoms AS auteur,v.mode_paiement AS mode_paiement from ventes v join produits p on((p.produit_id = v.produit_id))) join users u on((v.user_id = v.user_id))) join structures s on((s.structure_id = u.structure_id))) order by date desc) as dashboard";
	
	//ajouter 	
	public function add($table,$data)	{
		$this->db->insert($table,$data);
		return true;
	}	
	
	//update
	public function update($table,$data,$cle, $valeur){
		return $this->db->update($table,$data,array($cle => $valeur));		
	}

	//update
	public function delete($table,$cle, $valeur){
		is_array($valeur) ? $this->db->delete($table,$valeur) : $this->db->delete($table,array($cle => $valeur));									
		return true;
	}
	
	//liste
	public function getListe($table,$ordercle,$dir,$like=null,$where=null,$limit=null)	{
		$q = $this->db->select('*')->from($table)
		->order_by($ordercle,$dir);
		if ($where) {
            $this->db->where($where);
        }
		if($like){
            $this->db->like($like[0], $like[1]);
        }
        if ($limit){
            $this->db->limit($limit);
        }
        $q = $this->db->get();
		
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function get_depenses_non_valide($depense_id = NULL, $text = NULL){

		$query = $this->db->query('
			SELECT d.*, td.libelle, td.type_depense_id, u.nom_prenoms 
			FROM depenses d
			JOIN type_depense td
			ON d.type_depense_id = td.type_depense_id
			JOIN users u
			ON d.user_id = u.user_id
			WHERE d.statut = 0 
			AND liste_depense_valide_id = 0'.
			(!allowed('CTD') ? " AND d.user_id = ".$this->session->userdata('user_id') : '').
			($depense_id ? ' AND d.depense_id = '.$depense_id : '').
			($text ? " AND ( u.nom_prenoms LIKE '%$text%' OR td.libelle LIKE '%$text%' OR d.prix_unitaire LIKE '%$text%' OR d.mode_paiement LIKE '%$text%' OR d.qte LIKE '%$text%') ": '')
			.' ORDER BY depense_id DESC
		');

		return $query->result();
	}

	public function get_ventes_non_groupe($vente_id = NULL, $text = NULL){

		$query = $this->db->query('
			SELECT v.*, p.libelle, p.produit_id, v.prix_unitaire, u.nom_prenoms 
			FROM ventes v
			JOIN produits p
			ON v.produit_id = p.produit_id
			JOIN users u
			ON v.user_id = u.user_id
			WHERE v.statut = 0 '.
			(!allowed('CTV') ? " AND v.user_id = ".$this->session->userdata('user_id') : '').
			($vente_id ? " AND v.vente_id = $vente_id" : '').
			($text ? " AND ( u.nom_prenoms LIKE '%$text%' OR p.libelle LIKE '%$text%' OR v.prix_unitaire LIKE '%$text%' OR v.mode_paiement LIKE '%$text%' OR v.qte LIKE '%$text%') ": '')
			.' ORDER BY vente_id DESC
		');

		return $query->result();
	}

	public function get_depenses_valide_list($liste_depense_valide_id){

		$query = $this->db->query('
			SELECT d.*, td.libelle, td.type_depense_id, u.nom_prenoms 
			FROM depenses d
			JOIN type_depense td
			ON d.type_depense_id = td.type_depense_id
			JOIN users u
			ON d.user_id = u.user_id
			WHERE d.statut = 1 
			AND d.liste_depense_valide_id = '.$liste_depense_valide_id
			.' ORDER BY depense_id DESC
		');

		return $query->result();
	}

	public function get_liste_vente_recette($recette_id){

		$query = $this->db->query('
			SELECT v.*, p.libelle, p.produit_id, v.prix_unitaire, u.nom_prenoms 
			FROM ventes v
			JOIN produits p
			ON v.produit_id = p.produit_id
			JOIN users u
			ON v.user_id = u.user_id
			WHERE v.statut = 1 
			AND v.recette_id = '.$recette_id 
			.' ORDER BY vente_id DESC
		');

		return $query->result();
	}

	public function get_depenses_effectue(){

		$query = $this->db->query('
			SELECT ldv.*, u.nom_prenoms, COUNT(de.liste_depense_valide_id) as nbr_depense_valide, SUM(de.prix_unitaire * de.qte) as montant_total
			FROM liste_depenses_valides ldv
			JOIN depenses de
			ON ldv.liste_depenses_valides_id = de.liste_depense_valide_id
			JOIN users u
			ON ldv.auteur_id = u.user_id
			WHERE de.statut = 1 
			GROUP BY de.liste_depense_valide_id
			ORDER BY liste_depense_valide_id DESC
		');

		return $query->result();
	}

	public function get_depenses_valide($text = NUll){

		$query = $this->db->query('
			SELECT d.*, td.libelle, td.type_depense_id, u.nom_prenoms 
			FROM depenses d
			JOIN type_depense td
			ON d.type_depense_id = td.type_depense_id
			JOIN users u
			ON d.user_id = u.user_id
			WHERE d.statut = 1 
			AND liste_depense_valide_id = 0 '.
			(!allowed('CTD') ? " AND d.user_id = ".$this->session->userdata('user_id') : '').
			($text ? " AND ( u.nom_prenoms LIKE '%$text%' OR td.libelle LIKE '%$text%' OR d.prix_unitaire LIKE '%$text%' OR d.mode_paiement LIKE '%$text%' OR d.qte LIKE '%$text%' ) ": '')
			.' ORDER BY depense_id DESC
		');

		return $query->result();
	}

	public function get_recette(){

		$query = $this->db->query('
			SELECT r.*, u.nom_prenoms, COUNT(v.recette_id) as nbr_recette, SUM(v.prix_unitaire * v.qte) as montant_total
			FROM recettes r
			JOIN ventes v
			ON r.recette_id = v.recette_id
			JOIN users u
			ON r.auteur_id = u.user_id
			JOIN produits p
			ON p.produit_id = v.produit_id
			WHERE v.statut = 1 
			GROUP BY v.recette_id
			ORDER BY r.recette_id DESC
		');

		return $query->result();
	}

	public function get_user_privilege($user_id){

		$query = $this->db->query("
			SELECT g.privileges
			FROM groupes g
			JOIN jonction_user_groupe jug
			ON g.groupe_id = jug.groupe_id
			JOIN users u
			ON u.user_id = jug.user_id
			WHERE g.statut = 1 
			AND jug.user_id = $user_id
			");

		return $query->result();
	}

	public function get_last_price($table, $order_cle, $item_cle, $item_val){
		$q = $this->db->select('prix_unitaire')->from($table)
		->where($item_cle, $item_val)
		->order_by($order_cle, "DESC")
		->limit(1)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function getListeWhereArray($select, $table, $where, $group_by=null, $order_by=null, $order=null)	{
		// var_dump($order_by);exit();
		$q = $this->db->select($select)->from($table)
		->where($where) ;
		if ($group_by) {
            $this->db->group_by($group_by);
        }
        if ($order_by) {
            $this->db->order_by($order_by,$order);
        }
        $q = $this->db->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	//item
	public function getItem($table, $cle, $valeur){
		$q = $this->db->select('*')->from($table)
		->where($cle,$valeur)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}	

	public function getItemLikeBoth($table,$cle, $valeur)	{
		$q = $this->db->select('*')->from($table)
		->like($cle,$valeur,'both')
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}	

	public function getItem2Where($table,$cle1, $valeur1,$cle2, $valeur2,$ordercle,$dir)	{
		$q = $this->db->select('*')->from($table)
		->order_by($ordercle,$dir)
		->where($cle1,$valeur1)
		->where($cle2,$valeur2)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}	

	//liste jointure
	public function getListeUnJointure($selection,$table,$table1,$cle1,$cletable1)	{
		$q = $this->db->select($selection)->from($table)
		->join($table1, $cle1.'='.$cletable1)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function getListeUnJointureWhere($selection,$table,$table1,$cletable1,$cletable2,$cle,$valeur)	{
		$q = $this->db->select($selection)->from($table)
		->join($table1, $cletable1.'='.$cletable2)
		->where($cle,$valeur)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function getListeDeuxJointure($selection,$table,$table1,$table2,$cle1,$cle2,$cletable1,$cletable2)	{
		$q = $this->db->select($selection)->from($table)
		->join($table1, $cle1.'='.$cletable1)
		->join($table2, $cle2.'='.$cletable2)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function getListeDeuxJointureWhere($selection,$table,$table1,$table2,$cle1,$cle2,$cletable1,$cletable2,$cle,$valeur)	{
		$q = $this->db->select($selection)->from($table)
		->join($table1, $cle1.'='.$cletable1)
		->join($table2, $cle2.'='.$cletable2)
		->where($cle,$valeur)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function se_connecter( $email, $password ) {

        $user = $this->getItem("users", "email", $email); //from base de données  
        
        if (( $user ) && password_verify($password, $user[0]->mdp) && ($user[0]->user_id == 1 || ($user[0]->statut == "Actif" && $this->getItem("structures", "structure_id", $user[0]->structure_id)[0]->statut == 1))) {

			$user = $user[0];

			$priv = $this->ivtmodel->get_user_privilege($user->user_id);
			$string = '';

			foreach ($priv as $priv_string) {
				$string.= '/'.$priv_string->privileges;
			}
			
			$priv = explode("/", $string);
			$priv = array_unique($priv);

            $this->session->set_userdata([

                'user_id' => $user->user_id,
                'nom_prenoms' => $user->nom_prenoms,
                'email' => $user->email,
                'privileges' => $priv,
				'statut' =>$user->statut,
                'tel' =>$user->tel,
                
            ]) ;

            return true;
              
        } else {
            $this->se_deconnecter();
            return false; 
        }
    }

	public function is_logged()	{
		//renvoi les donnees de session
		return ($this->session->userdata('user_id')) ? true : false;
	}	

	public function getListeLimit($table,$debut,$nombre, $order, $dir,$cols_recherche,$recherche)	{
		if($order !=null) {
            $this->db->order_by($order, $dir);
		}		
		if($recherche !=null) {
			$i=0;
			foreach ($cols_recherche as $item) {// loop column 
				if ($item=="datedoc" OR $item=="BOOKING_DATE"){
					$recherche_array=explode("/",$recherche);
					if (count($recherche_array)==2)
					$recherche=$recherche_array[1]."-".$recherche_array[0];
					if (count($recherche_array)==3)
					$recherche=$recherche_array[2]."-".$recherche_array[1]."-".$recherche_array[0];
				}
				if($i===0){ // first loop
					$this->db->group_start(); // open bracket.
					$this->db->like($item,$recherche);
				}
				else{
					$this->db->or_like($item, $recherche);
				}
	
				if(count($cols_recherche) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
				$i++;
				
			}		
		}

        $this->db->limit($nombre,$debut);

		$q = $this->db->select('*')->from($table)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	//liste V2
	public function getListeBetween($table,$champdate,$debut,$fin)	{
		$q = $this->db->select('*')->from($table)
		->where($champdate.' BETWEEN "'. date('Y-m-d', strtotime($debut)). '" and "'. date('Y-m-d', strtotime($fin)).'"')		
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	//existe
	public function existe($table,$cle, $valeur){
		$q = $this->db->select('*')->from($table)
		->where($cle,$valeur)
		->get();
			if($q->num_rows()>0){
				return true;
			}else{
				return false;
			}
	}	

	public function existeDouble($table,$cle1, $valeur1,$cle2, $valeur2){
		$q = $this->db->select('*')->from($table)
		->where($cle1,$valeur1)
		->where($cle2,$valeur2)
		->get();
		if($q->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}		

	public function getLastItem($table, $order_cle)	{
		$q = $this->db->select('*')->from($table)
		->order_by($order_cle, "DESC")
		->limit(1)
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function getLastItemWhere($table, $where)	{
		$q = $this->db->select('*')->from($table)
		->where($where)
		->order_by("id", "DESC")
		->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function saveItem($data, $la_table) {
		
        if (isset($data["id"])) {
            $this->db->where('id', $data["id"])
                 -> update($la_table, $data);
        } else {
           
            $this->db->insert($la_table, $data);
            $id = $this->db->insert_id();
            /*$this->getItem_new($id, TRUE);*/
        }
        return 1;
    }

    protected function effacer_session() {
        $this->session->user = NULL;
    }

    public function se_deconnecter() {
        $this->effacer_session();
        session_destroy();
    }

	public function getListeUnJointureWhereArray($selection,$table,$table1,$cletable1,$cletable2,$where = NULL, $limit = NULL) {
		($limit != NULL) ? $this->db->limit($limit) : "";
		$q = $this->db->select($selection)->from($table)
		->join($table1, $cletable1.'='.$cletable2);
		if($where){
			$this->db->where($where);
		}
		$q = $this->db->get();
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
	}

	public function getDashData($date = NULL){
		
		$query = $this->db->query('
			SELECT CAST(v.date_enreg AS DATE) as date, COUNT(v.vente_id) as nbr_vente, SUM(qte * prix_unitaire) as montant
			FROM ventes v
			JOIN users u
			ON v.user_id = u.user_id
			WHERE MONTH(v.date_enreg) = MONTH('.($date ? "'".$date."'" : 'CURRENT_DATE()').')
			GROUP BY date
			ORDER BY date DESC
		');

		return $query->result();
	}

	private function dashboard_query($text, $length = NULL, $start = NULl){

		return "

			SELECT d.date_enreg AS date, s.nom AS structure, 'Depense' AS type, td.libelle AS intitule, (d.prix_unitaire * d.qte) AS montant, u.nom_prenoms AS auteur, d.mode_paiement  
			FROM depenses d 
			JOIN type_depense td
			ON d.type_depense_id = td.type_depense_id 
			JOIN users u
			ON d.user_id = u.user_id 
			JOIN structures s
			ON s.structure_id = u.structure_id
			WHERE d.statut = 1".
			($text ? " AND d.date_enreg LIKE '%$text%' OR s.nom LIKE '%$text%' OR 'Depense' LIKE '%$text%' OR td.libelle LIKE '%$text%' OR (d.prix_unitaire * d.qte) LIKE '%$text%' OR u.nom_prenoms LIKE '%$text%' OR d.mode_paiement LIKE '%$text%'": '')."
			
			UNION
			
			SELECT v.date_enreg AS date, s.nom AS structure, 'Vente' AS type, p.libelle AS intitule, (v.prix_unitaire * v.qte) AS montant, u.nom_prenoms AS auteur, v.mode_paiement
			FROM ventes v 
			JOIN produits p
			ON p.produit_id = v.produit_id 
			JOIN users u
			ON v.user_id = u.user_id 
			JOIN structures s
			ON s.structure_id = u.structure_id ".
			($text ? " WHERE v.date_enreg LIKE '%$text%' OR s.nom LIKE '%$text%' OR 'Vente' LIKE '%$text%' OR p.libelle LIKE '%$text%' OR (v.prix_unitaire * v.qte) LIKE '%$text%' OR u.nom_prenoms LIKE '%$text%' OR mode_paiement LIKE '%$text%'": '')."
			
			ORDER BY date DESC ".
			($length ? " LIMIT $start, $length " : '');
	}

	//DataTable function for all table ----------------------------------------------
	public function get_search_data($table, $start, $length, $text = NULL, $col_num = NUll, $col_dir = NULL, $where = NULL){

		// var_dump($table, $priv_flag, $where);
        // exit;
		if($table != 'dashboard'){
			if($table == 'structures'){
				$this->db->select('main.*, u.nom_prenoms as administrateur')->from($table.' main');
				$this->db->join('users u', 'u.user_id = main.admin_id');
	
			} else if($table == 'users'){
				$this->db->select('main.*, s.nom as structure')->from($table.' main');
				$this->db->join('structures s', 's.structure_id = main.structure_id');
	
			} else $this->db->select('*')->from($table);
	
			$col_name = $this->get_colum_name($table, $col_num);
			
			if($where) $this->db->where($where);
	
			if($table == 'users' && $text){  	
				$this->db->group_start();
				$this->db->like("user_id", $text); 
				$this->db->or_like("nom_prenoms", $text);  
				$this->db->or_like("email", $text);
				$this->db->or_like("main.statut", $text);
				$this->db->or_like("tel", $text);
				$this->db->or_like("main.date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
	
			if($table == 'groupes' && $text){	
				$this->db->group_start();
				$this->db->like("groupe_id", $text);
				$this->db->or_like("nom", $text);
				$this->db->or_like("date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
	
			if($table == 'type_depense' && $text){	
				$this->db->group_start();
				$this->db->like("type_depense_id", $text);
				$this->db->or_like("libelle", $text);
				$this->db->or_like("date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
	
			if($table == 'produits' && $text){	
				$this->db->group_start();
				$this->db->like("produit_id", $text);
				$this->db->or_like("libelle", $text);
				$this->db->or_like("date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
	
			if($table == 'structures' && $text){	
				$this->db->group_start();
				$this->db->like("main.structure_id", $text);
				$this->db->or_like("nom", $text);
				$this->db->or_like("u.nom_prenoms", $text);
				$this->db->or_like("main.date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
			
			$this->db->order_by($this->get_colum_name($table, $col_num), $col_dir);
	
			$this->db->limit($length, $start);
	
			return $this->db->get()->result();  

		}else return $this->db->query($this->dashboard_query($text, $length, $start))->result();
	}

	public function count_search_data($table, $text = NULL, $where = NULL){		
		
		if($table != 'dashboard'){
			if($table == 'structures'){
				$this->db->select('main.*, u.nom_prenoms as administrateur')->from($table.' main');
				$this->db->join('users u', 'u.user_id = main.admin_id');
	
			} else if($table == 'users'){
				$this->db->select('main.*, s.nom as structure')->from($table.' main');
				$this->db->join('structures s', 's.structure_id = main.structure_id');
	
			} else $this->db->select('*')->from($table);
			
			if($where) $this->db->where($where);
	
			if($table == 'users' && $text){  	
				$this->db->group_start();
				$this->db->like("user_id", $text); 
				$this->db->or_like("nom_prenoms", $text);  
				$this->db->or_like("email", $text);
				$this->db->or_like("main.statut", $text);
				$this->db->or_like("tel", $text);
				$this->db->or_like("main.date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
	
			if($table == 'groupes' && $text){	
				$this->db->group_start();
				$this->db->like("groupe_id", $text);
				$this->db->or_like("nom", $text);
				$this->db->or_like("date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
			
			if($table == 'type_depense' && $text){	
				$this->db->group_start();
				$this->db->like("type_depense_id", $text);
				$this->db->or_like("libelle", $text);
				$this->db->or_like("date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
	
			if($table == 'produits' && $text){	
				$this->db->group_start();
				$this->db->like("produit_id", $text);
				$this->db->or_like("libelle", $text);
				$this->db->or_like("date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
	
			if($table == 'structures' && $text){	
				$this->db->group_start();
				$this->db->like("main.structure_id", $text);
				$this->db->or_like("nom", $text);
				$this->db->or_like("u.nom_prenoms", $text);
				$this->db->or_like("main.date_enreg", $this->format_date($text));
				$this->db->group_end();
			}
	
			return $this->db->count_all_results(); 

		} else return $this->db->query($this->dashboard_query($text))->num_rows();
	}

	private function get_colum_name($table, $colums_num){

		$columns = [
				'users' => [
					'user_id',
					'nom_prenoms',
					'email',
					'structure',
					'tel',
					'main.statut',
					'main.date_enreg'
				],
				'groupes' => [
					'groupe_id',
					'nom',
					'date_enreg'
				],
				'type_depense' => [
					'type_depense_id',
					'libelle',
					'date_enreg'
				],
				'produits' => [
					'produit_id',
					'libelle',
					'date_enreg'
				],
				'structures' => [
					'main.structure_id',
					'nom',
					'u.nom_prenoms',
					'main.date_enreg'
				]
			];
			return (isset($columns[$table][$colums_num])) ? $columns[$table][$colums_num] : $columns[$table][0];
	}

	private function format_date($date){
		$parts = explode(' ', $date);
		if(count($parts) == 2){
			$a = explode('/', $parts[0]);
			return implode('-', array_reverse($a)).' '.$parts[1];
		}else if(count($parts) == 1){
			$a = explode('/', $date);
			return  implode('-', array_reverse($a));
		}
	}

	public function start_transaction(){
		$this->db->trans_start();
	}

	public function complete_transaction(){
		$this->db->trans_complete();
	}

	public function transaction_status(){
		return $this->db->trans_status();
	}

}
