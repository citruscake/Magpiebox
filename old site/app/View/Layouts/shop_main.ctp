<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title_for_layout; ?></title>
<link href='http://fonts.googleapis.com/css?family=Fanwood+Text' rel='stylesheet' type='text/css'>
<link href="/css/bootstrap/bootstrap.css" rel="stylesheet" media="screen">
<link href="/css/nav_bar/styles.css" rel="stylesheet" media="screen">
<link href="/css/custom_snippets.css" rel="stylesheet" media="screen">
<link href="/css/navigation_styles.css" rel="stylesheet" media="screen">
<link href="/css/tag-it/jquery.tagit.css" rel="stylesheet" media="screen">
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script src="/jquery/jquery-ui-1.10.2/ui/jquery-ui.js"></script>
<script src="/jquery/jquery_smart_autocomplete/jquery.smart_autocomplete.js"></script>
<script src="/js/tag-it/tag-it.js"></script>

<script src="/jquery/fineuploader/jquery.fineuploader-3.3.0.js"></script>

<script src="/js/nav_js.js"></script>
<script src="/js/bootstrap/bootstrap.min.js"></script>
<script src="/jquery/jquery.elevateZoom-2.5.5.min.js"></script>
<script src="/jquery/timeout/jquery.ba-dotimeout.min.js"></script>
<script src="/js/email_check_script/email_check_js.js"></script>
<script src="/js/jshash-2.2/md5-min.js"></script>
<script src="/js/password_strength/script.js"></script>
<script src="/js/basket_js.js"></script>
<script src="/js/order_js.js"></script>


<?php /* <script src="/js/tag-it/tag-it.js"></script> */ ?>
<?php /* <script src="/jquery/jquery_smart_autocomplete/jquery.smart_autocomplete.js"></script> */?>
<link href='http://fonts.googleapis.com/css?family=Arimo' rel='stylesheet' type='text/css'>

<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.0/css/font-awesome.css" rel="stylesheet">

<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,900' rel='stylesheet' type='text/css'>

<script src="/js/form_js.js"></script>

	<?php 
		
		//if($page_type == "shop") {
		
			$availableTags = $this->requestAction('products/getAvailableTags');
			echo "<script type=\"text/javascript\">";
			echo "var availableTags = ["; 
			if(sizeof($availableTags) > 0) {
				foreach($availableTags as $i=>$tag) {
					echo "\"".$tag."\"";
					if($i != (sizeof($availableTags)-1)) {
						echo ",";
					}
				}
				echo "];";
			}
			echo "</script>";
		/*}
		else {
			echo "<script type=\"text/javascript\">";
			echo "var availableTags = [];";
			echo "</script>";
		}*/

		
?>

