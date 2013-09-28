<div id="mb_login_container">
	<?php echo $this->Form->create('Login', array('id' => 'Login', 'url' => array("controller"=>"users", "action"=>"login"), 'class'=>'form-horizontal')); ?>
	<div class="row">
		<div class="row">
		<div class="control-group">
			<label class="control-label" for="login_username">Email</label>
				<div class="controls">
					<input type="text" id="login_username" name="data[Login][login_username]" placeholder="Email">
				</div>
		</div>
		</div>
		<div class="row">
			<div class="control-group">
				<label class="control-label" for="login_password">Password</label>
				<div class="controls">
					<input type="password" id="login_password_plaintext" name="data[Login][login_password_plaintext]" placeholder="Password">
				</div>
			</div>
		</div>
		<?php echo $this->Form->input('login_password_hash', array('id'=>'login_password_hash','type' => 'hidden')); ?>
		<div class="row">
			<div class="btn" id="login_confirm_link" style="left:340px; position:relative;">Login</div>
		</div>
		<div class="row" style="margin-top:15px;">
			<div class="span2"></div>
			<div class="span4" style="margin-left:30px;">
				<?php echo "Don't have an account? ".$this->Html->link('Register', array('controller'=>'users', 'action'=>'register')); ?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>