(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
jQuery(document).ready(function($) {
	$m = $("img").attr("src");
	console.log($m);
       

 $(window).load(function(){
      $(".pane-node-random").sticky({ topSpacing: 20 });
      $("#quehuong").sticky({ topSpacing: 20});
      $(".pane-term-ban-biet").sticky({ topSpacing: 20 });
     $("#pane-node-random").sticky({ topSpacing: 0 });
    });
});
