<div class="row-fluid">
	<div class="span12">
	<?php echo $this->Form->create('Register', array('id' => 'Register', 'url' => array("controller"=>"users", "action"=>"register"), 'class'=>'form-horizontal')); ?>
	<div class="row-fluid">
		<div class="span7" style="width:400px;">
			<div class="control-group">
				<label class="control-label" for="register_username">Email</label>
					<div class="controls">
						<input type="text" id="register_username" name="data[Register][register_username]" placeholder="Email">
					</div>
			</div>
		</div>
		<div class="span5" style="width:150px; margin-left:0px;">
			<div class="span3" style="width:25px;">
				<div id="mb_valid_email_symbol" style="margin-left:8px;margin-top:3px;width:25px;height:25px;">
					<?php /* <i class="icon-ok"></i> */ ?>
				</div>
			</div>
			<div class="span9" id="mb_valid_email_text" style="margin-left:3px;width:120px;padding-top:4px;">
			
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span7" style="width:400px;">
			<div class="control-group">
				<label class="control-label" for="register_original_password">Password</label>
					<div class="controls">
						<input type="password" id="register_original_password" name="data[Register][register_original_password]" placeholder="Password">
					</div>
			</div>
		</div>
		<div class="span5" style="width:150px; margin-left:0px;">
			<div id="mb_password_strength_result" style="margin-left:8px; margin-top:4px;"></div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span7" style="width:400px;">
			<div class="control-group">
				<label class="control-label" for="register_confirm_password">Confirm password</label>
					<div class="controls">
						<input type="password" id="register_confirm_password" name="data[Register][register_confirm_password]" placeholder="Confirm Password">
					</div>
			</div>
		</div>
		<div class="span5" style="width:150px; margin-left:0px;">
			<div class="span3" style="width:25px;">
				<div id="mb_password_confirm_symbol" style="margin-left:8px;margin-top:3px;width:25px;height:25px;">
					<?php /* <i class="icon-ok"></i> */ ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="control-group">
			<label class="control-label" for="register_full_name">Full name</label>
				<div class="controls">
					<input type="text" id="register_full_name" name="data[Register][register_full_name]" placeholder="Full name">
				</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="btn" id="register_confirm_link" style="left:320px; position:relative;">Register</div>
	</div>
	<?php 
	echo $this->Form->input('register_original_password_hash', array('id'=>'register_original_password_hash','type' => 'hidden'));
	echo $this->Form->input('register_confirm_password_hash', array('id'=>'register_confirm_password_hash', 'type' => 'hidden'));
	echo $this->Form->input('register_role', array('id'=>'register_role', 'type' => 'hidden', 'value'=>'customer'));
	echo $this->Form->end(); ?>
	</div>
</div>