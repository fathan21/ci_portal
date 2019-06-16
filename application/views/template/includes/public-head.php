  <title><?=isset($meta["title"])?$meta["title"]:''?></title>
  <meta charset="utf-8">
  <!-- Chrome, Firefox OS and Opera -->
  <meta name="theme-color" content="#B22222">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#B22222">
  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="shortcut icon" href="<?php echo base_url()."public/images/logo/default_logo_2.png"; ?>"  />
  <!-- Bing -->
  <meta name="msvalidate.01" content="F1B0A58E9E348F32E1EEEE53015AD451" />
  <!--Google -->
  <meta name="google-site-verification" content="1jM9CMjIlXVJLjY2BEQKvgtYNPqmRuNplMilyy-7EuI">
  <!--link rel="alternate" hreflang="x-default" href="http://www.jacatra.net" /-->
  <!-- for Google -->
  <link href="<?=isset($company_data["google_link"])?$company_data["google_link"]:""?>" rel="publisher" /> <!-- ubh -->
  <meta name="description" content="<?=isset($meta["description"])?$meta["description"]:''?>" itemprop="description" />
  <meta name="keywords" content="<?=isset($meta["keywords"])?$meta["keywords"]:''?>" itemprop="keywords" />

  <meta name="author" content="<?=isset($company_data["name"])?$company_data["name"]:""?>" /><!-- ubh -->
  <meta name="copyright" content="2016" itemprop="dateline" /><!-- ubh -->
  <meta name="application-name" content="<?=$meta['title']?>" /><!-- ubh -->
  <meta content="<?=isset($meta["content"])?$meta["content"]:''?>" itemprop="headline" /><!-- ubh -->
  <meta name="googlebot" content="<?=isset($meta["tags"])?$meta["tags"]:''?>" /><!-- ubh -->
  <meta name="thumbnailUrl" content="<?=isset($meta["content"])?$meta["content"]:''?>" itemprop="thumbnailUrl" /><!-- ubh -->

  <meta name="google" content="notranslate" />
  <meta name="google" content="nositelinkssearchbox" />
  <meta name="google" content="notranslate" />
  <meta name="robots" content="index, follow" />

  <!-- for Facebook -->          
  <meta property="og:title" content="<?=isset($meta["title"])?$meta["title"]:''?>" />
  <meta property="og:site_name" content="<?=isset($meta["site_name"])?$meta["site_name"]:''?>" /><!-- ubh -->
  <meta property="og:type" content="<?isset($meta['type'])?$meta['type']:'article'?>" />
  <meta property="og:image" content="<?=isset($data["img"])?base_url($data["img"]):''?>" />
  <meta property="og:url" content="<?=current_url();?>" />
  <meta property="og:description" content="<?=isset($meta["description"])?$meta["description"]:''?>" />
  <meta property="fb:app_id" content="<?=isset($meta["fb_app_id"])?$meta["fb_app_id"]:''?>" /><!-- ubh -->
  <meta property="og:image:type" content="image/jpeg" />
  <meta property="og:image:width" content="780" /> 
  <meta property="og:image:height" content="390" />
  <meta property="article:author" content="<?=isset($company_data["facebook_link"])?$company_data["facebook_link"]:$meta['facebook']?>" itemprop="author" />
  <meta property="article:publisher" content="<?=isset($company_data["facebook_link"])?$company_data["facebook_link"]:$meta['facebook']?>" />
  <meta name="pubdate" content="<?=isset($data["publish_date"])?$data["publish_date"]:""?>" itemprop="datePublished" />
  <meta content="<?=current_url()?>" itemprop="url" />
  <link rel="canonical" href="<?=current_url()?>" />

  <!-- for Twitter -->       
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:title" content="<?=isset($meta["title"])?$meta["title"]:$meta['twitter']?>" />
  <meta name="twitter:site" content="<?=isset($company_data["twitter_at"]) && $company_data["twitter_at"] !='' ?$company_data["twitter_at"]:$meta['twitter']?>" />
  <meta name="twitter:creator" content="<?=isset($company_data["twitter_at"]) && $company_data["twitter_at"] !=''?$company_data["twitter_at"]:$meta['twitter']?>" />
  <meta name="twitter:description" content="<?=isset($meta["description"])?$meta["description"]:$meta['twitter']?>" />
  <meta name="twitter:image" content="<?=isset($data["img"])?base_url($data["img"]):''?>" />
  
  <!-- Fonts START -->
  <!--link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css"-->
  <!-- Fonts END -->

  <!-- Global styles START -->          
  <link href="<?php echo base_url(); ?>public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Global styles END --> 
   
  <!-- Page level plugin styles START -->
  <link href="<?php echo base_url(); ?>public/assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.css" rel="stylesheet">
  <!-- Page level plugin styles END -->

  <!-- Theme styles START -->       
  <!--link href="<?php echo base_url(); ?>public/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/assets/global/css/components.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/assets/frontend/layout/css/style.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/assets/frontend/layout/css/style-responsive.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/assets/frontend/layout/css/themes/red.css" rel="stylesheet" id="style-color">
  <link href="<?php echo base_url(); ?>public/assets/frontend/pages/css/portfolio.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>public/assets/frontend/layout/css/custom.css?ver=0.0.8" rel="stylesheet"-->
  <style type="text/css">
    @import url("<?php echo base_url(); ?>public/assets/global/plugins/font-awesome/css/font-awesome.min.css");
    @import url("<?php echo base_url(); ?>public/assets/global/plugins/bootstrap/css/bootstrap.min.css");
    @import url("<?php echo base_url(); ?>public/assets/global/plugins/carousel-owl-carousel/owl-carousel/owl.carousel.css");
    @import url("<?php echo base_url(); ?>public/assets/global/css/components.css");
    @import url("<?php echo base_url(); ?>public/assets/frontend/layout/css/style.css");
    @import url("<?php echo base_url(); ?>public/assets/frontend/layout/css/style-responsive.css");
    @import url("<?php echo base_url(); ?>public/assets/frontend/layout/css/themes/red.css");
    @import url("<?php echo base_url(); ?>public/assets/frontend/layout/css/custom.css");
    @import url("<?php echo base_url(); ?>public/assets/frontend/pages/css/portfolio.css");

  </style>
  <!-- jQuery 2.1.4 -->
  <script src="<?php echo base_url(); ?>public/assets/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!--script src="<?php echo base_url(); ?>public/assets/admin/plugins/jQuery/jquery-migrate-1.1.1.js"></script-->
  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo base_url(); ?>public/assets/admin/plugins/jQueryUI/jquery-ui.min.js" async></script>
  