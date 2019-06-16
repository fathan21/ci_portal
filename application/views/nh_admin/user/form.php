

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
                    <?php echo form_label('User Group','full name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <select class="form-control" name="user_group_id" id="user_group_id" required>
                        <option value=""></option>
                        <?php 
                            foreach ($user_group_selector as $key => $value) {
                              $selected = isset($db_data["user_group_id"]) && $db_data["user_group_id"] == $value["id"]?'selected="selected"':"";
                              
                              echo '<option value="'.$value["id"].'" '.$selected.' >'.$value["name"].'</option>';
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <?php echo form_label('Full Name','full name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php $form = array("name"=>"full_name","id"=>"full_name","class"=>"form-control","type"=>"text","value"=>isset($db_data["full_name"])?$db_data["full_name"]:"" ) ?>
                      <?php echo form_input($form); ?>
                    </div>
                  </div>

                  <div class="form-group ">
                    <?php echo form_label('Username','username',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php echo form_input('username',set_value('username',isset($db_data)?$db_data['username']:''),'id="username" class="form-control" data-parsley-required="true" data-parsley-remote data-parsley-remote-validator="duplikat"  '); ?>
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <?php echo form_label('Phone','phone',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php echo form_input('phone',set_value('phone',isset($db_data)?$db_data['phone']:''),'id="phone" class="form-control" data-parsley-type="digits"  '); ?>
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <?php echo form_label('Email','email',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php $email_form = array("name"=>"email","id"=>"email","class"=>"form-control","data‐parsley‐type"=>"email","type"=>"email","value"=>isset($db_data["email"])?$db_data["email"]:"" ) ?>
                      <?php echo form_input($email_form); ?>
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <?php echo form_label('password','password',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php echo form_password('password','',isset($db_data)?'  class="form-control" id="pwd"':'  class="form-control"  data-parsley-required="true" id="pwd" '); ?>
                    </div>
                  </div>
                  <?php if(!isset($db_data)){ ?>
                    <div class="form-group ">
                      <?php echo form_label('Confirm Password','password_1',array('class'=>'control-label col-sm-2')); ?>
                      <div class="col-sm-5">
                        <?php echo form_password('password_1',set_value('password_1',isset($db_data)?'':''),isset($db_data)?'class="form-control" data-parsley-equalto="#pwd"':'class="form-control" data-parsley-equalto="#pwd" required  '); ?>
                      </div>
                    </div>
                  <?php } ?>
                
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
  window.Parsley.addAsyncValidator('duplikat', function (xhr) {
    console.log(xhr.responseText);
      if(xhr.status == '200'){
        var response = $.parseJSON(xhr.responseText);
        if(response.msg == 0){
            return 200;
        }   
      }
    return 404 === xhr.status;
  }, '<?php echo base_url('nh_admin/user/duplikat') ?>',
    { "type": "POST",  "data": { "username": (this.$element), "id":'<?php echo isset($db_data["id"])?$db_data["id"]:""; ?>',
                                  "<?php echo $this->config->item('csrf_token_name'); ?>":"<?php echo $this->session->userdata($this->config->item('csrf_token_name')); ?>" } }
  );
</script>
