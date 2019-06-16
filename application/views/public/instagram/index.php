

<!-- carousel -->
<div class="row">
  <div class="col-md-12">
    <div class="front-carousel">
        <div id="myCarousel" class="carousel-ig slide">
          <!-- Carousel items -->
          <div class="carousel-inner">
            <?php foreach ($slide_db as $key => $value) {?>
              <?php $active = $key<1?"active":""; ?>
              <div class="item <?=$active?>">
                <img width="100%"  class="img-responsive" src="<?=base_url($value["img"])?>" alt="<?=isset($data["alt"])?$data["alt"]:""?>" title="<?=isset($data["alt"])?$data["alt"]:""?>">
              </div>
            <?php } ?>
          </div>
          <!-- Carousel nav -->
          <a class="carousel-control left" href="#myCarousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a class="carousel-control right" href="#myCarousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
        </div>                
    </div>
  </div>
</div>

<!-- END SIDEBAR & CONTENT -->
<script type="text/javascript">
$(function () {
  $('.carousel-ig').carousel({
      interval: 1200
  });
  var token = 'your access token', // learn how to obtain it below
      userid = 1362124742, // User ID - get it in source HTML of your Instagram profile or look at the next example :)
      num_photos = 10; // how much photos do you want to get
   
  $.ajax({
    url: 'https://api.instagram.com/v1/users/' + userid + '/media/recent', // or /users/self/media/recent for Sandbox
    dataType: 'jsonp',
    type: 'GET',
    data: {access_token: token, count: num_photos},
    success: function(data){
      console.log(data);
      for( x in data.data ){
        $('ul').append('<li><img src="'+data.data[x].images.low_resolution.url+'"></li>'); // data.data[x].images.low_resolution.url - URL of image, 306х306
        // data.data[x].images.thumbnail.url - URL of image 150х150
        // data.data[x].images.standard_resolution.url - URL of image 612х612
        // data.data[x].link - Instagram post URL 
      }
    },
    error: function(data){
      console.log(data); // send the error notifications to console
    }
  });

});
</script>