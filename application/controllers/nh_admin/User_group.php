<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_group extends NS_Controller {
    public function __construct(){
        parent::__construct();
        $this->is_login_admin();

        $this->user_group_model        = new master_model('user_group');
        $this->category_model        = new master_model('t_access_category');
        $this->item_model        = new master_model('t_access_item');
        $this->user_access_model        = new master_model('user_access');

        $this->data = array();

        $this->controller_name = "nh_admin/user_group";


        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";

        //crypt()sha1(str) 
    }

    /**
     * index page, for showing list of data
     */
    public function index(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = "User Group"; //title to show up in last part of breadcrumb and title of a page
        $data['listener'] = base_url($this->controller_name).'/listener/';
        $data['delete_route'] = base_url($this->controller_name).'/destroy/';
        $data['add_new_link'] = $this->controller_name."/create"; // anchor link for add new data for this module
        $data["breadcrumb"] = array(array("title"=>"User Group","link"=>"","active"=>"active"));

        $this->template->loadView($this->controller_name.'/index',$data,'admin');
    }

    /**
     * rendering create page
     */
    public function create(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = "User Group Create"; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'create';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>"User Group","link"=>base_url($this->controller_name),"active"=>""),
                                        array("title"=>"User Group Create","link"=>'#',"active"=>"active")
                                    );
        $data['action']= base_url($this->controller_name).'/store';
        $this->template->loadView($this->controller_name.'/form',$data,'admin');
    }

    /**
     * store input data to db
     */
    public function store(){
        if($this->storeValidation()) {
            $crud_data = array();
            $crud_data = $this->input_data;

            $this->user_group_model->add($crud_data);
            redirect($this->controller_name);
        }else{
            $this->create();
        }
    }

    /**
     * rendering read page
     * @param int $id data id
     */
   

    /**
     * rendering update page
     * @param int $id data id
     */
    public function edit($id){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = "User Group Edit"; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'Edit';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>"User Group","link"=>base_url($this->controller_name),"active"=>""),
                                        array("title"=>"User Group Edit","link"=>'#',"active"=>"active")
                                    );
        $data['action']= base_url($this->controller_name).'/update/'.$id;
        $data["db_data"] = $this->user_group_model->find($id);
        $this->template->loadView($this->controller_name.'/form',$data,'admin');
    }

    /**
     * update data in db with id
     * @param int $id data id
     */
    public function update($id){
        if($this->updateValidation()){
            $crud_data = array();
            $crud_data = $this->input_data;

            $this->user_group_model->update($id,$crud_data);
            redirect($this->controller_name);
        }else{
            $this->edit($id);
        }
    }

    /**
     * delete data in db with id
     * @param $id
     */
    public function destroy($id){
        try {
            $this->user_group_model->delete($id);
            return 0;
        }catch (Exception $e){
            return 1;
        }
    }

    /**
     * create form validation
     */
    public function storeValidation(){
        return true;
    }

    /**
     * update form validation
     */
    public function updateValidation(){
        return true;
    }

    /**
     * datatable listener
     */
    public function listener(){
        $datatables = $this->datatables;

        $data = $datatables
            ->select("id, name")
            ->from('user_group')
            ->where('deleted_at',NULL)
            ->edit_column("id", "$1", "select_helper(id)")
            ->add_column("action", "$1", "action_helper('nh_admin/user_group',id)")
            ->generate();
        echo $data;
    }


    public function access($id){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = "User Access "; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'Edit';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>"User Group","link"=>base_url($this->controller_name),"active"=>""),
                                        array("title"=>"User Access","link"=>'#',"active"=>"active")
                                    );
        $data['action']= base_url($this->controller_name).'/access_update/'.$id;
        $data["db_data"] = $this->user_group_model->find($id);
        $data['categories'] = $this->category_model->all(" ORDER BY display_order ASC ");

        $this->template->loadView($this->controller_name.'/access_form',$data,'admin');
    }


    public function access_update($id){
            $crud_data = array();
            $crud_data = $this->input_data;
            if(!isset($crud_data["item"])){
                echo "not found";
                die();
            }

            foreach ($crud_data["item"] as $key => $value) {
                $input_data = array();
                $input_data["user_group_id"] = $id;
                $input_data["access_item_id"] = $key;
                $input_data["access_type"] = $value;

                $chk = $this->user_access_model->find($id,"user_group_id"," AND access_item_id = $key ");
                if(isset($chk["id"])){
                    $this->user_access_model->update($chk["id"],$input_data);
                }else{
                    $this->user_access_model->add($input_data);
                }
            }
            
            //$this->user_group_model->update($id,$crud_data);
            redirect($this->controller_name);
        
    }



}