<div id="mb_address_edit_container">
	<div class="row">
		<h2>
			<?php
			
				if($mode == "add") {
					echo "Add";
				}
				else if ($mode == "edit") {
					echo "Edit";
				}
				
				echo " an address";
			
			?>
		</h2>
	</div>
	<div class="row" style="margin-top:10px;">
<?php 
	if($mode == "add") {
		if($this->Session->check("context") && ($this->Session->read("context") == "order")) {
			if(!$this->Session->check("Auth.User")) { //a logged in user is buying
				echo $this->Form->create("Address", array("id" => "Address", "url" => array("controller" => "orders", "action" => "step_2"), 'class'=>'form-horizontal')); 
			}
			else {
				echo $this->Form->create("Address", array("id" => "Address", "url" => array("controller" => "addresses", "action" => "add"), 'class'=>'form-horizontal')); 
			}
		}
		else {
			echo $this->Form->create("Address", array("id" => "Address", "url" => array("controller" => "addresses", "action" => "add"), 'class'=>'form-horizontal')); 
		}
	}
	else if($mode == "edit") {
		echo $this->Form->create("Address", array("id" => "Address", "url" => array("controller" => "addresses", "action" => "edit"), 'class'=>'form-horizontal')); 
	}
	
	$fieldValues = array();
	if ($mode == "edit") {
		foreach($address['Address'] as $field=>$value) {
			$fieldValues[$field] = $value;
		}
	}
	else if ($mode == "add") {
		foreach(array('full_name', 'address_1', 'address_2', 'city', 'county', 'state', 'country', 'post_code', 'contact_number') as $field) {
			$fieldValues[$field] = ""; //whatever really
		}
	}
	?>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="full_name">Full name*</label>
			<div class="controls">
				<input type="text" id="full_name" name="full_name" placeholder="Full name" value="<?php echo $fieldValues['full_name']; ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="address_1">Address 1*</label>
			<div class="controls">
				<input type="text" id="address_1" name="address_1" placeholder="Address 1" value="<?php echo $fieldValues['address_1']; ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="address_2">Address 2*</label>
			<div class="controls">
				<input type="text" id="address_2" name="address_2" placeholder="Address 2" value="<?php echo $fieldValues['address_2']; ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="city">City*</label>
			<div class="controls">
				<input type="text" id="city" name="city" placeholder="City" value="<?php echo $fieldValues['city']; ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="county">County*</label>
			<div class="controls">
				<input type="text" id="county" name="county" placeholder="County" value="<?php echo $fieldValues['county']; ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="state">State</label>
			<div class="controls">
				<input type="text" id="state" name="state" placeholder="State" value="<?php echo $fieldValues['state']; ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="country">Country*</label>
			<div class="controls">
				<?php /*<input type="text" id="country" name="country" placeholder="Country" value="<?php echo $fieldValues['country']; ?>">*/ ?>
				<?php 
					if($mode == "add") {
						echo $this->element('world_countries_list');
					}
					else if($mode == "edit") {
						echo $this->element('world_countries_list', array('selected_value'=>$fieldValues['country']));
					}
				?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="post_code">Post Code/ Zip Code*</label>
			<div class="controls">
				<input type="text" id="post_code" name="post_code" placeholder="Post/ Zip Code" value="<?php echo $fieldValues['post_code']; ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="control-group">
			<label class="control-label" for="contact_number">Contact number</label>
			<div class="controls">
				<input type="text" id="contact_number" name="contact_number" placeholder="Contact number" value="<?php echo $fieldValues['contact_number']; ?>">
			</div>
		</div>
	</div>
	<div class="row" style="margin-top:-20px;">
		<h5 style="margin-left:330px";>* required</h5>
	</div>
	<div class="row" style="margin-top:10px;">
<?php	
	if($mode == 'edit') {
		echo $this->Form->input('address_id', array('type'=>'hidden', 'value'=>base64_encode($address['Address']['address_id'])));
	}
	
	echo "<span class=\"btn\" id=\"submit_address_link\" style=\"margin-left:330px;\">";
	if ($mode == "add") {
		echo "Submit";
	}
	else if ($mode == "edit") {
		echo "Save";
	}
	echo "</span>";
	
	echo $this->Form->end();
	
?>
	</div>
	</div>
</div>