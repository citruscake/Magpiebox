<?php

	$product = $this->requestAction('products/getDailyProduct');
	
	echo "<a href=\"/products/view/".$product['Product']['product_id']."\">";
	echo "<div id=\"mb_daily_item_container\" style=\"background-image:url('".$product['Product']['image_url']."');\">";
	echo "<div class=\"row\">";
	echo $product['Product']['name'];
	echo "</div>";
	echo "<div class=\"row\">";
	echo "Only ".$product['Product']['price'];
	echo "</div>";
	echo "</div></a>";
	
?>