<?php

	$product = $this->requestAction('products/getDailyProduct');
	$image_url = "/img/product_images/".$product['Product']['product_id']."/".$product['Product']['product_id']."_".$product['Product']['primary_image'].".jpg";
	
	echo "<a href=\"/products/view/".$product['Product']['product_id']."\">";
	echo "<div id=\"mb_daily_item_container\" style=\"background-image:url('".$image_url."');\">";
	echo "<div class=\"row\">";
	echo $product['Product']['name'];
	echo "</div>";
	echo "<div class=\"row\">";
	echo "Only ".$product['Product']['price'];
	echo "</div>";
	echo "</div></a>";
	
?>