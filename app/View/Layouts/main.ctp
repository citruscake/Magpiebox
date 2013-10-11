<!DOCTYPE html>
<html lang='en'>
  <head>
    <title>
      <?php
      	echo $title_for_layout;
      ?>
    </title>
    <!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
    <!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
    <!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta content='width=device-width, initial-scale=1.0' name='viewport'>
    <meta content='Official website for Magpiebox, Stratford Upon Avon' name='description'>
    <meta charset='utf-8'>
    <link href='/img/favicon.ico' rel='icon' type='image/ico'>
    <link href='/css/bootstrap/bootstrap.css' rel='stylesheet'>
    <link href='/css/styles.css' rel='stylesheet'>
    <link href='http://fonts.googleapis.com/css?family=Bitter' rel='stylesheet'>
    <link href='http://fonts.googleapis.com/css?family=Emblema+One' rel='stylesheet'>
    <script src='/js/vendor/modernizr-2.6.2.min.js'></script>
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
    <script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js'></script>
    <script src='/js/vendor/bootstrap.js'></script>
    <script src='/js/vendor/timeout/jquery.ba-dotimeout.min.js'></script>
    <script src='/js/magpiebox_js.js'></script>
    <script>
      window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')
    </script>
    <script src='/js/vendor/baseline.js'></script>
  </head>
  <body>
    <header id='header'>
      <div class='container-fluid'>
        <div class='row-fluid'>
          <div class='span3'>
            <div id='logo_frame'>
              <img id='logo' src='/img/magpieboxlogowhite.png'>
            </div>
          </div>
        </div>
      </div>
    </header>
    <section id='nav'>
      <div class='container-fluid'>
        <div class='row-fluid'>
          <div class='span10'>
            <nav>
              <div class='nav-bar'>
                <ul class='nav nav-tabs'>
                  <?php
                  	foreach($pages as $page) {
                  		echo "<li ";
                  		if ($page['action'] == $this->params['action']) {
                  			echo "class=\"active\" ";
                  		}
                  		echo ">";
                  		
                  		echo "<a href=\"".$page['url']."\">".$page['title']."</a></li>";
                  	}
                  ?>
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </section>
    <section id='content'>
      <div class='container-fluid'>
        <?php
        	echo $content_for_layout;
        ?>
      </div>
    </section>
    <footer id='footer'>
      <div class='container-fluid'>
        <div class='row-fluid'>
          <div class='span6'></div>
        </div>
      </div>
    </footer>
  </body>
</html>
