<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="/jquery/timeout/jquery.ba-dotimeout.min.js"></script>
<script src="/jquery/jquery-ui-1.10.2/ui/jquery-ui.js"></script>
<script type="text/javascript">

$(document).ready(function() {

	$('#submit_address_link').click(function (){
		$('#DeliveryAddress').submit();
	});

	$('#submit_address_link').hover(function() {
		$(this).addClass('hover');
	},
	function() {
		$(this).removeClass('hover');
	});

});
</script>
<style type="text/css">
	.hover {
		text-decoration:underline;
		cursor:pointer;
	}
</style>

<?php echo $this->Form->create('DeliveryAddress', array('id' => 'DeliveryAddress', 'url' => array("controller"=>"orders", "action"=>"step_2"))); 

?>
	<h2>Step 1: Add Delivery address Information</h2>
	<?php 
		echo $this->Form->input('Delivery_address.first_name', array('label' => 'First Name:', 'default'=>'Edward'));
		echo $this->Form->input('Delivery_address.last_name', array('label' => 'Last Name:', 'default'=>'Blundell'));
		echo $this->Form->input('Delivery_address.address_1', array('label' => 'Address 1:', 'default'=>'48 Church Road'));
		echo $this->Form->input('Delivery_address.address_2', array('label' => 'Address 2:', 'default'=>'Braunston'));
		echo $this->Form->input('Delivery_address.city', array('label' => 'City', 'default'=>'Daventry'));
		echo $this->Form->input('Delivery_address.county', array('label' => 'County', 'default'=>'Northamptonshire'));
		echo $this->Form->input('Delivery_address.country', array('label' => 'Country', 'default'=>'United Kingdom'));
		echo $this->Form->input('Delivery_address.post_code', array('label' => 'Post Code', 'default'=>'NN11 7HQ'));
		echo $this->Form->input('Delivery_address.contact_number', array('label' => 'Contact number', 'default'=>'07890493453'));
	?>
	<div class="submit">
		<?php //echo $this->Form->submit('Continue', array('div' => false)); ?>
		<?php //echo $this->Form->submit('Cancel', array('name' => 'Cancel', 'div' => false)); ?>
		<span id="submit_address_link">Continue</span>
		<?php echo $this->html->link("Cancel", array("controller"=>"basket", "action"=>"index")); ?>
	</div>
<?php echo $this->Form->end(); ?>