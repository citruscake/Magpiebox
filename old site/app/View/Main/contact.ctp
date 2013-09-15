<div id="mb_contact_container"> 
	<div class="span9">
	<div class="row" style="margin-top:10px;">
		<div class="span11">
			<?php //<form class="form-horizontal">
				echo $this->Form->create("Contact_us", array("id" => "Contact_us", "url" => array("controller" => "main", "action" => "contact"), 'class'=>'form-horizontal')); 
			?>
				<div class="row">
				<div class="span5">
				<div class="control-group">
					<label class="control-label" for="email_address">Email address:</label>
					<div class="controls">
						<input type="text" name="email_address" id="contact_email_address" placeholder="Email address">
					</div>
				</div>
				</div>
				<div class="span1">
					<div id="mb_contact_email_symbol" style="margin-left:-10px;">
						<?php /* <i class="icon-ok"></i> */ ?>
					</div>
				</div>
				</div>
				<div class="row">
					<div class="control-group">
						<label class="control-label" for="full_name">Name:</label>
						<div class="controls">
							<input type="text" name="full_name" id="full_name" placeholder="Name">
						</div>
					</div>
				</div>
				<div class="row">
				<div class="control-group">
					<label class="control-label" for="message_subject">Subject:</label>
					<div class="controls">
						<input type="text" name="message_subject" id="message_subject" placeholder="Subject">
					</div>
				</div>
				</div>
				<div class="row">
				<div class="control-group">
					<label class="control-label" for="message_body">Subject:</label>
					<div class="controls">
						<textarea rows="5" name="message_body" id="message_body" placeholder="Message"></textarea>
					</div>
				</div>
				</div>
				<div class="row">
					<div class="btn" id="submit_contact_us_link" style="left:340px; position:relative;">Send</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row" style="height:50px;"></div>
</div>