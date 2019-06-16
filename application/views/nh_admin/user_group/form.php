

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
                    <?php echo form_label('Name','name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                      <?php echo form_input('name',set_value('name',isset($db_data)?$db_data['name']:''),'id="name" class="form-control" data-parsley-required="true"  '); ?>
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

