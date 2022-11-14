<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('allowed')){
	function allowed($privilege){
		$ci = &get_instance();
		return $ci->session->userdata['user_id'] == 1 || in_array($privilege, $ci->session->userdata['privileges']);
	}
}