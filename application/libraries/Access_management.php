<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//template
class Access_management
{
  private $function_name = '';
  public function check_access($function_name,$rediret=0){
    $this->function_name = $function_name;
    $ci =& get_instance();  
    $user_group_model   = new master_model('user_group');
    $user_access_model   = new master_model('user_access');
    $access_item_model   = new master_model('t_access_item');
    $access_category_model   = new master_model('t_access_category');
    $access_item = $access_item_model->find($function_name,"route");
        
      if(isset($access_item['id'])){
        $user_data = $ci->session->userdata("user_data");
        $user_access = $user_access_model->find($user_data['user_group_id'],"user_group_id", " AND access_item_id =".$access_item['id']);
        
          if(!isset($user_access['id']) || $user_access['access_type'] == "none" ){
            //check route
              if($access_item["route"] !=""){
               header("location:".base_url("Welcome/error/301"));
              }else{
                return $user_access;
              }
          }
          else{
            return $user_access;
          }
      }else{
      }
  }
  public function menu(){
    $ci =& get_instance();
    $menu_model        = new master_model('menu');
    //$user_type = $ci->session->userdata('user_type');
    $sidemenu = "";
    $categories = $menu_model->all(" AND parent =0 AND is_admin=1 ");
    foreach ($categories as $category) {
      $sidemenu .='
                    <li>
                      <a href="'.base_url("nh_admin/menu/content/".$category["id"]).'">
                        <i class="'.$category["icon"].'"></i> <span>'.$category["name"].'</span>
                      </a>
                    </li>
      ';
    }
    return $sidemenu;
  }
  /*
  public function menu_public(){
    $ci =& get_instance();
    $menu_model        = new master_model('menu');
    //$user_type = $ci->session->userdata('user_type');
    $sidemenu = "";
    $categories = $menu_model->all(" AND parent =1 ");
    foreach ($categories as $category) {
      $sidemenu .='
               <li><a href="'.base_url('content/category/'.str_ireplace(" ","_",strtolower($category["name"]))).'" >'.$category["name"].'</a></li>
      ';
    }
    
    return $sidemenu;
  }
  */
  public function menu_public(){
    $ci =& get_instance();
    $menu_model        = new master_model('menu');
    $sidemenu = "";
    $categories = $menu_model->all(" AND parent =1 ");
    foreach ($categories as $category) {
      $sidemenu .='
               <li><a href="'.base_url(''.str_ireplace(" ","_",strtolower($category["name"]))).'" >'.$category["name"].'</a></li>
      ';
    }
    
    return $sidemenu;
  }
  public function sideMenuGenerate(){
    $ci =& get_instance();
    $category_model        = new master_model('t_access_category');
    $item_model        = new master_model('t_access_item');
    $user_access_model        = new master_model('user_access');
    $sidemenu = "";
    $user_data = $ci->session->userdata('user_data');
    $access_item =  " SELECT b.* FROM  
                      user_access a 
                      JOIN t_access_item b ON a.access_item_id = b.id
                      WHERE a.deleted_at IS NULL AND b.deleted_at IS NULL
                      AND a.user_group_id = ".$user_data["user_group_id"]." AND a.access_type != 'none' ";
    $access_item = $ci->db->query($access_item)->result_array();
    $access_item_id = array();
    $access_item_2 = array();
    foreach($access_item as $item){
      $access_item_id[] = $item['access_category_id'];
      $access_item_id_2[] = $item['id'];
    }
    if(count($access_item_id)>0){
      $access_item_id = array_unique($access_item_id);
      $access_item_id = implode(",", $access_item_id);
      $access_item_id_2 = implode(",", $access_item_id_2);
    }else{
      $access_item_id = 0;
    }
    $categories = $category_model->all(" AND id IN (".$access_item_id.") ORDER BY display_order ASC ");
    foreach ($categories as $category) {
      $item = $item_model->all(" AND id IN (".$access_item_id_2.") AND access_category_id = ".$category["id"]."  ORDER BY display_order ASC ");
      $route = $ci->uri->segment(1)."/".$ci->uri->segment(2);
      if(count($item) > 1 ){
          $active = '';
          $sidemenuSub  ='';
          foreach ($item as $key => $value) {
            $active_sub = '';
            if( trim($route) == trim($value['route']) ){
                $active_sub = 'active';
                $active = 'active';
            }
            $sidemenuSub .= '
              <li class="'.$active_sub.'"><a href="'.base_url($value["route"]).'"> <i class="fa fa-angle-right"></i>'.ucwords($value['code']).'</a></li>
            ';
          }
          $sidemenu .= '
                        <li class="'.$active.' treeview">
                          <a href="#">
                             <i class="'.$category["icon"].'"></i><span>'.ucwords($category["code"]).'</span> <i class="fa fa-angle-left pull-right"></i>
                          </a>
                          <ul class="treeview-menu">
              ';
          $sidemenu .=$sidemenuSub;
          $sidemenu .= '
                        </ul>
                      </li>
              ';
      }else{
          if(count($item) == 1 ){
              $active = '';
              if( trim($route) == trim($item[0]['route']) ){
                  $active = 'active';
              }
              $sidemenu .= '
                  <li class="'.$active.'">
                    <a href="'.base_url($item[0]["route"]).'">
                      <i class="'.$category['icon'].'"></i> <span>'.ucwords($item[0]['code']).'</span>
                    </a>
                  </li>';
          }
      }
    }
    return $sidemenu;
  }
    
}