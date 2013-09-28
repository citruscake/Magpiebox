<html><head>
<link href='http://fonts.googleapis.com/css?family=Fanwood+Text' rel='stylesheet' type='text/css'>
<style type='text/css'  media='all'>
   //@import '/css/site_styles.css';
   //@import '/css/shop_styles.css';
</style>
<style type="text/css">
	html {
		height:100%;
		margin:0;
		padding:0;
	}

	body {

		//background-image: url('/img/pw_maze_black.png');";
		//background-image: url('/img/smoke1.jpg');
		background-image: url('/img/wallpaper2.jpg');
		//background-image: url('/img/smoke2.jpg');
		//background-image: url('/img/smoke3.jpg');
		margin:0;
		padding:0;
		height:100%;
		//background-color:rgba(0, 0, 0, 1);
		background-position:center center;
		background-repeat:no-repeat;
		background-size:100% 100%;
	}

	#outer_container {
		width:100%;
		min-height:100%;
	}
	
	#gradient_container {
		width:100%;
		//margin-left:auto;
		//margin-right:auto;
		//background-color:#dddddd;
		//margin-top:50px;
		position:relative;
		//height:500px;
		-webkit-box-shadow: 2px 2px 5px 1px rgba(1, 1, 1, 0.1);
		box-shadow: 2px 2px 5px 1px rgba(1, 1, 1, 0.1);
		background-image: url('/img/gradient19.png');
		//was 4
		//background-size: 100%;
		 -o-background-size: 100%;
  -moz-background-size: 100% auto;
  -webkit-background-size:100%;
  background-size: 100% 100%;
		//opacity:0.3;
		//background: rgba(0, 0, 0, 0.1);
		//border-style:solid;
		//border-width:1px 0px 1px 0px;
		//border-color:#ffffff;
		min-height:100%;
		//height:100%;
		background-repeat:no-repeat;
	}
	
	#coming_soon_text {
		font-family: Fanwood Text;
		font-size: 46px;
		font-color:#888888;
	}
	
	#stratford_text {
		font-family: Fanwood Text;
		font-size: 28px;
		color:#ffffff;
	}
	
	#stratford_frame {
		width:400px;
		height:30px;
		//background-color:#cccccc;
		position:relative;;
		left: 415px;
		top: 198px;
	}
	
	#inner_container {
		//width:100%;
		height:500px;
		position:relative;
		background-color:#ffffff;
		//padding:40px;
		padding:1px;
	}
	
	#logo_container {
		width:1100px;
		height:250px;
		position:relative;
		//left:200px;
		//top:40px;
		//background-color:#000000;
		//-webkit-box-shadow: 2px 2px 5px 1px rgba(1, 1, 1, 0.1);
		//box-shadow: 2px 2px 5px 1px rgba(1, 1, 1, 0.1);
		margin-left:auto;
		margin-right:auto;
		//border-radius:1px;
		//left:40px;
		//top: 40%;
		text-align:center;
		margin-top:4.2%;
	}
	
	#logo_frame {
		position:absolute;
		left:20px;
		top:160px;
	}
	
	#coming_soon_frame {
		width:800px;
		height:50px;
		left:150px;
		background-color:#cccccc;
		position:relative;
		top:50px;
		margin-left:20px;
	}
	
	#login_outer_frame {
		width: 730px;
		height:50px;
		//background-color: #dddddd;
		position:relative;
		//top: -5px;
		//left:760px;
		//margin-left:100%;
		opacity:1;
		//margin-right:-750px;
		float:right;
		display:inline;
		margin-right:20px;
		margin-top:15px;
	}
	
	#header_frame {
		width:100%;
		//background-color:#444444;
		//height:90px;
		height:75px;
		//background-image: url('/img/pw_maze_black.png');
		//background-image: url('/img/pw_maze_black.png');
		border-style:solid;
		border-width: 0px 0px 1px 0px;
		//border-color:rgb(68, 55, 43);
		//border-color:rgb(43, 25, 25);
		//border-color:rgb(48, 37, 53);
		//background-color:#000000;
		background: rgba(0, 0, 0, 0.8);
		//display:none;
	}
	
	#footer_frame {
		width:100%;
		//height:90px;
		height:75px;
		//background-image: url('/img/pw_maze_black.png');
		//background-color:#444444;
		border-style:solid;
		border-width: 1px 0px 0px 0px;
		//border-color:rgb(68, 55, 43);
		//border-color:rgb(43, 25, 25);
		//border-color:rgb(48, 37, 53);
		position:absolute;
		//background-color:#000000;
		//opacity:0.7;
		background: rgba(1, 1, 1, 0.8);
		bottom:0;
		//text-align:right;
		//display:none;
	}
	
</style>
</head><body>
	<div id="outer_container">
		<div id="gradient_container">
		<div id="header_frame"></div>
			<div id="logo_container">
				<?php /* <img src="/img/magpieboxlogowhite.png" height="150"/> */ ?>
				<img src="/img/center6.png" height="430"/>
				<?php //was 400 ?>
			</div>
			<?php /* <div id="inner_container">
				 <div id="logo_container">
					<div id="logo_frame">
					</div>
					<div id="stratford_frame">
						<span id="stratford_text">Stratford-upon-Avon</span>
					</div>
				</div>
				<div id="coming_soon_frame">
					<span id="coming_soon_text">Coming soon</span>
				</div> 
			<br class="clear" />
			</br>
			</div> */ ?>
		<div id="footer_frame">
			<div id="login_outer_frame">
				<div id="login_inner_frame">
					<?php
						echo $this->element('login_form_splash', array("mode"=>"splash"));
					?>
				</div>
			</div>
		</div>
		</div>	
	</div>
</body>
</html>