<div class="row">
<table class="table table-bordered" style="margin-left:20px;">
<?php
	
		echo "<tr><td>Full name</td><td>".$address['full_name']."</td></tr>";
		echo "<tr><td>Address 1</td><td>".$address['address_1']."</td></tr>";
		echo "<tr><td>Address 2</td><td>".$address['address_2']."</td></tr>";
		echo "<tr><td>City</td><td>".$address['city']."</td></tr>";
		echo "<tr><td>County</td><td>".$address['county']."</td></tr>";
		if($address['state'] != "") {
			echo "<tr><td>State</td><td>".$address['state']."</td></tr>";
		}
		echo "<tr><td>Country</td><td>".$address['country']."</td></tr>";
		echo "<tr><td>Post/ Zip code</td><td>".$address['post_code']."</td></tr>";
		if($address['contact_number'] != "") {
			echo "<tr><td>Contact number</td><td>".$address['contact_number']."</td></tr>";
		}
?>
		</table>
</div>
<div class="row">
<?php		
		if($static==false) {

			echo "<div class=\"span1\">";
			echo "<a href=\"addresses/edit/".base64_encode($address['address_id'])."\"><div class=\"btn\">Edit</div></a>";
			echo "</div>";
			echo "<div class=\"span1\">";
			echo "<a href=\"addresses/delete/".base64_encode($address['address_id'])."\"><div class=\"btn\">Delete</div></a>";
			echo "</div>";
			
			if ($this->Session->check("context") && $this->Session->read("context") == "order" && $this->Session->check("Auth.User")) {
				echo "<div class=\"row\">";
				echo $this->Html->link('Dispatch to this address', array('controller'=>'orders', 'action'=>'step_2', base64_encode($address['Address']['address_id'])))." ";
				echo "</div>";
			}
		}
?>
</div>