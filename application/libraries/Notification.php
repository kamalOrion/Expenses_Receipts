<?php

defined('BASEPATH') OR exit('No direct script access allowed');
 
class Notification
{

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->model('ivtmodel');
        $this->ivtmodel = $this->ci->ivtmodel; 
    }

    //Fonctions de purge

    //Vérifier si le mois est passer
    public function send_email($email, $subject, $message){
        $email_params = $this->ivtmodel->getItem('params_plateforme', 'id', 1)[0];
        $config = array(
            'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
            'smtp_host' => $email_params->smtp_host, //'inovact.com', 
            'smtp_port' => $email_params->smtp_port, //465,
            'smtp_user' => $email_params->smtp_user,//'business@inovact.com',
            'smtp_pass' => $email_params->smtp_pass, //'647Ubw?n',
            'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
            'mailtype' => 'html', //plaintext 'text' mails or 'html'
            'smtp_timeout' => '4', //in seconds
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        
        $this->ci->load->library('email');
        $from = $config['smtp_user'];
        $this->ci->email->initialize($config);

        $this->ci->email->set_newline("\r\n");
        $this->ci->email->from($from);
        $this->ci->email->to($email);
        $this->ci->email->subject($subject);
        $this->ci->email->message($message);

        

        return ($this->ci->email->send()) ? true : false; 
    }

    
    //Fin fonctions de purge

}

/* end of file */
