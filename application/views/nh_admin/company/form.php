

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
            <form class="form-horizontal" enctype="multipart/form-data"  method="post" action="<?=$action?>"  data-parsley-validate  >
                <div class="box-body">
                  
                  <div class="form-group ">
                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-5">
                      <input id="name" name="name" value="<?=isset($db_data["name"])?$db_data["name"]:""?>" type="text" class="form-control" data-parsley-required="true" >
                    </div>
                  </div>

                  <div class="form-group ">
                    <label for="inputEmail3" class="col-sm-2 control-label">Phone</label>
                    <div class="col-sm-5">
                      <input id="phone" name="phone" value="<?=isset($db_data["phone"])?$db_data["phone"]:""?>" type="text" class="form-control datemask2-phone" data-parsley-required="true"  >
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-5">
                      <input id="email" name="email" value="<?=isset($db_data["email"])?$db_data["email"]:""?>" type="email"  class="form-control" data-parsley-type="email" data-parsley-required="true" >
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="inputEmail3" class="col-sm-2 control-label">Address</label>
                    <div class="col-sm-5">
                      <textarea id="address" name="address" class="form-control" data-parsley-required="true" ><?=isset($db_data["address"])?$db_data["address"]:""?> 
                      </textarea>
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="inputEmail3" class="col-sm-2 control-label">Logo</label>
                    <div class="col-sm-5">
                      <input id="logo" name="logo" value="" type="file" class="form-control" >
                    </div>
                  </div>
                  
                  <?php if($db_data["logo"] != ""){ ?>
                    <div class="form-group ">
                      <label for="inputEmail3" class="col-sm-2 control-label">
                          Delete Logo <input type="checkbox" class="minimal" name="delete_logo" > 
                      </label>
                      <div class="col-sm-5">
                        <img src="<?=base_url($db_data["logo"])?>" class="col-md-5" style="border:1">
                      </div>
                    </div>
                  <?php } ?>

                  <div class="form-group ">
                    <label for="inputEmail3" class="col-sm-2 control-label">Facebook</label>
                    <div class="col-sm-5">
                      <input id="facebook_link" name="facebook_link" value="<?=isset($db_data["facebook_link"])?$db_data["facebook_link"]:""?>" type="url" class="form-control" data-parsley-type="url"  >
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="inputEmail3" class="col-sm-2 control-label">Twitter</label>
                    <div class="col-sm-5">
                      <input id="twitter_link" name="twitter_link" value="<?=isset($db_data["twitter_link"])?$db_data["twitter_link"]:""?>" type="url" class="form-control" data-parsley-type="url"  >
                    </div>
                  </div>
                  
                  <div class="form-group ">
                    <label for="inputEmail3" class="col-sm-2 control-label">Google</label>
                    <div class="col-sm-5">
                      <input id="google_link" name="google_link" value="<?=isset($db_data["google_link"])?$db_data["google_link"]:""?>" type="url" class="form-control" data-parsley-type="url"  >
                    </div>
                  </div>
                
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-sm-2 col-sm-offset-2" >
                    <button type="submit" class="btn btn-info ">Submit</button>
                    <button type="reset" class="btn btn-default ">Reset</button>

                  </div>
                </div><!-- /.box-footer -->
            </form>
          </div>
          
      </div>
    </div>
  </div>
<!-- /.form -->
