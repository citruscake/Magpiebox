<html><head>
<link href='http://fonts.googleapis.com/css?family=Fanwood+Text' rel='stylesheet' type='text/css'>
<style type='text/css'  media='all'>
   @import url('/css/site_styles.css');
   @import url('/css/shop_styles.css');
</style>
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
	</div></br>
</body>
</html>