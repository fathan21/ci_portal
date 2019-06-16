<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Galery extends NS_Controller {
    public function __construct(){
        parent::__construct();
        $this->is_login_admin();

        $this->galery_model        = new master_model('galery');

        $this->data = array();

        $this->controller_name = "nh_admin/galery";
        $this->title = "Photo";

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

            /*
            $file_name  = 'image_path';
            $new_name   = $crud_data['name']."_".time();
            $new_path   = 'public/galery/';
            $old_file_path = "";

            $image      = upload_handler($file_name,$new_name,$new_path, $required = true,$old_file_path);

            $crud_data['image_path'] = $image['file_path'];
            $crud_data["image_thumbnail"] = $image["thumbnail_path"];
            */

            $new_path = 'public/galery/';
            $image_thumbnail = explode("/", $crud_data['image_thumbnail']);
            $image_thumbnail = $new_path.end($image_thumbnail);
            $image_path = explode("/", $crud_data['image_path']);
            $image_path = $new_path.end($image_path);

            rename($crud_data['image_thumbnail'], $image_thumbnail);
            rename($crud_data['image_path'], $image_path);
            $crud_data['image_small'] = resize_image($image_thumbnail, 119,59,$new_path);
            $crud_data['image_path'] = $image_path;
            $crud_data['image_thumbnail'] = $image_thumbnail;

            $this->galery_model->add($crud_data);

            array_map('unlink', glob("public/galery/temp_/*"));
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
        $data["db_data"] = $this->galery_model->find($id);
        $this->template->loadView($this->controller_name.'/form',$data,'admin');
    }

    /**
     * update data in db with id
     * @param int $id data id
     */
    public function update($id){
        if($this->updateValidation()){
            $db_data = $this->galery_model->find($id);
            $crud_data = array();
            $crud_data = $this->input_data;
            /*
            if($_FILES['image_path']['name'] != ''){

                $file_name  = 'image_path';
                $new_name   = $crud_data['name']."_".time();
                $new_path   = 'public/galery/';
                
                if($db_data["image_path"] == ""   ){
                    $old_file_path = "";
                }else{
                    $old_file_path = $db_data["image_path"];
                }


                $image      = upload_handler($file_name,$new_name,$new_path, $required = true,$old_file_path);
        
                $crud_data['image_path'] = $image['file_path'];
                $crud_data["image_thumbnail"] = $image["thumbnail_path"];

            }
            */
            if($crud_data["image_path"] !=""){

                
                $new_path = 'public/galery/';
                $image_thumbnail = explode("/", $crud_data['image_thumbnail']);
                $image_thumbnail = $new_path.end($image_thumbnail);
                $image_path = explode("/", $crud_data['image_path']);
                $image_path = $new_path.end($image_path);

                rename($crud_data['image_thumbnail'], $image_thumbnail);
                rename($crud_data['image_path'], $image_path);

                $crud_data['image_small'] = resize_image($image_thumbnail, 119,59,$new_path);
                $crud_data['image_path'] = $image_path;
                $crud_data['image_thumbnail'] = $image_thumbnail;

                if(file_exists($db_data['image_path'])){
                    unlink($db_data['image_path']);
                }
                if(file_exists($db_data['image_thumbnail'])){
                    unlink($db_data['image_thumbnail']);
                }
                if(file_exists($db_data['image_small'])){
                    unlink($db_data['image_small']);
                }
                
            }else{
                unset($crud_data['image_path']);
                unset($crud_data['image_thumbnail']);
            }

            $this->galery_model->update($id,$crud_data);
            
            array_map('unlink', glob("public/galery/temp_/*"));
            
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
            $this->galery_model->delete($id);
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
            ->select("a.id, a.name, a.image_path ,a.image_thumbnail ,a.created_at, b.username as upload_by ")
            ->from('galery a')
            ->join('user b', 'b.id = a.created_by',"left")
            ->where('a.deleted_at',NULL)
            ->edit_column("id", "$1", "select_helper(id)")
            ->add_column("action", "$1", "action_helper('nh_admin/galery',id)")
            ->generate();
        echo $data;
    }


    public function popup($slide='',$num=0){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = $this->title; //title to show up in last part of breadcrumb and title of a page
        $data['listener'] = base_url($this->controller_name).'/listener_popup?slide='.$slide."&num=".$num;
        $data["breadcrumb"] = array(array("title"=>$this->title,"link"=>"","active"=>"active"));

        $data["foot"]=$this->load->view("template/includes/admin-foot", "", TRUE);
        $data["head"] = $this->load->view("template/includes/admin-head","", TRUE);
        $this->template->loadView($this->controller_name.'/popup',$data,'');
    }

    /**
     * datatable listener
     */
    public function listener_popup(){

        $slide = isset($_GET['slide']) && $_GET['slide']!="" ?$_GET['slide']:'galery';
        $num = isset($_GET['num']) && $_GET['num']!="" ?'slide_'.$_GET['num']:0;

        $datatables = $this->datatables;

        $data = $datatables
            ->select("id, name,  image_path,image_thumbnail,created_at")
            ->from('galery')
            ->where('deleted_at',NULL)
            ->edit_column("id", "$1", "select_helper(id)")
            ->add_column("action", "$1", "action_helper('nh_admin/galery',id,'$num','$slide')")
            ->generate();
        echo $data;
    }

    public function popup_multi(){
        $data = $this->data; //take any data possibly set in construct function
        $data['title'] = $this->title; //title to show up in last part of breadcrumb and title of a page
        $data['listener'] = base_url($this->controller_name).'/listener_popup_multi/';
        $data["breadcrumb"] = array(array("title"=>$this->title,"link"=>"","active"=>"active"));

        $data["foot"]=$this->load->view("template/includes/admin-foot", "", TRUE);
        $data["head"] = $this->load->view("template/includes/admin-head","", TRUE);
        $this->template->loadView($this->controller_name.'/popup_multi',$data,'');
    }

    /**
     * datatable listener
     */
    public function listener_popup_multi(){
        $datatables = $this->datatables;

        $data = $datatables
            ->select("id, name,  image_path,image_thumbnail,created_at")
            ->from('galery')
            ->where('deleted_at',NULL)
            ->edit_column("id", "$1", "select_content_galery(id)")
            ->add_column("action", "$1", "action_helper('nh_admin/galery',id,0,0)")
            ->generate();
        echo $data;
    }
    public function save_img(){
        $imagePath = "public/galery/temp_/";

        $allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
        $temp = explode(".", $_FILES["img"]["name"]);
        $extension = end($temp);
        
        //Check write Access to Directory

        if(!is_writable($imagePath)){
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t upload File; no write Access'
            );
            print json_encode($response);
            return;
        }
        
        if ( in_array($extension, $allowedExts))
          {
          if ($_FILES["img"]["error"] > 0)
            {
                 $response = array(
                    "status" => 'error',
                    "message" => 'ERROR Return Code: '. $_FILES["img"]["error"],
                );          
            }
          else
            {
                
              $filename = $_FILES["img"]["tmp_name"];
              list($width, $height) = getimagesize( $filename );
              $new_file_name = date('YmdHis')."_".rand().'.'.$extension;
              move_uploaded_file($filename,  $imagePath . $new_file_name);

              $response = array(
                "status" => 'success',
                //"url" => base_url($imagePath.$_FILES["img"]["name"]),
                "url" => base_url($imagePath.$new_file_name),
                "image_path" => $imagePath.$new_file_name,
                "image_thumbnail" => '',
                "width" => $width,
                "height" => $height
              );
              
            }
          }
        else
          {
           $response = array(
                "status" => 'error',
                "message" => 'something went wrong, most likely file is to large for upload. check upload_max_filesize, post_max_size and memory_limit in you php.ini',
            );
          }
          
          print json_encode($response);
    }
    public function crop_img()
    {

        $imgUrl = $_POST['imgUrl'];
   
        $temp_1 = explode(".", $_POST["imgUrl"]);
        $extension_1 = end($temp_1);
        $name_1 = explode("/", $_POST['imgUrl']);
        $name_1_c = count($name_1);
        $name_1 = $name_1[$name_1_c-1];
        $name_image = $name_1;
        $name_1 = explode(".",$name_1);
        $name_1 = $name_1[0]."_thumb";

        // original sizes
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];
        // resized sizes
        $imgW = $_POST['imgW'];
        $imgH = $_POST['imgH'];
        // offsets
        $imgY1 = $_POST['imgY1']+5;
        $imgX1 = $_POST['imgX1']+5;
        // crop box
        $cropW = $_POST['cropW']-10;
        $cropH = $_POST['cropH']-10;
        // rotation angle
        $angle = $_POST['rotation'];

        $jpeg_quality = 70;

        $output_filename = "public/galery/temp_/".$name_1;
        $input_filename = 'public/galery/temp_/'.$name_image;

        // uncomment line below to save the cropped image in the same location as the original image.
        //$output_filename = dirname($imgUrl). "/croppedImg_".rand();

        $what = getimagesize($imgUrl);

        switch(strtolower($what['mime']))
        {
            case 'image/png':
                $img_r = imagecreatefrompng($imgUrl);
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgUrl);
                $source_image = imagecreatefromjpeg($imgUrl);
                error_log("jpg");
                $type = '.jpeg';
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($imgUrl);
                $source_image = imagecreatefromgif($imgUrl);
                $type = '.gif';
                break;
            default: die('image type not supported');
        }


        //Check write Access to Directory

        if(!is_writable(dirname($output_filename))){
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t write cropped File'
            );  
        }else{

            // resize the original image to size of editor
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            // rotate the rezized image
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            // find new width & height of rotated image
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            // diff between rotated & original sizes
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            // crop rotated image to fit into original rezized rectangle
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            // crop image into selected area
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            // finally output png image
            //imagepng($final_image, $output_filename.$type, $png_quality);
            imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
            $response = Array(
                "status" => 'success',
                "image_path" => $input_filename,
                "image_thumbnail" => $output_filename.$type,
                "url" => base_url($output_filename.$type)
            );
        }
        print json_encode($response);
    }
    
    public function getEmbed($id){
        $data["db_data"] = $this->galery_model->find($id);

        echo json_encode(array("embed"=>'<img src="'.base_url($data["db_data"]['image_thumbnail']).'" />',"url"=>base_url($data["db_data"]['image_thumbnail'])));
    }




}