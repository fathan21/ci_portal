
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends NS_Controller {

	public function __construct(){		
		parent::__construct();

        $this->data = array();

        $this->controller_name = "page";
        $this->title = "Page";

        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";
	}


	public function s($type="about"){

        $posts_model        = new master_model('posts');
		$data["title"] = $type;
		
		$posts_db = array();

		$posts_db = $posts_model->find(8,"menu_id");
		if($type=="contact"){
			$posts_db = $posts_model->find(9,"menu_id");
		}
		if($type=="privacy_policy"){
			$posts_db = $posts_model->find(10,"menu_id");
		}
		if($type=="terms_of_use"){
			$posts_db = $posts_model->find(11,"menu_id");
		}


        $data["title"] = $posts_db["title"];
        $data["data"] = $posts_db;

		$this->template->loadView('public/page/single',$data,'public');
	}
	
}
