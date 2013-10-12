<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="/jquery/timeout/jquery.ba-dotimeout.min.js"></script>
<script src="/jquery/jquery-ui-1.10.2/ui/jquery-ui.js"></script>
<script src="/js/jshash-2.2/md5-min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	$('#login_frame').click(function (){
		$('#password_hash').val(hex_md5($('#password_plaintext').val()));
		
		var substituteString = "";
		var password_plaintext = $('#password_plaintext').val();
		
		for(i=0;i<password_plaintext.length;i++) {
			substituteString += "*";
		}
		
		$('#password_plaintext').val(substituteString);
		
		$('#DummyLogin').submit();
	});

	$('#login_frame').hover(function() {
		$(this).addClass('login_frame_hover_styles');
		$(this).removeClass('login_frame_styles');
	},
	function() {
		$(this).removeClass('login_frame_hover_styles');
		$(this).addClass('login_frame_styles');
	});

});
</script>
<style type="text/css">
	.login_frame_hover_styles {
		//text-decoration:underline;
		cursor:pointer;
		background-color: rgb(10, 10, 10);
		color:#ffffff;
		left:635px;
		top:6px;
		position:absolute;
		padding:4px 15px 4px 15px;
		font-family: Fanwood Text;
		font-size:20px;
		border-radius:3px;
	}
	
	.form_text_input_a {
		font-family: Fanwood Text;
		font-size:20px;
		color:rgba(255, 255, 255, 0.9);
		padding:4px 3px 2px 5px;
		//border-width:1px;
		//border-style:solid;
		//border-color:#dddddd;
		border: none;
		background-color:rgba(80, 80, 80, 0.2);
	}
	
	.form_text_input_a:focus {
		outline:0;
	//	border-width:1px;
	//	border-style:solid;
	//	border-color:#000000;
		color:#ffffff;
		background-color:rgba(80, 80, 80, 0.3);
	}
	
	.form_text_label {
		font-family:Fanwood Text;
		font-size:20px;
		color:#ffffff;
	}
	
	#login_form_frame {
		width:500px;
		height:30px;
	}
	
	#field_1 {
		position:absolute;
		left:70px;
		top:5px;
	}
	
	#field_2 {
		position:absolute;
		left:395px;
		top:5px;
	}
	
	#label_1 {
		position:absolute;
		left:22px;
		top:10px;
	}
	
	#label_2 {
		left:312px;
		top:10px;
		position:absolute;
	}
	
	#login_frame {
		//width:150px;
		//background-color:#888888;
		//left:1005px;
		//position:absolute;
		//height:30px;
		//top:10px;
	}
	
	.login_frame_styles {
		left:635px;
		top:6px;
		position:absolute;
		background-color: rgb(14, 14, 14);
		padding:4px 15px 4px 15px;
		font-family: Fanwood Text;
		font-size:20px;
		color:#ffffff;
		border-radius:3px;
	}
	
	.login_link_text {
		font-family:Fanwood Text;
		font-size:20px;
		color:#888888;
	}
	
</style>
<?php   
		echo "<div id=\"login_form_frame\">";
		echo $this->Form->create('Login', array('id' => 'DummyLogin', 'url' => array("controller"=>"users", "action"=>"denied")));
		echo "<div id=\"label_1\" class=\"form_text_label\">User:</div><div id=\"field_1\">".$this->Form->input('username', array('label'=>false, 'class'=>'form_text_input_a'))."</div>";
		echo "<div id=\"label_2\" class=\"form_text_label\">Password:</div><div id=\"field_2\">".$this->Form->input('password_plaintext',array('id'=>'password_plaintext', 'type'=>'password', 'label'=>false, 'class'=>'form_text_input_a'))."</div>";
		echo $this->Form->input('password_hash', array('id'=>'password_hash','type' => 'hidden'));
		echo "<div id=\"login_frame\" class=\"login_frame_styles\"><span id=\"login_link\">Login</span></div>";
		echo "</div>";
		echo $this->Form->end(); 

?>