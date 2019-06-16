

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
                      <?php echo form_input('name',set_value('name',isset($db_data)?$db_data['name']:''),'id="name" class="form-control" readonly  '); ?>
                    </div>
                  </div>

                  <div class="form-group ">
                    <?php echo form_label('Page','name',array('class'=>'control-label col-sm-2')); ?>
                    <div class="col-sm-5">
                    </div>
                  </div>
                  <hr>

                 
                  <?php foreach ($categories as $cat => $category) { ?>
                      <?php $item = $this->item_model->all(" AND access_category_id = ".$category["id"]."  ORDER BY display_order ASC "); ?>

                    <div class="form-group ">
                      <?php echo form_label(strtoupper($category["code"]),'name',array('class'=>'control-label col-sm-3 success')); ?>
                      <div class="col-sm-8">
                          <table class="table table-border table-stripped">
                            <?php $i=1; ?>
                            <?php foreach ($item as $key => $value) { ?>
                              <?php $access_options = explode(",", $value["access_options"]); ?>
                              <tr>
                                  <td width="50%">
                                    <?=$i++?>. <?=ucwords($value["code"])?>
                                  </td>
                                  <td  width="50%">
                                    <select class="form-control input-sm" name="item[<?=$value["id"]?>]">
                                      <?php foreach ($access_options as $ac_op_key => $ac_op_val) {
                                          $checked='';
                                          $chk = $this->user_access_model->find($db_data["id"],"user_group_id"," AND access_item_id =  ".$value["id"]);
                                          if(isset($chk["id"])){
                                              if($chk["access_type"] == $ac_op_val){
                                                $checked = 'selected="selected"';
                                              }
                                          }
                                          echo '<option value="'.$ac_op_val.'" '.$checked.' >'.$ac_op_val.'</option>';
                                      }?>
                                    </select>
                                  </td>
                              </tr>
                            <?php } ?>

                          </table>
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

