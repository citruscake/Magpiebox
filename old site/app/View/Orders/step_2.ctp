<div id="mb_billing_container">
	<div class="row">
		<h2>Billing</h2>
	</div>
	<div class="row" style="margin-top:30px;">
	<?php echo $this->Form->create('Billing', array('id' => 'Billing', 'url' => array("controller"=>"orders", "action"=>"step_3"), 'class'=>'form-horizontal')); ?>
	<?php //echo $this->Form->radio('method', array('Paypal'=>'Paypal'), array("legend"=>false)); 
	?>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="method">Billing method</label>
			<div class="controls">
				<div class="span1" style="width:20px;">
					<input type="radio" id="paypal" name="Paypal" checked>
				</div>
				<div class="span1">
					<img src="/img/paypal.png" style="margin-top:5px;">
				</div>
			</div>
		</div>
	</div>
	<div class="row" style="margin-top:30px;">
		<div class="span4" style="margin-left:120px;">
			<div class="span1">
				<div class="btn" id="submit_billing_link">Continue</div>
			</div>
			<div class="span1" style="margin-left:10px;">
				<a href="/baskets/index"><div class="btn" id="submit_billing_link">Cancel</div></a>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
	</div>
</div>