<!DOCTYPE html>
<html lang="en">
<head>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

<link href="css/bootstrap/bootstrap.min.css" rel="stylesheet" media="screen">

<script src="js/bootstrap.min.js"></script>

<div class="row-fluid">
  <div class="span4">...</div>
  <div class="span4 offset2">...</div>
</div>

<link href='http://fonts.googleapis.com/css?family=Fanwood+Text' rel='stylesheet' type='text/css'>
<style type='text/css'  media='all'>
   @import url('/css/site_styles.css');
   @import url('/css/shop_styles.css');
   @import url('/css/form_styles.css');
   @import url('/css/navigation_styles.css');
</style>

<script src="/jquery/timeout/jquery.ba-dotimeout.min.js"></script>
<script src="/jquery/jquery-ui-1.10.2/ui/jquery-ui.js"></script>
<script src="/js/jshash-2.2/md5-min.js"></script>
<script src="/js/form_js.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	$('#blog_link, #find_us_link, #contact_link, #meet_the_team_link, #the_shop_link').hover(function(){
		$(this).addClass('nav_button_hover_styles');
		$(this).removeClass('nav_button_styles');
		$(this).removeClass('nav_button_text');
		$(this).addClass('nav_button_hover_text');
	},
	function() {
		$(this).addClass('nav_button_styles');
		$(this).removeClass('nav_button_hover_styles');
		$(this).addClass('nav_button_text');
		$(this).removeClass('nav_button_hover_text');
	})
	
});
</script>
</head><body>
	<div id="outer_container">
		<div id="header_container">
			<div id="logo_frame">
				<a href="/products" style="border-style:none;"/><img src="/img/magpieboxlogowhite.png" height="45"/></a>
			</div>
			<div id="login_frame">
				<?php 
			
				if ($this->Session->check('Auth.User')) {
				
					echo $this->html->link("My Account", array("controller"=>"users", "action"=>"index"), array("class"=>"link_c"));
					echo "</br>";
					$user = $this->Session->read('Auth.User');
					//$user = $this->User->find('first', array("conditions"=>array("username"=>$this->Session->read('Auth.User')['username'])));
					echo "Welcome ".$user['User']['full_name'];
					
				}
				else {
					echo $this->html->link("My Account", array("controller"=>"users", "action"=>"login"), array("class"=>"link_c"));
				}
				
				?>
			</div>
			<div id="basket_frame">
				<?php echo $this->Html->link("View Basket",array("controller"=>"baskets", "action"=>"index"), array("class"=>"link_c")); ?>
			</div>
			<div id="total_items_frame">
				<?php 
					if ($this->Session->check('basket')) {
						$basket = $this->Session->read('basket');
						echo "( ".sizeof($basket)." items )</br>";
					}
				?>
			</div>
			<div id="total_cost_frame">
				<?php 
					if ($this->Session->check('total') && $this->Session->read('total') > 0) {
						$total = $this->Session->read('total');
						
						if(strrpos((string)$total,".") == false) {
							$total = (string)$total.".";
						}
			
						while (strlen($total) - strrpos((string)$total,".") <= 2) {
							$total = (string)$total."0"; 
						}
						
						echo "</br><span class=\"total_a\">Total : &#163;".$total."</span>";
					}
				?>
			</div>
		</div>
		<?php /*<div id="navigation_bar">
			<div id="navigation_outer_container">
				<div id="navigation_inner_container">
					<div id="navigation_list">
						<span class="nav_button_text nav_button_styles" id="blog_link">Blog</span>
						<span class="nav_button_text nav_button_styles" id="find_us_link">Find us</span>
						<span class="nav_button_text nav_button_styles" id="contact_link">Contact</span>
						<span class="nav_button_text nav_button_styles" id="meet_the_team_link">Meet the team</span>
						<span class="nav_button_text nav_button_styles" id="the_shop_link">The shop</span>
					</div>
				</div>
			</div>
		</div> */ ?>
		<div id="inner_container">
		<?php
			if($page_type == "shop") {
				echo "<div id=\"secondary_column\">".$this->element('categories')."</div>";
				echo "<div id=\"primary_column\">".$content_for_layout."</div>";
			} else if ($page_type == "account"){
				echo $content_for_layout;
			}
		?>
		</div>
		<br class="clear" />
		</br></br>
	</div>
</body>
</html>