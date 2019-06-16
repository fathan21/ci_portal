
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

                  <div class="form-group ">
                    <?php echo form_label('Buka Galery','',array('class'=>'control-label col-sm-2')); ?>
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
                    

                  <div class="row">
                    <div class="col-md-6">

                  
                      <div class="form-group ">
                        <?php echo form_label('Meta Keyword*','',array('class'=>'control-label col-sm-4')); ?>
                        <div class="col-sm-8">
                          <?php $form = array("name"=>"key_word","id"=>"key_word","class"=>"form-control","type"=>"text","required"=>"required","value"=>isset($db_data["key_word"])?$db_data["key_word"]:"" ) ?>
                          <?php echo form_input($form); ?>
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
    

  });
    

</script>


