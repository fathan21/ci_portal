<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends NS_Controller {

	public function __construct(){		
		parent::__construct();

        $this->data = array();


        $this->controller_name = "home";
        $this->title = "Home";

        $temp_data = $this->temporary_data;
        $this->data["msg"] = isset($temp_data['msg']) ? $temp_data['msg'] : "";
        $this->data["msg_status"] = isset($temp_data['msg_status']) ? $temp_data['msg_status'] : "";
	}

    public function counter_hist()
    {
        $data = array();

        $data['ip']= $_SERVER["REMOTE_ADDR"]; 
        $data["agent"] =$_SERVER["HTTP_USER_AGENT"];
        $data["datetime"] =date("Y/m/d") . ' ' . date('H:i:s');
        /*
            $this->uri->segment(4)
            http://example.com/index.php/news/local/metro/crime_is_up
            1. news
            2. local
            3. metro
            4. crime_is_up
            //catet pengujung

            dbtableinfo(id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id), ip_address VARCHAR(30), user_agent VARCHAR(50), datetime VARCHAR(25))
            page count
            $dbtablehits(page char(100),PRIMARY KEY(page),count int(15), date())

            -counter
            -meta
            -ssecurity
            -faceboo api
            -google
            -twitter
        */
        print_r($data);
    }

	public function index(){
		//$data["title"] = "Home";
        //$data["breadcrumb"] = array(array("title"=>$this->title,"link"=>"","active"=>"active"));

        //set paging
        $data["page"] = (isset($this->input_data['page'])&&$this->input_data['page']!="") ? $this->input_data['page'] : "1";
        $data["limit"] = 7;
        $data['base_url_pagination'] = current_url();

        $slide_db = $this->get_slide();
        $data["slide_db"] = $slide_db["news"];

        //$news = $this->news($data["page"],$data["limit"],$slide_db["id"]);
        $news = $this->news($data["page"],$data["limit"]);
        $data["news_db"] = $news["data"];
        $data["total"] = $news["total"];

        if($data["total"]>0){
            $data['pagination'] = generateBootstrapPagination($data['base_url_pagination'],$data["total"],$data["limit"]);
        }else{
            $data["pagination"] = "";
        }
        //set paging

		$this->template->loadView('public/home/index',$data,'public');
	}

	public function news($page=1,$limit=7,$not_id="")
	{
        $where_not_id = "";
        if($not_id !=""){
            $not_id = implode(",", $not_id);
            $where_not_id = " AND a.id NOT IN ($not_id) ";
        }

        $page--;
        $offset = $page * $limit;
        $offset = $offset;//+3; // 3 from slide

        $posts_model        = new master_model('posts');

     	$news_db = " SELECT a.title,c.publish_date, IF(d.image_small IS NULL,d.image_thumbnail,d.image_small ) as img,b.tags,a.id
     				 FROM posts a 
     				 JOIN posts_meta b ON a.id = b.posts_id 
     				 JOIN content c ON a.id = c.posts_id
     				 LEFT JOIN galery d ON d.id = c.galery_id
                     LEFT JOIN menu f ON a.menu_id = f.id
     				 WHERE 
     				 a.deleted_at IS NULL
                     AND f.is_single_page = 0
                     AND a.status='publish'
                     $where_not_id
     				 GROUP BY a.id
     				 ORDER BY c.publish_date DESC
                     LIMIT $offset,$limit
     				 ";
        $total = " SELECT a.title,c.publish_date, d.image_thumbnail as img,b.tags
                     FROM posts a 
                     JOIN posts_meta b ON a.id = b.posts_id 
                     JOIN content c ON a.id = c.posts_id
                     LEFT JOIN galery d ON d.id = c.galery_id
                     LEFT JOIN menu f ON a.menu_id = f.id
                     WHERE 
                     a.deleted_at IS NULL
                     AND f.is_single_page = 0
                     AND a.status='publish'
                     $where_not_id
                     GROUP BY a.id
                     ORDER BY c.publish_date DESC
                     ";
     	$news_db = $this->db->query($news_db)->result_array();
        $total = $this->db->query($total)->result_array();

     	$news = array();
     	foreach ($news_db as $key => $value) {
     		$array = $value;
     		$array["date"] = time_elapsed_string($value["publish_date"]);
     		$news[] = $array;
     	}   

        $result = array();
        $result["data"] = $news;
        $result["total"] = count($total);

     	return $result;
	}

    public function get_datas(){
        //set paging
        $data["page"] = (isset($this->input_data['page'])&&$this->input_data['page']!="") ? $this->input_data['page'] : "1";
        $data["limit"] = (isset($this->input_data['limit'])&&$this->input_data['limit']!="") ? $this->input_data['limit'] : "7";
        $news = $this->news($data["page"],$data["limit"]);
        //set paging
        echo json_encode($news);
    }

	public function get_slide()
	{
        $posts_model        = new master_model('posts');

        $headline = $this->get_headline();

        $where = "";
        if(count($headline) > 0){
            $headline = implode(",", $headline);
            $where = " AND a.id IN ($headline) GROUP BY a.id ORDER BY g.id ";
            $limit = '';

        }else{
            $where = ' 
                     GROUP BY a.id
                     ORDER BY c.publish_date DESC
             ';
            $limit = ' LIMIT 3 ';
        }

     	$news_db = " SELECT a.title,c.publish_date, d.image_thumbnail as img,b.tags,a.id
     				 FROM posts a 
     				 JOIN posts_meta b ON a.id = b.posts_id 
     				 JOIN content c ON a.id = c.posts_id
     				 LEFT JOIN galery d ON d.id = c.galery_id
                     LEFT JOIN menu f ON a.menu_id = f.id
                     LEFT JOIN headline g ON a.id = g.posts_id
     				 WHERE 
                     a.deleted_at IS NULL
                     AND f.is_single_page = 0
                     AND a.status='publish'
     				 $where
     				 $limit
     				 ";
     	$news = $this->db->query($news_db)->result_array(); 

        $id = array();
        foreach ($news as $key => $value) {
            $id[] = $value["id"]; 
        }

        $result["news"] = $news;
        $result["id"] = $id;
     	return $result;
	}


    public function get_headline($limit=5)
    {
        $headline_model        = new master_model('headline');

        $news_db = " SELECT a.*, b.title, c.full_name as update_by
                     FROM headline a 
                     LEFT JOIN posts b ON b.id = a.posts_id 
                     LEFT JOIN user c ON a.updated_by = c.id
                     LIMIT $limit
                     ";
        $news = $this->db->query($news_db)->result_array();

        $data = array();
        foreach ($news as $key => $value) {
            if($value["posts_id"] >0){
                $data[] = $value["posts_id"];
            }
        }

        return $data;
    }

	
}
