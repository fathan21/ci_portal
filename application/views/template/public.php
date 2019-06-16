<!DOCTYPE html>
<html>
<head>
  <?=$head?>
  <script>
    var base_url = '<?=base_url()?>';
    var current_url = '<?=current_url()?>';
    var short_url = '';

    window.fbAsyncInit = function() {
      FB.init({
        appId      : '462773900594509',
        xfbml      : true,
        version    : 'v2.5'
      });
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.5&appId=462773900594509";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
      
    !function(d,s,id){
      var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';
      if(!d.getElementById(id)){
        js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';
        fjs.parentNode.insertBefore(js,fjs);
      }}(document, 'script', 'twitter-wjs');
</script>
</head>
<!-- Head END -->
<!-- Body BEGIN -->
<body class="corporate">
    <!-- BEGIN TOP BAR -->
    <?=$header?>
    <!-- Header END -->
    <!-- BEGIN SLIDER -->
    <!-- END SLIDER -->
    <div class="main">
      <div class="container">
        <?=$content?>
      </div>
    </div>
    <?=$footer?>
    <?=$foot?>

    <script>
       (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })
        (window,document,'script','//www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-75874693-1', 'auto');
        ga('send', 'pageview');

        var shortenUrl = function() {
          
            var request = gapi.client.urlshortener.url.insert({
              resource: {
                longUrl: current_url
              }
            });
            request.execute(function(response) {
                var shortUrl = response.id;
                short_url = response.id;
            });
        };

        function get_url_short () {
          return short_url;
        }

        var google_api_key = 'AIzaSyD7Hs6HPmEXA4ZnwLAfWrMtoQpWr0XZs4M';
        var googleApiLoaded = function() {
          gapi.client.setApiKey(google_api_key);
          gapi.client.load("urlshortener", "v1", shortenUrl);
        };   

        /* disbale right click */
        var message="fungsi klik kanan telah di matikan";
        function clickIE4(){
          if(event.button==2){
            console.log(message);
            return false;
          }
        }
        function clickNS4(e){
          if(document.layers||document.getElementById&&!document.all){
            if(e.which==2||e.which==3){
              console.log(message);
              return false;
            }
          }
        }
        if(document.layers){
          document.captureEvents(Event.MOUSEDOWN);
          document.onmousedown=clickNS4;
        }else if(document.all&&!document.getElementById){
          document.onmousedown=clickIE4;
        }
        document.oncontextmenu=new Function("console.log(message);return false");
        /* end disbale right click */
    </script>
    <script src="https://apis.google.com/js/client.js?onload=googleApiLoaded"></script>
</body>
<!-- END BODY -->
</html>