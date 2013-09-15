<?php

	foreach($orders as $order) {
	
		echo $this->element("order", array("order"=>$order, "context"=>"list"));
	
	}

?>