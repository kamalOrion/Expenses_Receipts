<?php
	$this->load->view('template/header');//inclusion entete de page
	$this->load->view('template/menu');//inclusion du menu et de la barre du haut
	$this->load->view($content);//inclusion dynamique corps de page
	$this->load->view('template/footer');//inclusion pied de page
?>
