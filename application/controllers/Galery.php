
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galery extends NS_Controller {

	public function __construct(){		
		parent::__construct();

        $this->data = array();

        $this->controller_name = "galery";
        $this->title = "Page";

        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";
	}

	public function index(){
		$data["title"] = "Galeri";
		
		$this->template->loadView('public/galery/index',$data,'public');
	}


	public function get_datas(){

        //set paging
        $data["page"] = (isset($this->input_data['page'])&&$this->input_data['page']!="") ? $this->input_data['page'] : "1";
        $data["limit"] = 12;
        $data['base_url_pagination'] = current_url();
        $news = $this->news($data["page"],$data["limit"],5);
        //set paging

        echo json_encode($news);
	}

	public function news($page=1,$limit=7,$menu_id="5")
	{

        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');
        $page--;
        $offset = $page * $limit;

        $where = " AND a.menu_id= $menu_id ";

     	$news_db = " SELECT a.title,c.publish_date, d.image_thumbnail as img, e.link as video,
     				b.tags,a.id,c.type
     				 FROM posts a 
     				 JOIN posts_meta b ON a.id = b.posts_id 
     				 LEFT JOIN content_galery c ON a.id = c.posts_id
     				 LEFT JOIN galery d ON d.id = c.galery_id
     				 LEFT JOIN video e ON e.id = c.video_id
     				 WHERE 
     				 a.deleted_at IS NULL
                     AND a.status='publish'
     				 $where
                     GROUP BY a.id
     				 ORDER BY c.publish_date DESC
                     LIMIT $offset,$limit
     				 ";
     	$news_db = $this->db->query($news_db)->result_array();
		
		$news = array();
     	foreach ($news_db as $key => $value) {
     		$array = $value;
     		$array["date"] = time_elapsed_string($value["publish_date"]);
     		$array["title"] = strtoupper($value["title"]);
     		$array["href"] = $value["id"]."-".str_ireplace(" ",".",strtolower(trim($value["title"])));
     		
            if($value["video"]!=""){
                $video = explode("/", $value["video"]);
                if(strpos($value["video"], "watch?v=") != false){
                    $video = str_ireplace("watch?v=", "", $video[3]);
                    $array["img"] = "http://img.youtube.com/vi/".$video."/2.jpg";
                }else{
                    $video = $video[4];
                    $array["img"] = "http://img.youtube.com/vi/".$video."/2.jpg";
                }
            
            }else{
                $array["img"]=base_url().$array["img"];
            }
     		$news[] = $array;
     	} 
        /* get count */
        $count = $posts_model->all(" AND menu_id = $menu_id AND deleted_at IS NULL ");
        $count=count($count);
        $count_of = ($page+1) *$limit;

        if($count > $count_of ){
            $load_more = 1;
        }else{
            $load_more = 0;
        }


        $result = array();
        $result["data"] = array('data'=>$news,'load_more'=>$load_more);
     	return $result;
	}



    public function read($title){
        $posts_model        = new master_model('posts');
        $galery_model        = new master_model('galery');
        $video_model        = new master_model('video');
        //get menu data
        
        $title = str_ireplace("'","",$title);
        $title = explode("-",$title);
        $posts_db = $this->get_read($title[0]);

        $posts_db = $posts_db["data"];
        if(!isset($posts_db["id"])){
            redirect('test');
            die();
        }

        $data["title"] = $posts_db["title"];
        $data["data"] = $posts_db;
        $data["data"]["view"] = $this->get_counter_post($title[0]);


        if($data["data"]["type"]=="photo"){
            $photo = explode(",", $data["data"]["galery_id"]);
            $photo_array = array();
            foreach ($photo as $key => $value) {
                $p = $galery_model->find($value);
                $photo_array[] = $p;
            }
            $data["img"] = $photo_array;
            $data["data"]["img"] = $data["img"][0]["image_thumbnail"];
        }else{
            $p = $video_model->find($data["data"]["video_id"]);
            $data["video"] = $p;
            if(strpos($data["video"]['link'], "watch?v=") != false){
                $video = explode("watch?v=", $data["video"]["link"]);
                $data["video"]["src"] = $video[0]."embed/".$video[1]."?&rel=0&controls=0&loop=0";
            }else{
                $data['video']["src"] = $data["video"]["link"];
            }
            
        }
        //print_r($data);die();
        //$menu = str_ireplace("_"," ",strtolower($menu));
        //$menu_db = $menu_model->find($menu,"LOWER(name)");

        $data["breadcrumb"] = array(
                                    array("title"=>"<a href='".base_url()."'>Beranda</a>","active"=>""),
                                    array("title"=>"<a href='".base_url()."/".str_ireplace(" ", "_", strtolower($posts_db['category']))."' class='active'>".$posts_db['category']."</a>","link"=>"#","active"=>"active")
                                );

        $data["load_more"] = base_url()."/".str_ireplace(" ", "_", strtolower($posts_db['category']));
        $data["terbaru"] = $this->get_terbaru(5);
        

        $this->template->loadView('public/page/galery',$data,'public');
    }


    public function get_read($id)
    {
        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');
        $galery_model        = new master_model('galery');
        $video_model        = new master_model('video');

        $news_db = " SELECT a.title,c.publish_date,  b.tags,a.id,a.content,c.type, g.name as category,
                     e.full_name as writer_user, 
                     b.*,c.*
                     FROM posts a 
                     JOIN posts_meta b ON a.id = b.posts_id 
                     LEFT JOIN content_galery c ON a.id = c.posts_id
                     LEFT JOIN user e ON c.writer = e.id
                     LEFT JOIN menu g ON g.id = a.menu_id
                     LEFT JOIN menu h ON h.id = g.parent
                     WHERE 
                     a.deleted_at IS NULL
                     AND a.id = '$id'
                     GROUP BY a.id
                     LIMIT 1
                     ";
        $news = $this->db->query($news_db)->row_array();

        $result = array();
        $result["data"] = $news;
        return $result;
    }

    public function get_terbaru($menu_id="")
    {
        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');

        $where = " AND a.menu_id = $menu_id ";

        $news_db = " SELECT a.title,c.publish_date, d.image_thumbnail as img, e.link as video,
                    b.tags,a.id,c.type
                     FROM posts a 
                     JOIN posts_meta b ON a.id = b.posts_id 
                     LEFT JOIN content_galery c ON a.id = c.posts_id
                     LEFT JOIN galery d ON d.id = c.galery_id
                     LEFT JOIN video e ON e.id = c.video_id
                     WHERE 
                     a.deleted_at IS NULL
                     AND a.status='publish'
                     $where
                     GROUP BY a.id
                     ORDER BY c.publish_date DESC
                     LIMIT 4
                     ";
        $news_db = $this->db->query($news_db)->result_array();
        $news = array();
        foreach ($news_db as $key => $value) {
            $array = $value;
            $array["date"] = time_elapsed_string($value["publish_date"]);
            $array["title"] = strtoupper($value["title"]);
            $array["href"] = $value["id"]."-".str_ireplace(" ",".",strtolower(trim($value["title"])));

            
            if($value["video"]!=""){
                $video = explode("/", $value["video"]);
                if(strpos($value["video"], "watch?v=") != false){
                    $video = str_ireplace("watch?v=", "", $video[3]);
                    $array["img"] = "http://img.youtube.com/vi/".$video."/2.jpg";
                }else{
                    $video = $video[4];
                    $array["img"] = "http://img.youtube.com/vi/".$video."/2.jpg";
                }
            
            }else{
                $array["img"]=base_url().$array["img"];
            }
            //die();
            $news[] = $array;
        } 

        return $news;
    }
	
    public function get_counter_post($id)
    {
        $posts_model        = new master_model('posts');
        $menu_model        = new master_model('menu');


        $counter_db = " SELECT SUM(count) as ctn 
                     FROM counter_hits
                     WHERE posts_id = $id
                     LIMIT 1
                     ";
        $counter = $this->db->query($counter_db)->row_array();

        $result = 4;
        if(isset($counter["ctn"]) && $counter["ctn"] >0 ){
            $result = $counter["ctn"]*4;
        }

        return $result;
    }
}
