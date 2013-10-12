<style type="text/css">

	#logout_frame {
		width:150px;
		height:50px;
		background-color:#888888;
		position:absolute;
		left:650px;
		top: 10px;
	}

</style>
<div id="logout_frame">
	<?php echo $this->html->link("Logout", array("controller"=>"users", "action"=>"logout")); ?>
</div>
<?php

echo $this->Html->link('View orders', array('controller'=>'orders', 'action'=>'index'));

echo "<br /><br />"; 

echo $this->Html->link('Manage Address book', array('controller'=>'addresses', 'action'=>'index'));

echo "<br /><br />";

echo $this->Html->link('Add an address', array('controller'=>'addresses', 'action'=>'add'));

echo "<br /><br />"; 

echo $this->Html->link('Return an item', array('controller'=>'order', 'action'=>'view'));

echo "<br /><br />"; 

echo $this->Html->link('Change name, email or password', array('controller'=>'user', 'action'=>'edit'));

echo "<br /><br />"; 

echo $this->Html->link('I\'ve forgotten my password', array('controller'=>'user', 'action'=>'forgot_password'));

echo "<br /><br />"; 

?>