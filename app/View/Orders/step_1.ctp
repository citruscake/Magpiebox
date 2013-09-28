<?php
	
	if($this->Session->check("Auth.User")) {
	
		echo $this->element("address_gallery", array("addresses"=>$addresses));
	
	}
	else {
	
		echo $this->element("address_form", array("mode"=>"add"));
	
	}

?>
