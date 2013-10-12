<html>
<head><link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Bad+Script' rel='stylesheet' type='text/css'>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="/jquery/timeout/jquery.ba-dotimeout.min.js"></script>
<script src="/jquery/jquery-ui-1.10.2/ui/jquery-ui.js"></script>
<script type="text/javascript">

$(document).ready(function() {  
	
	$('#blog_link').click(function() {
		$.get('/main/blog',
		function(data) {
			$('#content_inner_container').html(data);
			$('#title_frame').text('Our Blog');
		});
	});
	
	$('#contact_link').click(function() {
		$.get('/main/contact',
		function(data) {
			$('#content_inner_container').html(data);
			$('#title_frame').text('Contact us');
		});
	});
	
	$('#find_us_link').click(function() {
		$.get('/main/find_us',
		function(data) {
			$('#content_inner_container').html(data);
			$('#title_frame').text('Find us');
		});
	});
	
	$('#meet_the_team_link').click(function() {
		$.get('/main/meet_the_team',
		function(data) {
			$('#content_inner_container').html(data);
			$('#title_frame').text('Meet the team');
		});
	});
	
	//$('#find_us_link').hover(function() {
	$('#navigation_list ul li span').hover(function(event) {
		var hover_id = 'hover_'+(event.target.id);
		$(this).doTimeout(hover_id, 200, function(){
		if(!$(this).hasClass('hover')) {
				$(this).addClass('hover');
				$(this).animate({
					//$(this).css("margin-top", -15px);
					'marginTop': '-3px'
				}, 800, "easeOutBounce", function() {
			});
		}
		});
	},
	function() {
		var hover_id = 'hover_'+(event.target.id);
		$(this).doTimeout(hover_id); //cancel timeout
		
		if($(this).hasClass('hover')) {
			
			//$(this).addClass('hover');
			var self = this;
			setTimeout(function() {
				$(self).removeClass('hover');
			}, 800);

			$(this).animate({
				//$(this).css("margin-top", -15px);
				'marginTop': '+5px'
			}, 400, "easeOutQuad", function() {
			});
		}
	});
	
	$('#meet_the_team_link').hover(function() {
		//$(this).addClass('hover');
	},
	function() {
		//$(this).removeClass('hover');
	});
	
	$('#contact_link').hover(function() {
	//	$(this).addClass('hover');
	},
	function() {
		//$(this).removeClass('hover');
	});
	
	$('#blog_link').hover(function() {
		//$(this).addClass('hover');
	},
	function() {
		//$(this).removeClass('hover');
	});
	
	$('#shop_link').hover(function() {
		//$(this).addClass('hover');
	},
	function() {
		//$(this).removeClass('hover');
	});
	
	$('#shop_link').click(function() {
		window.location = "/products/index";
	});
});

</script>
<style type="text/css">

body {
	margin:0;
	padding:0;
	background-image: url('./img/foggy_birds.png');
}

.hover {
	//text-decoration:underline;
}

#blog_link, #contact_link, #find_us_link, #meet_the_team_link, #shop_link {
cursor: pointer;
font-family: arial;
font-size: 19px;
color: rgb(255, 255, 255);
display: block;
margin-right: 7px;
letter-spacing: 2px;
float: left;
background: rgb(69,72,77); /* Old browsers */
background: -moz-linear-gradient(top,  rgba(69,72,77,1) 0%, rgba(0,0,0,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(69,72,77,1)), color-stop(100%,rgba(0,0,0,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* IE10+ */
background: linear-gradient(to bottom,  rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45484d', endColorstr='#000000',GradientType=0 ); /* IE6-9 */
padding: 8px 15px 5px 15px;
border-radius: 5px;
height: 43px;
-webkit-box-shadow: 2px 1px 4px 4px rgba(1, 1, 1, 0.1);
box-shadow: 2px 1px 4px 4px rgba(1, 1, 1, 0.1);
border-style: solid;
border-width: 3px;
border-color: rgb(0, 0, 0);
margin-top: 5px;
}

#outer_container {
	width:1300px;
	//margin-top:10px;
	//height:;
	margin-left: auto;
	margin-right: auto;
	position:relative;
	//background-color:#eeeeee;
	//margin-top:10px;
	
}

#inner_container {
	width:1280px;
	//background-color:#ffffff;
	margin-left:auto;
	margin-right:auto;
//box-shadow: 6px 0px 10px -7px #aaa, -6px 0px 10px -7px #aaa;
//background-color:#ffffff;
//border-width:0px 3px 0px 3px;
//border-style:solid;
//border-color:#000000;
}

#header_container {
	width:100%;
	height:181px;
	//background-color:#cccccc;
	//text-align:center;
	padding-top:20px;
	//background-image:url('/img/tileable_wood_texture.png');
	//background-image:url('./img/wood123.jpg');
}

