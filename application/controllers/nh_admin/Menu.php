<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends NS_Controller {
    public function __construct(){
        parent::__construct();
        $this->is_login_admin();

        $this->menu_model        = new master_model('menu');
        $this->posts_model        = new master_model('posts');
        $this->posts_meta_model        = new master_model('posts_meta');

        $this->data = array();

        $this->controller_name = "nh_admin/menu";
        $this->title = "Menu";

        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";
        $this->data["menu_selector"] = $this->menu_model->all();
        $this->data["boolean_selector"] = array("NO","YES");
        
    }

    /**
     * index page, for showing list of data
     */
    public function index(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = $this->title; //title to show up in last part of breadcrumb and title of a page
        $data['listener'] = base_url($this->controller_name).'/listener/';
        $data['delete_route'] = base_url($this->controller_name).'/destroy/';
        $data['add_new_link'] = $this->controller_name."/create"; // anchor link for add new data for this module
        $data["breadcrumb"] = array(array("title"=>$this->title,"link"=>"","active"=>"active"));

        $this->template->loadView($this->controller_name.'/index',$data,'admin');
    }

    /**
     * rendering create page
     */
    public function create(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = $this->title." Create"; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'create';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>$this->title,"link"=>base_url($this->controller_name),"active"=>""),
                                        array("title"=>$this->title." Create","link"=>'#',"active"=>"active")
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

            $this->menu_model->add($crud_data);
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
        $data['title'] = $this->title." Edit"; //title to show up in last part of breadcrumb and title of a page
        $data['type'] = 'Edit';
        $data['back_link'] = $this->controller_name; // anchor link for add new data for this module
        $data["breadcrumb"] = array(
                                        array("title"=>$this->title,"link"=>base_url($this->controller_name),"active"=>""),
                                        array("title"=>$this->title." Edit","link"=>'#',"active"=>"active")
                                    );
        $data['action']= base_url($this->controller_name).'/update/'.$id;
        $data["db_data"] = $this->menu_model->find($id);
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
            $this->menu_model->update($id,$crud_data);
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
            $this->menu_model->delete($id);
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
            ->select("a.id, a.name,  b.name as parent,a.is_single_page")
            ->from('menu a')
            ->join('menu b', 'b.id = a.parent',"left")
            ->where('a.deleted_at',NULL)
            ->edit_column("id", "$1", "select_helper(id)")
            ->add_column("action", "$1", "action_helper('nh_admin/menu',id)")
            ->generate();
        echo $data;
    }
    




}