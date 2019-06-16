

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
                    <?php echo form_label('Full Name','Name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php $form = array("name"=>"full_name","id"=>"full_name","class"=>"form-control","readonly"=>"readonly","type"=>"text","required"=>"required","value"=>isset($user_data["full_name"])?$user_data["full_name"]:"" ) ?>
                      <?php echo form_input($form); ?>
                    </div>
                  </div>
                  <div class="form-group ">
                    <?php echo form_label('Password Lama','Name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php $form = array("name"=>"password","id"=>"password","class"=>"form-control","type"=>"password","required"=>"required") ?>
                      <?php echo form_input($form); ?>
                    </div>
                  </div>
                  <div class="form-group ">
                    <?php echo form_label('Password Baru','Name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php $form = array("name"=>"new_password","id"=>"new_password","class"=>"form-control","type"=>"password","required"=>"required") ?>
                      <?php echo form_input($form); ?>
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
    { "type": "POST",  "data": { "username": (this.$element), "id":'<?php echo isset($db_data["id"])?$db_data["id"]:""; ?>' } }
  );
</script>
