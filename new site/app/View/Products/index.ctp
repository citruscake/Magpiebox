<?php
	echo "<div class=\"row\">";
	echo $this->element('breadcrumb');
	echo "</div><div class=\"row\">";
	echo $this->element('products_list', array('products' => $products));
	echo "</div>";
?>