#header_bar {

width:100%;
height: 22px;
background-color: #ffffff;
position: relative;
//-webkit-box-shadow: 0px -2px 3px 2px rgba(1, 1, 1, 0.1);
//box-shadow: 0px -2px 3px 2px rgba(1, 1, 1, 0.1);
border-style: solid;
border-width: 2px 0px 0px 0px;
border-color: rgb(224, 224, 224);

}

#content_container {
	width: 100%;
	height: 1000px;
	background-color: #ffffff;
	-webkit-box-shadow: 0px -2px 3px 2px rgba(1, 1, 1, 0.1);
	box-shadow: 0px -2px 3px 2px rgba(1, 1, 1, 0.1);
}

#content_inner_container {
	width:1080px;
	//background-color:#eeeeee;
	//height:500px;
	margin: 5px 0px 10px 25px;
}

#navigation_container {
	width:100%;
	height:70px;
}

#navigation_inner_container {
	
	position:relative;
	margin-left:20px;
}

#navigation_list {
	padding: 5px 5px 5px 10px;
	margin-top:20px;
}

#navigation_list ul {
	margin:0;
	padding:0;
	list-style-type:none;
}

#navigation_list ul li {
	display: inline;
	//margin-right:7px;
}

#navigation_list ul li a {
	text-decoration:none;
	font-family:trebuchet ms;
	font-size:20px;
	color:#222222;
}

#navigation_list ul li a:hover {
	text-decoration:underline;
}

#signup_form_bar {
	width:100%;
	position:relative;
	height:30px;
	margin-top: -30px;
}

#signup_form_frame {
	width: 380px;
	height: 50px;
	float: right;
	display: inline;
	position: relative;
top: -30px;
	//background-color: #98E100;
	padding: 8px 9px 8px 4px;
//	border-radius: 5px 0px 0px 5px;
	//webkit-box-shadow: 2px 2px 2px 2px rgba(1, 1, 1, 0.1);
	//box-shadow: 2px 2px 2px 2px rgba(1, 1, 1, 0.1);
}

#footer_container {
	width:100%;
	height:100px;
	background-color:#333333;
}

#title_bar {
	width:100%;
	//background-color:#dddddd;
}

#title_container {
	//margin: 10px 0px 5px 10px;
}

#title_frame {
	font-family: arial;
	font-size: 0px;
	color: rgb(46, 46, 46);
	width: 300px;
}

#primary_column {
	width:980px;
	float:left;
	display:inline;
}

#secondary_column {
	width:300px;
	float:right;
	display:inline;
}

#header_image {
	width:600px;
	margin-top:10px;
	margin-left:30px;
}

</style>
<title><?php echo $title_for_layout; ?></title>
</head>
<body>
<div id="outer_container">
	<div id="inner_container">
		<div id="header_container">
			<a href="/main/welcome"><img src="/img/magpieboxlogo.png" id="header_image"/></a>
		<div id="navigation_container">
			<div id="navigation_inner_container">
				<div id="navigation_list">
				<ul>
					<?php /*<li><?php echo $this->Html->link('Blog', array('controller'=>'main', 'action'=>'blog'), array('id'=>'blog_link')); ?></li>
					<li><?php echo $this->Html->link('Find Us', array('controller'=>'main', 'action'=>'find_us'), array('id'=>'find_us_link')); ?></li>
					<li><?php echo $this->Html->link('Contact', array('controller'=>'main', 'action'=>'contact'), array('id'=>'contact_link')); ?></li>*/ ?>
					<li><span id="blog_link">Blog</span></li>
					<li><span id="shop_link">Shop</span></li>
					<li><span id="find_us_link">Find us</span></li>
					<li><span id="contact_link">Contact</span></li>
					<li><span id="meet_the_team_link">Meet the team</span></li>
				</ul>
				</div>
			</div>
		</div>
		</div>
		<div id="header_bar"></div>
		<div id="content_container">
				<div id="primary_column">
					<div id="title_bar">
						<div id="title_container">
							<div id="title_frame"><?php //echo $custom_title 
							?></div>
						</div>
					</div>	
					<div id="content_inner_container">
						<?php echo $content_for_layout; ?>
					</div>
				</div>
				<div id="secondary_column">
					<div id="signup_form_bar">
						<div id="signup_form_frame">
							<?php echo $this->Element('email_form'); ?>
						</div>
					</div>
				</div>
		</div>
		<div id="footer_container">
		</div>
	</div>
</div>
</body>
</html>