
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends NS_Controller {

	public function __construct(){		
		parent::__construct();

        $this->data = array();

        $this->controller_name = "login";
        $this->title = "Login";

        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";
	}

	public function index(){
		$data["title"] = "Login";
		
		$this->template->loadView('public/login/index',$data,'public');
	}
	
}
