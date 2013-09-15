<?php 
	echo "</br></br>";
	if(isset($success) && $success==true) {
		echo "Your address has now been verified</br></br>";
		echo $this->html->link("To the shop", array("controller"=>"products", "action"=>"index"));
	}
	else if (isset($success) && $success==false) {
		echo $message;
	}
	else {
		echo "Thank you for registering with us!</br></br>You have been sent a confirmation email.";

		if ($this->Session->check("context") && $this->Session->read("context") == "order") {
			echo "Please click the link within to verify your email address and continue with the checkout process.";
		}
		else {
			echo "Please click the link to verify the address";
		}
	}
?>
</br>
</br>
<a href="/users/confirm?e=<?php echo base64_encode("efblundell@hotmail.co.uk"); ?>&k=<?php echo base64_encode(substr(md5("efblundell@hotmail.co.uk"."abcdef"), 20)); ?>&p=1">Test Link</a>
</br>
<?php 
	if ($this->Session->check("context") && $this->Session->read("context") == "order") {
		echo "Alternatively, you ";
		echo $this->html->link("may continue to checkout as a visitor instead.", array("controller"=>"orders", "action"=>"step_1")); 
	}
?>