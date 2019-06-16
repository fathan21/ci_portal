      <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-12">
            <div class="content-page">
              <?php if(isset($title)){ ?>
                <div class="row">
                  <!-- BEGIN LEFT SIDEBAR -->            
                  <div class="col-md-9 col-sm-9 blog-posts">
                    <h2><?=$title?></h2>
                  </div>
                </div>
              <?php } ?>

              <div class="row">
                <!-- BEGIN LEFT SIDEBAR -->            
                <div class="col-md-9 col-sm-9 blog-posts">
                  
                  <?php foreach ($news_db as $key => $value) {?>

                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <h3><a href="<?=base_url('read/'.$value["id"]."-".str_ireplace(" ",".",strtolower($value["title"])))?>"><?=$value["title"]?></a></h3>
                        <ul class="blog-info">
                          <li> <?=$value["content"]?></li>
                        </ul>
                      </div>
                    </div>
                    <hr class="blog-post-sep" style="margin-bottom: 10px;margin-top: 10px;">
                  <?php } ?>
                  <?php if(count($news_db) == 0){ ?>

                    <div class="row">
                      <div class="col-md-12 col-sm-12">
                        <h3>Oops! Pencarian Tidak Ditemukan.</h3>
                        <ul class="blog-info">
                            <a href="<?=base_url()?>" class="link">Kembali ke Beranda</a>.
                        </ul>
                      </div>
                    </div>

                  <?php } ?>
                </div>
                <!-- END LEFT SIDEBAR -->
                <!-- BEGIN RIGHT SIDEBAR -->            
                <div class="col-md-3 col-sm-3 blog-sidebar">
                  <?=$side_content?>
                </div>
                <!-- END RIGHT SIDEBAR -->          
              </div>
            </div>
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->