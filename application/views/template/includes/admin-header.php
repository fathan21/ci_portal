
        <!-- Logo -->
        <a href="<?=base_url('nh_admin/dashboard')?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>N</b>h</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><?=isset($company_data["name"])?$company_data["name"]:"Nh"?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo isset($user_template["full_name"])?$user_template["full_name"]:""; ?> <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?=base_url('nh_admin/login/change_password')?>">Change Password</a></li>
                  <li><a href="<?=base_url('nh_admin/login/logout')?>">Log Out</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>