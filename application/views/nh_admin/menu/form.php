

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
                    <?php echo form_label('Parent','full name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <select class="form-control" name="parent" id="parent" >
                        <option value=""></option>
                        <?php 
                            foreach ($menu_selector as $key => $value) {
                              $selected = isset($db_data["parent"]) && $db_data["parent"] == $value["id"]?'selected="selected"':"";
                              
                              echo '<option value="'.$value["id"].'" '.$selected.' >'.$value["name"].'</option>';
                            }
                        ?>
                      </select>
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <?php echo form_label('Name','Name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php $form = array("name"=>"name","id"=>"name","class"=>"form-control","type"=>"text","required"=>"required","value"=>isset($db_data["name"])?$db_data["name"]:"" ) ?>
                      <?php echo form_input($form); ?>
                    </div>
                  </div>

                  <div class="form-group ">
                    <?php echo form_label('Single Page','full name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <select class="form-control" name="is_single_page" id="is_single_page" required>
                        <?php 
                            foreach ($boolean_selector as $key => $value) {
                              $selected = isset($db_data["is_single_page"]) && $db_data["is_single_page"] == $key?'selected="selected"':"";
                              
                              echo '<option value="'.$key.'" '.$selected.' >'.$value.'</option>';
                            }
                        ?>
                      </select>
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
