<div id="mb_order_login_container">
	<div class="row">
		<h2>How would you like to checkout?</h2>
	</div>
	<div class="row">
		<h4 style="margin-left:160px;">Using an account:</h4>
	</div>
	<div class="row" style="margin-top:-20px;">
		<?php echo $this->element('login_form', array("context"=>"order")); ?>
	</div>
	<div class="row" style="margin-top:20px;">
		<h4 style="margin-left:160px;">As a visitor:</h4>
	</div>
	<div class="row" style="margin-top:0px;">
		<div class="span5" style="margin-left:300px;margin-top:10px;">
			<?php 
				echo $this->html->link("Checkout as a visitor", array("controller"=>"orders", "action"=>"step_1"));
			?>
		</div>
	</div>
</div>