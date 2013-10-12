<style type="text/css">

	#signup_form_container {
		//background-color:#eeeeee;
		height:100px;
		width:420px;
		position:relative;
		left:-5px;
	}
	
	#signup_form_container form {
		display:inline;
		padding:0;
		margin:0;
	}
	
	#signup_form_container form input[type=text] {

		width:100%;
		//height:60px;
		position:relative;
		//margin: 5px 5px 5px 5px;
		font-family:arial;
		font-size:22px;
		color:#888888;
		padding:6px;
		display:inline;
		//margin-top:10px;
		border:none;
	}
	
	#signup_form_container form input[type=text]:focus {
		outline:none;
	}
	
	#signup_form_container form input[type=submit] {
		background-color:#dddddd;
		cursor:pointer;
		height:48px;
		width:80px;
		margin-top:6px;
		margin-left:2px;
		border-radius: 7px 7px 7px 7px;
		font-family:arial;
		font-weight:600;
		font-size:18px;
		color:rgb(248, 248, 201);
		-webkit-box-shadow: 1px 2px 2px 2px rgba(1, 1, 1, 0.1);
		box-shadow: 1px 2px 2px 2px rgba(1, 1, 1, 0.1);
		//margin-left:-10px;
		border:none;
		padding-left:20px;
background: rgb(69,72,77); /* Old browsers */
background: -moz-linear-gradient(top, rgba(69,72,77,1) 0%, rgba(0,0,0,1) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(69,72,77,1)), color-stop(100%,rgba(0,0,0,1))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(69,72,77,1) 0%,rgba(0,0,0,1) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#45484d', endColorstr='#000000',GradientType=0 ); /* IE6-9 */
	}
	
	#signup_form_inner_container {
		width:430px;
		height:90px;
		position:relative;
		//top:15px;
		left:10px;
	}
	
	#address_frame {
		float:left;
		display:inline;
		//width:300px;
		width:280px;
		background-color:#FFFFFF;
		border-radius:7px 7px 7px 7px;
		padding:5px 5px 3px 5px;
		-webkit-box-shadow: 1px 2px 2px 2px rgba(1, 1, 1, 0.3);
		box-shadow: 1px 2px 2px 2px rgba(1, 1, 1, 0.3);
	}
	
	#submit_frame {
		float:left;
		display:inline;
		//width:100px;
		width:50px;
		padding:5px;
		//margin-left:5px;
		height:70px;
		margin-top: -11px;
		padding:5px;
	}
	
	#add_icon {
	
		margin-top: -34px;
		width: 20px;
		margin-left: 8px;
	}


</style>
<div id="signup_form_container">
	<div id="signup_form_inner_container">
	<?php

		echo $this->Form->create('email', array('type'=>'post','url'=>array('controller'=>'emails', 'action'=>'signup'), 'inputDefaults'=>array('label'=>false)));	
		echo "<div id=\"address_frame\">".$this->Form->input('address', array('type'=>'text', 'name'=>'address'))."</div>";
		echo "<div id=\"submit_frame\">".$this->Form->end('Add')."<img id=\"add_icon\" src=\"/img/add.png\"\></div>";

	?>
	</div>
</div>