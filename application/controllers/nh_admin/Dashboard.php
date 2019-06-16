<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends NS_Controller {

	public function __construct(){		
		parent::__construct();
        $this->is_login_admin();

		
	}

	public function index()
	{
		$data["title"] = "Dashboard";
		$data["logo"] = "Dashboard";
		$data["headline"] = $this->get_headline();
		$data["counter"] = $this->counter_count();
		$this->template->loadView('nh_admin/dashboard/index',$data,'admin');
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

     	return $news;
	}

	public function update_headline($headline_id,$posts_id)
	{
        $headline_model        = new master_model('headline');

        $update_data = array();
        $update_data["posts_id"] =$posts_id;
        $headline_model->update($headline_id,$update_data);
	}


	public function counter_count()
	{
		$q = "SELECT COUNT(*) as ctn FROM counter  ";
		$now =date('Y-m-d');
		$last = date("Y-m-d", strtotime("-1 day", time()));
		$m = (Int)date('m');
		$y=date('Y');
		$today = $q." WHERE  DATE(date_time) = '$now'  ";
		$yesterday = $q." WHERE  DATE(date_time) = '$last'";
		$month = $q." WHERE  MONTH(date_time) = $m ";
		$year = $q." WHERE YEAR(date_time) = $y ";
		$all = $q."  ";

		$today = $this->db->query($today)->row_array();
		$yesterday = $this->db->query($yesterday)->row_array();
		$month = $this->db->query($month)->row_array();
		$year = $this->db->query($year)->row_array();
		$all = $this->db->query($all)->row_array();

		$result["today"] = $today["ctn"];
		$result["yesterday"] = $yesterday["ctn"];
		$result["month"] = $month["ctn"];
		$result["year"] = $year["ctn"];
		$result["all"] = $all["ctn"];

		return $result;

	}
}
