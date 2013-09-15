$(document).ready(function() {

	//Register form
	$('#register_confirm_link').click(function() {
		substitute_passwords("register");
		//$('#Register').submit(function() {
		//	alert("working");
		//});
		$('#Register').submit();
	});
	
	/****** SEARCH ******/
	
	$('#search_submit_link').click(function() {
		$('#Search').submit();
	});
	
	//$('#tipue_search_input').tipuesearch();

	$('#search_text_box').smartAutoComplete({
		source: availableTags,
		minCharLimit : 1
	});
	
	/*$('#search_text_box').keyup(function(event) {
		if (event.keyCode==13) {
			$('#search_submit_link').click();
		}
	});*/
	
	/*$('#search_text_box').keydown(function(event) {
		if (event.keyCode==13) {
			$('#search_submit_link').click();
		}
	});*/

	/********************/
	/*** SEARCH HISTORY */
	
	$('#search_select').change(function() {
		//alert("hey");
		$('#Search_history').submit();
		//alert("nii");
	});
	
	/********************/

	/*$('#sign_up_confirm_link, #register_confirm_link').hover(function() {
		$(this).addClass('button_hover_styles');
		$(this).removeClass('button_styles');
	},
	function() {
		$(this).removeClass('button_hover_styles');
		$(this).addClass('button_styles');
	}); */
	
	$('#submit_contact_us_link').click(function() {
		$('#Contact_us').submit();
	});
	
	//Address form
	$('#submit_address_link').click(function() {
		$('#Address').submit();
	});

	/*$('#submit_address_link').hover(function() {
		$(this).addClass('link_hover');
	},
	function() {
		$(this).removeClass('link_hover');
	});*/
	
	//Login form (not splash)
	$('#login_confirm_link').click(function(){
		
		substitute_passwords("login");
		$('#Login').submit();
	});

	/*$('#login_confirm_link').hover(function() {
		$(this).addClass('button_hover_styles');
		$(this).removeClass('button_styles');
	},
	function() {
		$(this).removeClass('button_hover_styles');
		$(this).addClass('button_styles');
	}); */
	
	$('#original_password, #confirm_password, #register_full_name, #register_username').keyup(function(event) {
		if (event.keyCode==13) {
			$('#sign_up_confirm_link').click();
		}
	});
	
	$('#login_username, #password_plaintext').keyup(function(event) {
		if (event.keyCode==13) {
			$('#login_confirm_link').click();
		}
	});
	
	$('#contact_email_address, #register_username').keyup(function(event){
		//alert("moo");
		//check_email();
		$('#mb_valid_email_symbol').css('background-image', 'url(/img/symbols/loading_icon.gif)');
		$('#mb_valid_email_symbol').html("");
		$('#mb_valid_email_text').html("");
		$(this).doTimeout('contact_email', 600, function(){
			//console.log($(event.target).val());
			var available_condition = false;
			var valid_condition = IsEmail($(event.target).val());
		
			if(valid_condition==true){
				//alert($(event.target).val());
				available_condition = IsAvailable($(event.target).val());
			}
			else {
				$('#mb_valid_email_symbol').css('background-image', 'none');
				$('#mb_valid_email_symbol').html("<i class=\"icon-remove\"></i>");
			}
		});
	});
	
	$('#contact_email_address, #register_username').blur(function(event) {
	
		var available_condition = false;
		var valid_condition = IsEmail($(event.target).val());
		
		if(valid_condition==true){
				//alert($(event.target).val());
				available_condition = IsAvailable($(event.target).val());
			}
		else {
			$('#mb_valid_email_symbol').css('background-image', 'none');
			$('#mb_valid_email_symbol').html("<i class=\"icon-remove\"></i>");
		}
	});
	
	function IsAvailable(email_address) {
		var JSON_data = "{ \"command\" : \"check\", ";
		JSON_data += "\"email_address\" : \""+email_address+"\"";
		JSON_data += "}";

		var url = "/users/processAJAXQuery";
		var response = false;
		
		$.getJSON(url,{jsonData:JSON_data},function(data) {

			available_condition = data.response.available;
			if(available_condition == true) {
					$('#mb_valid_email_symbol').html("<i class=\"icon-ok\"></i>");
					$('#mb_valid_email_text').html("Available");
					$('#mb_valid_email_symbol').css('background-image', 'none');
				}
				else {
					$('#mb_valid_email_symbol').html("<i class=\"icon-remove\"></i>");
					$('#mb_valid_email_text').html("Unavailable");
					$('#mb_valid_email_symbol').css('background-image', 'none');
			}
		});	
	}
	
	/**** REGISTER *****/
	
	$('#register_original_password').keyup(function(event) {
		$('#mb_password_strength_result').html(checkStrength($(event.target).val()));
		if($('#register_confirm_password').val() != "") {
			$('#register_confirm_password').keyup();
		}
	});
	
	$('#register_confirm_password').keyup(function(event){

		$('#mb_password_confirm_symbol').css('background-image', 'url(/img/symbols/loading_icon.gif)');
		$('#mb_password_confirm_symbol').html("");
		$(this).doTimeout('confirm_password', 300, function(){
			if($('#register_confirm_password').val() == $('#register_original_password').val() && $('#register_original_password').val() != "") {
				$('#mb_password_confirm_symbol').css('background-image', 'none');
				$('#mb_password_confirm_symbol').html("<i class=\"icon-ok\"></i>");
			}
			else {
				$('#mb_password_confirm_symbol').css('background-image', 'none');
				$('#mb_password_confirm_symbol').html("<i class=\"icon-remove\"></i>");
			}
			/*if($('#contact_email_address').is(':focus')) {
				return true;
			}
			else {
				return false;
			}*/
		});
	});
	
	$('#register_confirm_password').blur(function(event) {
		//var isEmail = check_email($(event.target).val());
			if($('#register_confirm_password').val() == $('#register_original_password').val() && $('#register_original_password').val() != "") {
				$('#mb_password_confirm_symbol').css('background-image', 'none');
				$('#mb_password_confirm_symbol').html("<i class=\"icon-ok\"></i>");
			}
			else {
				$('#mb_password_confirm_symbol').css('background-image', 'none');
				$('#mb_password_confirm_symbol').html("<i class=\"icon-remove\"></i>");
			}
	});
	
	/*******************/
});

function substitute_passwords(type) {

	if(type == "register") {

		$('#register_original_password_hash').val(hex_md5($('#register_original_password').val()));
		$('#register_confirm_password_hash').val(hex_md5($('#register_confirm_password').val()));
		
		var substituteString = "";
		var password = $('#register_original_password').val();
		
		for(i=0;i<password.length;i++) {
			substituteString += "*";
		}
		
		$('#register_confirm_password').val(substituteString);
		$('#register_original_password').val(substituteString);
	}
	else if (type == "login") {
	
		$('#login_password_hash').val(hex_md5($('#login_password_plaintext').val()));
		
		var substituteString = "";
		var password_plaintext = $('#login_password_plaintext').val();
		
		for(i=0;i<password_plaintext.length;i++) {
			substituteString += "*";
		}
		
		$('#login_password_plaintext').val(substituteString);
		
	}
}