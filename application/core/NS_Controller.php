<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NS_Controller extends CI_Controller {
	protected $input_data;
	protected $temporary_data;
	protected $data;
	protected $controller_name;
	protected $module_name;
	protected $function_name;

	public function __construct(){
		
		parent::__construct();

		//message session
		$this->temporary_data = $this->session->userdata("temporary_data");
		$this->session->unset_userdata("temporary_data");
		$now = date('Y-m-d H:i:s');
		$this->db->query("UPDATE posts 
						LEFT JOIN content_galery ON posts.id = content_galery.posts_id
						set posts.`status` = 'publish' 
						where content_galery.publish_date <= '$now'
						  and posts.`status` ='later' ");
		$this->db->query("UPDATE posts 
						LEFT JOIN content ON posts.id = content.posts_id
						set posts.`status` = 'publish' 
						where content.publish_date <= '$now' 
						  and posts.`status` ='later' ");
		if($_POST){
			$this->input_data = $this->input->post();

		}	
		else if($_GET){
			$this->input_data = $this->input->get();
		}
		
	}
	public function is_login_admin(){

		$data = $this->session->userdata('user_data');
		
		if(isset($data['id'])){
			$user_data = $this->session->userData("user_data");
			//$this->access_management->have_access($adminData["user_group_id"]);
			return true;
		}
		else{
			redirect('nh_admin/login');
		}
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