<style type="text/css">

	#mb_header {
		//width:100%;
		//height:140px;
		background-color:rgb(29, 29, 29);
		position:relative;
		//-webkit-box-shadow:  0px 1px 3px 2px rgba(1, 1, 1, 0.1);
        
        //box-shadow:  0px 1px 3px 2px rgba(1, 1, 1, 0.1);
		//border-bottom:1px solid #eeeeee;
	}
	
	#mb_products_container {
		margin-top:25px;
	}
	
	#mb_logo_frame {
	
		//width:150px;
		//width:100%;
		position:relative;
		margin-top:50px;
		margin-left: 24px;
	
	}
	
	#mb_nav_container {
		margin-top:5px;
		width:100%;
		margin-left:auto;
		margin-right:auto;
	}
	
	#mb_categories {
		//margin-left:28px;
		//margin-top:10px;
		//width:170px;
	}
	
	#mb_product_list {
		margin-left: 20px;
		margin-top: -50px;
	}
	
	.mb_thumbnail_width {
		width: 188px;
	}
	
	#mb_product_container {
		margin-left:-10px;
		//margin-top:-40px;
		margin-top: -25px;
	}
	
	#mb_blog_container {
		margin-left:40px;
		margin-top:10px;
	}
	
	#mb_find_us_container {
		margin-left:40px;
		margin-top:10px;
	}
	
	#mb_google_maps_container {
		margin-left:40px;
	}
	
	#mb_contact_container {
		margin-left:40px;
		margin-top:10px;
	}
	
	#mb_meet_the_team_container {
		margin-left:40px;
		margin-top:10px;
	}
	
	.mb_image_placeholder {
		width:100%;
		height:250px;
		background-color:#dddddd;
		//margin:5px;
	}
	
	.mb_image_frame {
		margin-right:10px;
		padding:5px 15px 0px 0px;
	}
	
	#mb_home_container {
		margin-left:10px;
	}
	
	#mb_header_frame {
		//width: 1101px;
		margin-left:auto;
		margin-right:auto;
		position:relative;
		background-color:#000000;
	}
	
	#mb_daily_item_container {
		width:100%;
		height:200px;
		//background-color:#dddddd;
		background-position:center center;
		background-size:cover;
	}
	
	#mb_login_frame {
		position:relative;
		//left:120px;
		margin-top:12px;
		margin-left:12px;
		//width:100px;
		//height:40px;
		//min-width:100px;
	}
	
	#mb_basket_frame {
		position:relative;
		//left:228px;
		margin-top: 12px;
		margin-left:6px;
		//width:100px;
		//height:40px;
	}
	
	#mb_login_container {
		//margin-left:30px;
		//margin-right:auto;
		position:relative;
		margin-top:60px;
		width:600px;
		//text-align:center;
	}
	
	#mb_search_container {
		//margin-top:80px;
		//top:-5px;
		position:relative;
		//left:484px;
	
	}
	
	/*//ul.smart_autocomplete_container {
	.smart_autocomplete_container {
		margin: 10px 0px 0px 0px;
	}
	//ul.smart_autocomplete_container li {
	.smart_autocomplete_container li {
		list-style: none; 
		cursor: pointer; 
		margin: 0px; 
		padding: 5px; 
		width:158px; 
		background-color: #ffffff; 
		border-color:#eeeeee; 
		border-style:solid;
		border-width:0px 1px 1px 1px;
		color:#333333;
	}
	//ul.smart_autocomplete_container li:hover {
	.smart_autocomplete_container li:hover {
		background-color: rgb(232, 247, 255); 
	}
    //li.smart_autocomplete_highlight {
	.smart_autocomplete_highlight {
		background-color: #000000;
	}*/
	
	#mb_register_container {
		margin-left:40px;
		//margin-right:auto;
		position:relative;
		margin-top:20px;
		width:700px;
	}
	
	#mb_password_strength_result {

	}
	
	.mb_password_weak {
		
		color:#666666;
	
	}
	
	.mb_password_good {
		
		color:#333333;
	
	}
	
	.mb_password_strong {
		
		color:#000000;
	
	}
	
	.mb_password_short {
		
		color:#999999;
	
	}
	
	#mb_basket_container {
	
		margin-left:20px;
	
	}
	
	#mb_total_frame {
		position:relative;
		left:77px;
	}
	
	#mb_order_login_container {
		margin-left:40px;
		margin-top:10px;
	
	}
	
	#mb_address_edit_container {
		margin-left:40px;
		margin-top:20px;
	}
	
	#mb_register_outer_container {
		margin-left:40px;
		margin-top:20px;
	}
	
	#mb_login_outer_container {
		margin-left:40px;
		margin-top:20px;
	}
	
	#mb_billing_container {
		margin-left:40px;
		margin-top:20px;
	}
	
	#mb_confirm_order_container {
		margin-left:40px;
		margin-top:20px;
	
	}
	
	.mb_logo_image_sizes {
		min-height:40px;
		min-width:235px;
	}
	
	#mb_main_container {
		background-color:#ffffff;

	//min-height: 100%;
	}
	
	.page_container {
		min-height:100%;
		background-color:#ffffff;
	}

	<?php/*::selection {
		background:#A643F5;
		color:#ffffff;
	}

	::-moz-selection {
		background:#A643F5;
		color:#ffffff;
	}

	::-webkit-selection {
		background:#A643F5;
		color:#ffffff;
	}*/?>
