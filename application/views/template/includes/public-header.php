    <!-- BEGIN HEADER -->
    <div class="header">
      <div class="container">
        <a class="site-logo" href="<?=base_url()?>">
          <?php 
              if(isset($company_data["logo"]) && $company_data["logo"] !=""){
                  echo  '<img src="'.base_url($company_data["logo"]).'" alt="logo">';
              }else{
                if(isset($company_data["name"]) && $company_data["name"]!=""){
                    echo $company_data["name"];
                }else{
                    echo "Nh";
                }
              }
          ?>
        </a>
          
        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation  font-transform-inherit">
          <ul>
            <li ><a href="<?=base_url()?>" >Beranda</a></li>
            <?=$this->access_management->menu_public();?>
            <li><a href="<?=base_url('galery')?>" >Galeri</a></li>

            <li class="search-box-menu-mobile">
                <div class="search-box-2">
                  <form class="navbar-form" role="search" action="<?=base_url('search')?>">
                    <div class="input-group">
                        <input type="text" class="form-control input-block" placeholder="Cari" name="q" id="q" autocomplete="off">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </div>
                  </form>
                </div>
            </li>
          </ul>
        </div>
        <!-- END NAVIGATION -->
        
        <div class="header-navigation  font-transform-inherit pull-right">
          <ul>
            
            <li class="menu-search search-box-menu-desktop">
              <span class="sep"></span>
              <button class="btn btn-open-search "  type="button"><i class="glyphicon glyphicon-search"></i></button>   
            </li>
            <li class=" search-box-menu-desktop search-box-menu-desktop-form">
                <div class="search-box-2">
                  <form class="navbar-form" role="search" action="<?=base_url('search')?>">
                        <input type="text" class="form-control input-search-nav" placeholder="Search&hellip;" name="q" id="q" autocomplete="off">
                    <button class="btn btn-close-search " type="button">X</button>      
                  </form>
                  
                </div>
            </li>

          </ul>
        </div>
      </div>
    </div>