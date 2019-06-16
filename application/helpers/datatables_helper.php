<?php



function action_helper($routename, $id, $allow_edit = 1, $allow_delete = 1)
{
    $button_name='Delete';
    $disabled='';
    $ci =& get_instance();
    $data = '<span class="tooltip-area">';
    switch ($routename) {
        case 'nh_admin/user_group':
            $data .= '<a href="' . base_url() . $routename . '/access/' . $id . '" class="btn btn-info btn-inverse btn-xs" data-tooltip="tooltip" title="Access"><i class="fa fa-list"></i></a>';
            break;
        case 'nh_admin/galery':

            $galery_modal        = new master_model('galery');
            $galery_db = $galery_modal->find($id);
            $data .= '<a href="javascript:;" class="btn btn-info btn-inverse btn-xs btn-embed" data="'.$id.'" data-tooltip="tooltip" title="Embed">Embed</a>';
            break;
        case 'nh_admin/liga':
            
            $data .= '<a href="'.base_url().'nh_admin/liga/jadwal/'.$id.'" class="btn btn-success btn-inverse btn-xs btn-embed" data="'.$id.'" data-tooltip="tooltip" title="Jadwal">Jadwal</a>';
            //$data .= '<a href="" class="btn btn-info btn-inverse btn-xs btn-embed" data="'.$id.'" data-tooltip="tooltip" title="Klesemen">Klesemen</a>';
            break;
        case 'nh_admin/content':

            $content_model        = new master_model('content');
            $posts_model        = new master_model('posts');
            $content_db = $content_model->find($id,"posts_id");
            $posts_db = $posts_model->find($id);
            $title = "-".str_ireplace(" ", ".", $posts_db["title"]);
            $data .= '<a target="_blank" href="' . base_url()  .'read/' . $id.$title . '"  class="btn btn-default btn-inverse btn-xs" data-tooltip="tooltip" title="view"><i class="fa fa-desktop"></i></a>';
            $data .= '<a href="' . base_url()  .'nh_admin/content_slide/' . $id . '"  class="btn btn-success btn-inverse btn-xs" data-tooltip="tooltip" title="content Slide"><i class="fa fa-list"></i></a>';
            if($content_db["publish_date"] ==""){
                $data .= '<a  href="' . base_url() . $routename . '/publish/' . $id . '"  class="btn btn-info btn-inverse btn-xs" data-tooltip="tooltip" title="publish" ><i class="fa fa-flag"></i></a>';
            }    

            
            break;
        case 'nh_admin/content_galery':

            $content_model        = new master_model('content_galery');
            $content_db = $content_model->find($id,"posts_id");
            $data .= '<a target="_blank" href="' . base_url()  .'galery/read/' . $id . '"  class="btn btn-default btn-inverse btn-xs" data-tooltip="tooltip" title="view"><i class="fa fa-desktop"></i></a>';

            if($content_db["publish_date"] ==""){
                $data .= '<a href="' . base_url() . $routename . '/publish/' . $id . '" class="btn btn-info btn-inverse btn-xs" data-tooltip="tooltip" title="publish"><i class="fa fa-flag"></i></a>';
            }
            break;
        default:
            break;
    }

    if ($allow_edit == 1){
        $data .= '<a href="' . base_url() . $routename . '/edit/' . $id . '" class="btn btn-primary btn-inverse btn-xs" data-tooltip="tooltip" title="Edit"><i class="fa fa-pencil"></i></a>';
    }
    if ($allow_delete == 1) {
        $data .= '<a href="javascript:;" id="deleteBtn" data="' . $id . '" class="btn btn-warning btn-inverse btn-xs" data-tooltip="tooltip" title="Delete" '.$disabled.'><i class="fa fa-trash-o"></i> </a>';
    }
    if ($allow_delete == 'galery') {
        $galery_modal        = new master_model('galery');

        $field = $galery_modal->find($id);
        $data .= '<a href="javascript:;" onclick="parent.get_galery(' . $field["id"] . ',\''.$field["image_path"].'\',\''.$field["image_thumbnail"].'\')" id="select_btn" data="' . $field["id"] . '" image_path="'.$field["image_path"].'" class="btn btn-warning btn-inverse select_btn btn-xs" data-tooltip="tooltip" title="Select" >Select </a>';
    }
    if ($allow_delete == 'slide') {
        $galery_modal        = new master_model('galery');
        $slide_num = explode("_",$allow_edit);
        $slide_num=$slide_num[1];
        $field = $galery_modal->find($id);
        $data .= '<a href="javascript:;" onclick="parent.get_galery_slide(' . $field["id"] . ',\''.$field["image_path"].'\',\''.$field["image_thumbnail"].'\',\''.$slide_num.'\')" id="select_btn" data="' . $field["id"] . '" image_path="'.$field["image_path"].'" class="btn btn-success btn-inverse select_btn btn-xs" data-tooltip="tooltip" title="Select" >Select </a>';
    }
    if ($allow_delete == 'headline') {
        $data = '<a href="javascript:;" class="btn btn-warning btn-inverse" onclick="parent.save_headline('.$allow_edit.',' . $id . ')" id="select_btn" data="' . $id . '"  data-tooltip="tooltip" title="Select" >Select </a>';
    }
    if ($allow_delete == 'video') {
        $video_model        = new master_model('video');

        $field = $video_model->find($id);
        $data .= '<a href="javascript:;" onclick="parent.get_video(' . $field["id"] . ',\''.$field["link"].'\',\''.$field["name"].'\',\''.$field["created_at"].'\')" id="select_btn" data="' . $field["id"] . '"  class="btn btn-warning btn-inverse select_btn btn-xs" data-tooltip="tooltip" title="Select" >Select </a>';
    }
    $data .= '</span>';



    return $data;
}

function select_helper($id, $row_num = "")
{
    if ($row_num != "") {
        return "<input type=checkbox id='lab-$id' value=" . $id . " class=_check style=opacity: 0;> <span class='label label-default' for='lab-$id'>$row_num</span>";
    } else {
        return "<input type=checkbox id='lab-$id' value=" . $id . " class=_check style=opacity: 0;> <span class='label label-default' for='lab-$id'></span>";
    }
}

function select_content($id, $row_num = "")
{
    $ci =& get_instance();
    $posts_model        = new master_model('posts');

    $field = $posts_model->find($id);
    return "<input type=checkbox id='lab-$id' data='".$field["title"]."' value=" . $id . " class=_check style=opacity: 0;> <span class='label label-default' for='lab-$id'></span>";
}
function select_content_galery($id, $row_num = "")
{
    $ci =& get_instance();
    $galery_modal        = new master_model('galery');

    $field = $galery_modal->find($id);
    return "<input type=checkbox id='lab-$id' data='".$field["name"].", ".$field["created_at"]."' value=" . $id . " class=_check style=opacity: 0;> <span class='label label-default' for='lab-$id'></span>";
}



function lengthMenu()
{
    return ' "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ] ,
              "iDisplayLength": 25, ';
}