</style>
</head><body>
<div class="container-fluid" style="margin-top:0px;background-color:#ffffff;">
	<div id="mb_header" class="row-fluid">
		<div class="span12" style="width:95%; margin-left:2.5%;">
		<div class="row-fluid">
			<div class="span3">
				<div id="mb_logo_frame">
					<a href="/products" style="border-style:none;"/><img src="/img/magpieboxlogowhite.png" style="height:35px;" class="mb_logo_image_sizes"/></a>
				</div>
			</div>
			<div class="span9 pull-right">
			</div>
		</div>
		<div class="row-fluid" style="background-color:;">
			<div class="span6" style="width:540px;">
					<div class="navbar">
					<div class="navbar-inner">
					<ul class="nav">
						<li class="<?php if($this->action == "home") {echo "active";} ?> divider-vertical">
							<?php echo $this->Html->link("Home", array("controller"=>"main", "action"=>"home")); ?>
						</li>
						<li class="<?php if($this->params['controller'] == "products" && $this->action != "admin_index") {echo "active";} ?> divider-vertical"><?php echo $this->Html->link("Products", array("controller"=>"products", "action"=>"index")); ?></li>
						<li class="<?php if($this->action == "blog") {echo "active";} ?> divider-vertical"><?php echo $this->Html->link("Blog", array("controller"=>"main", "action"=>"blog")); ?></li>
						<li class="<?php if($this->action == "find_us") {echo "active";} ?> divider-vertical"><?php echo $this->Html->link("Find us", array("controller"=>"main", "action"=>"find_us")); ?></li>
						<li class="<?php if($this->action == "meet_the_team") {echo "active";} ?> divider-vertical"><?php echo $this->Html->link("Meet the team", array("controller"=>"main", "action"=>"meet_the_team")); ?></li>
						<li class="<?php if($this->action == "contact") {echo "active";} ?> divider-vertical"><?php echo $this->Html->link("Contact", array("controller"=>"main", "action"=>"contact")); ?></li>
					</ul>
					</div></div>
				</div>
			<div class="span4" style="margin-left:0px; padding-top:12px;">
				<?php echo $this->element('search_bar'); ?>
			</div>
			<div class="span3 pull-right">
				<div class="row-fluid"><div class="span9 pull-right">
					<div class="navbar">
					<div class="navbar-inner">
					<ul class="nav">
						<li class="<?php if($this->params['controller'] == "baskets") {echo "active";} ?> divider-vertical"><a href="/baskets/index">Basket <i class="icon-shopping-cart"></i></a></li>
						<li class="<?php if($this->action == "login") {echo "active";} ?> divider-vertical">
						<?php 
							if(isset($user)) { //must be logged in
								if($user['role'] == "admin") {
									echo "<a href=\"/users/admin_index\">";
								}
								else {
									echo "<a href=\"/users/index\">";
								}
							}
							else {
								echo "<a href=\"/users/login\">";
							}
						?>
						Account  <i class="icon-lock"></i></a></li>
					</ul>
					</div>
				</div>
				</div></div>
			</div>
		</div>
	</div>
	</div>
	<?php /*</div>*/?>
	<?php /*<div class="container-fluid" id="mb_main_container" style="bottom:0px;"> */?>
		<div class="row-fluid" id="mb_main_container">
				<div class="row-fluid">
					<div class="row-fluid">
					<?php if($page_type == "admin") { ?>
								<h2 style="margin-top:20px; margin-left:268px; margin-bottom:20px;"><?php echo $heading; ?></h2>
					<?php	} else { ?>
						<h2 style="margin-top:20px; margin-left:60px; margin-bottom:20px;"><?php echo $heading; ?></h2>
					<?php } ?>
					</div>
					<div class="span12" style="width:91%; margin-left:4.5%;">
					<?php if ($page_type == "shop") { ?>
						<div class="row-fluid" style="margin-top:30px;">
							<div class="span2">
								<div class="row-fluid">
									<h4 style="margin: 0px;">Categories</h4>
								</div>
								<div class="row-fluid">
									<?php echo $this->element('categories'); ?>
								</div>
							</div>
						<div class="span10">
							<div class="row-fluid">
								<?php 
									echo $content_for_layout;
								?>
							</div>
						</div>
					</div>
					<?php } else if ($page_type == "admin") { ?>
						<div class="row-fluid">
							<div class="span2">
								<div class="row-fluid">
									<h4 style="margin: 0px;">Sections</h4>
								</div>
								<div class="row-fluid">
									<?php echo $this->element('admin_sections'); ?>
								</div>
							</div>
						<div class="span10">
							<div class="row-fluid">
								<?php 
									echo $content_for_layout;
								?>
							</div>
						</div>
					</div>
				<?php } else if($page_type == "account") {
			
					echo $content_for_layout;
			
				} else {
					echo $content_for_layout;
				} ?>
			</div>
		</div>
	</div>
</div>
</body>
</html>