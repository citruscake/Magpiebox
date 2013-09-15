<div id="mb_confirm_order_container" class="span10">
	<div class="row">
		<h2>Confirm order</h2>
	</div>
	<div class="row">
		<?php echo $this->element('Basket', array("edit"=>false)); ?>
	</div>
	<div class="row" style="margin-top:50px;">
		<?php echo $this->element("address_show", array("address" => $address, "static"=>true)); ?>
	</div>
	<div class="row" style="margin-top:10px;">
		<div class="span5" style="margin-left:20px;">
			<?php 
				echo "Payment Method: ";
				foreach($billing as $method=>$boolean) {
					if($boolean == "on") {
						if($method == "Paypal") {
							echo "<img src=\"/img/paypal.png\" style=\"margin-left:10px;\">";
						}
					}
				}
			?>
		</div>
	</div>
	<div class="row" style="margin-top:60px;">
	<div class="span7"></div>
		<div class="span2" style="width:130px;margin-left:50px;">
			<div class="btn" id="submit_order_link">Confirm order</div>
		</div>
		<div class="span1" style="width:70px;margin-left:0px;">
			<a href="/baskets/index"><div class="btn">Cancel</div></a>
		</div>
	</div>
</div>