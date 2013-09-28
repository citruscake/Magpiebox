<style type="text/css">

	.gallery_outer_container {
		width:800px;
		margin-left:auto;
		margin-right:auto;
		margin-top:10px;
		position:relative;
	}
	
	.gallery_inner_container {
		width:800px;
		//height:250px;
	}
	
	.gallery_bar_container {
		width:800px;
		height:250px;
	}
	
	.address_outer_frame {
	
		width:380px;
		background-color:#777777;
		position:absolute;
		//height:250px;
		
	}
	
	.address_add_bar {
	
		width:800px;
		height:40px;
	
	}
	
	.address_add_frame {
		left: 300px;
		background-color: #777777;
		margin-top: 10px;
		height: 25px;
		width: 250px;
	}

</style>
<?php
/*
echo $this->Html->link('Add an address', array('controller'=>'addresses', 'action'=>'add'));

echo "<br /><br />"; 

foreach($addresses as $address) {

	echo $address['Address']['full_name']."<br />";
	echo $address['Address']['address_1']."<br />";
	echo $address['Address']['address_2']."<br />";
	echo $address['Address']['city']."<br />";
	echo $address['Address']['county']."<br />";
	echo $address['Address']['country']."<br />";
	echo $address['Address']['post_code']."<br />";
	echo $address['Address']['contact_number']."<br />";

	echo "<br />";
	echo $this->Html->link('Edit', array('controller'=>'addresses', 'action'=>'edit', $address['Address']['address_id']))." ";
	echo $this->Html->link('Delete', array('controller'=>'addresses', 'action'=>'delete', $address['Address']['address_id']));
	echo "<br /><br />";
}
*/

	echo "<div class=\"gallery_outer_container\"><div class=\"gallery_inner_container\">";

	foreach($addresses as $i=>$address) {
		if(($i % 2) == 0) {
			echo "<div class=\"gallery_bar_container\">";
		}
		
		echo "<div class=\"address_outer_frame\" style=\"left:".(390*($i % 2))."\">";
		echo $this->element('address_show', array("address"=>$address, "static" => false));
		echo "</div>";
		
		if((($i % 2) == 1) || $i == max(array_keys($addresses))) {
			echo "</div>";
		}

	}
	
		
	echo "<div class=\"address_add_bar\"><div class=\"address_add_frame\">";
	echo $this->Html->link('Add an address', array('controller'=>'addresses', 'action'=>'add'));
	echo "</div></div>";
	
	echo "</div></div>";

?> 