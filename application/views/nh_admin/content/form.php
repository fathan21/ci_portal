
<!-- form (Stat box) -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
          
          <div class="box-header with-border">
              <h3 class="box-title"><?=$title?></h3>
          </div><!-- /.box-header -->

          <div class="box-body">
            <!-- BEGIN ALERT BOX -->
            <?php if(isset($msg) && $msg!=""){?>
              <div class="col-md-10 col-md-offset-1">
                <div class="alert alert-<?=$msg_status?> alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?=$msg?>
                </div>
              </div>
            <?php } ?>
            <!-- END ALERT BOX -->

            <!-- form start -->
            <?php echo form_open_multipart($action, 'class="form-horizontal" method="post" data-parsley-validate'); ?>
                <div class="box-body">
                  
                  <div class="form-group ">
                    <?php echo form_label('Title*','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-4">
                      <?php $form = array("name"=>"title","id"=>"title","class"=>"form-control","type"=>"text","required"=>"required","value"=>isset($db_data["title"])?$db_data["title"]:"" ) ?>
                      <?php echo form_input($form); ?>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-6">

                      <div class="form-group ">
                        <?php echo form_label('Section*','',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                          <select class="form-control" name="menu_parent_id" id="menu_parent_id" required>
                            <option value=""></option>
                            <?php 
                                foreach ($menu_parent_selector as $key => $value) {
                                  $selected = isset($db_data["menu_parent_id"]) && $db_data["menu_parent_id"] == $value["id"]?'selected="selected"':"";
                                  
                                  echo '<option value="'.$value["id"].'" '.$selected.' >'.$value["name"].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                      </div>

                    </div>
                    <div class="col-md-6">

                      <div class="form-group ">
                        <?php echo form_label('Kategori*','',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                          <select class="form-control" name="menu_id" id="menu_id" required>
                            <option value=""></option>
                            <?php 
                                foreach ($menu_selector as $key => $value) {
                                  $selected = isset($db_data["menu_id"]) && $db_data["menu_id"] == $value["id"]?'selected="selected"':"";
                                  
                                  echo '<option value="'.$value["id"].'" '.$selected.' >'.$value["name"].'</option>';
                                }
                            ?>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="form-group ">
                    <?php echo form_label('Penulis','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-4">
                      <select class="form-control" name="writer" id="writer" required>
                        <option value=""></option>
                        <?php 
                            foreach ($user_selector as $key => $value) {
                              $selected = isset($db_data["writer"]) && $db_data["writer"] == $value["id"]?'selected="selected"':"";
                              
                              echo '<option value="'.$value["id"].'" '.$selected.' >'.$value["full_name"].'</option>';
                            }
                        ?>
                      </select>

                    </div>
                  </div>

                  <hr>

                  <div class="form-group ">
                    <?php echo form_label('Buka Photo','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-4">
                      <button class="btn btn-primary" type="button" id="galery_btn_open">OPEN </button>
                      <input type="hidden" name="galery_id" id="galery_id" value="<?php echo isset($db_data["galery_id"])?$db_data["galery_id"]:"";  ?>">
                    </div>
                  </div>

                  <div class="form-group galery_id" <?php echo isset($db_data["galery_id"]) && $db_data["galery_id"] !=""?'':'style="display:none;"'; ?> >
                    <?php echo form_label('','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-4">
                      <img id="image_path" src="<?php echo isset($db_data["image_path"]) && $db_data["image_path"] !=""?$db_data["image_path"]:'' ?>" width="50%" class="col-md-12" alt="">
                    </div>
                  </div>

                  <hr>
                  
                  <div class="form-group ">
                    <?php echo form_label('Photo Caption*','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-4">
                      <?php $form = array("name"=>"photo_caption","id"=>"photo_caption","class"=>"form-control","type"=>"text","value"=>isset($db_data["photo_caption"])?$db_data["photo_caption"]:"" ) ?>
                      <?php echo form_input($form); ?>
                    </div>
                    <?php echo form_label('Photographer*','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-4">
                      <?php $form = array("name"=>"photographer","id"=>"photographer","class"=>"form-control","type"=>"text","value"=>isset($db_data["photographer"])?$db_data["photographer"]:"" ) ?>
                      <?php echo form_input($form); ?>
                    </div>
                  </div>

                  <hr>
                  <div class="form-group ">
                    <div class="col-sm-4">
                      <h2>Content</h2>
                    </div>
                  </div>
                  <div class="form-group ">
                    <div class="col-sm-4">
                      Content Lead
                    </div>
                  </div>
                  <div class="form-group ">
                    <div class="col-sm-12">
                      <textarea class=" form-control " name="lead" id="mini"><?=isset($db_data["lead"])?$db_data["lead"]:""?></textarea>
                    </div>
                  </div>
                  <div class="form-group ">
                    <div class="col-sm-4">
                      Content Body
                    </div>
                  </div>
                  <div class="form-group ">
                    <div class="col-sm-12">
                      <textarea class="ckeditor form-control " name="content" id="content"><?=isset($db_data["content"])?$db_data["content"]:""?></textarea>
                    </div>
                  </div>
                    
                  <hr>

                  <div class="form-group ">
                    <?php echo form_label('Berita Terkait','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-4">
                      <button class="btn btn-primary" type="button" id="berita_terkait_btn">Tambah </button>
                      <input type="hidden" name="terkait" id="terkait" value="<?php echo isset($db_data["terkait"])?$db_data["terkait"]:"";  ?>">
                    </div>
                  </div>
                  <div class="form-group ">
                    <?php echo form_label('','',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-4 terkait_title">
                      <?php echo isset($db_data["terkait_title"])?$db_data["terkait_title"]:"";  ?>
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="col-md-6">

                      <div class="form-group ">
                        <?php echo form_label('Sumber*','',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                          <?php $form = array("name"=>"sumber","id"=>"sumber","class"=>"form-control","type"=>"text","value"=>isset($db_data["sumber"])?$db_data["sumber"]:"" ) ?>
                          <?php echo form_input($form); ?>
                        </div>
                      </div>
                  
                      <div class="form-group ">
                        <?php echo form_label('Meta Keyword*','',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                          <?php $form = array("name"=>"key_word","id"=>"key_word","class"=>"form-control","type"=>"text","required"=>"required","value"=>isset($db_data["key_word"])?$db_data["key_word"]:"" ) ?>
                          <?php echo form_input($form); ?>
                        </div>
                      </div>

                      <div class="form-group ">
                        <?php echo form_label('Status','full name',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                          <select class="form-control" name="status" id="status-p" required>
                            <?php 
                                foreach ($status_selector as $key => $value) {
                                  $selected = isset($db_data["status"]) && $db_data["status"] == $value?'selected="selected"':"";
          
                                  echo '<option value="'.$value.'" '.$selected.' >'.$value.'</option>';
                                }
                            ?>
                          </select>
                        </div>
                      </div>

                    </div>
                    <div class="col-md-6">

                      <div class="form-group ">
                        <?php echo form_label('Tag*','',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                          <?php $form = array("name"=>"tags","id"=>"tags","class"=>"form-control","type"=>"text","required"=>"required","value"=>isset($db_data["tags"])?$db_data["tags"]:"" ) ?>
                          <?php echo form_input($form); ?>
                        </div>
                      </div>
                  
                      <div class="form-group ">
                        <?php echo form_label('Meta Description*','',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                          <?php $form = array("name"=>"description","id"=>"description","class"=>"form-control","type"=>"text","required"=>"required","value"=>isset($db_data["description"])?$db_data["description"]:"" ) ?>
                          <?php echo form_input($form); ?>
                        </div>
                      </div>

                      <div class="form-group from-later" style="<?=isset($db_data['status']) && $db_data['status']=='later'?'':'display:none' ?>">
                        <?php echo form_label('Later','full name',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                            <div class="input-group date form_advance_datetime_later input-large" >
                              <input type="text" size="16" readonly class="form-control" name="later" id="later" 
                                value="<?=isset($db_data['publish_date']) && $db_data['publish_date']!=''?$db_data['publish_date']:date('Y-m-d H:00',strtotime("+3 hour",time() )) ?>">
                              <span class="input-group-btn">
                              <button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
                              </span>
                            </div>
                        </div>
                      </div>

                    </div>
                  </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-sm-2 col-sm-offset-2" >
                    <button type="submit" class="btn btn-info ">Submit</button>
                    <a href="<?=base_url($back_link)?>" class="btn btn-default ">Cancel</a>

                  </div>
                </div><!-- /.box-footer -->
            </form>
          </div>
          
      </div>
    </div>
  </div>
<!-- /.form -->
<script type="text/javascript">
  $(function () {
    
    if ( !CKEDITOR.env.ie || CKEDITOR.env.version > 7 ){
          CKEDITOR.env.isCompatible = true;
    }
    CKEDITOR.replace( 'mini', {
            toolbar: [
              [ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ],
              [ 'FontSize', 'TextColor', 'BGColor' ]
            ]
    });

    $("#menu_parent_id").change(function () {
        var id = this.value;
        var url = "<?=base_url('nh_admin/content/get_menu/')?>/"+id;
        var data = $.api_get(url);
        $("#menu_id").html(data);
    });
    $("#berita_terkait_btn").click(function  () {
        popup("<?=base_url('nh_admin/content/popup')?>");
    });

    $("#status-p").change(function  () {
        if(this.value=='later'){
          $(".from-later").show();
        }else{
          $(".from-later").hide();
        }
    });

  });
  function get_terkait (id,title) {
      $("#terkait").val(id);
      var data = "";
      for (var i = 0; i < title.length; i++) {
          data += title[i]+" <br> ";
      };
      $(".terkait_title").html(data);
      $("#modal_admin").modal("hide");
  }
    

</script>


