<?php

$productData = $this->requestAction(array("controller"=>"baskets", "action"=>"getProductData"));
$products = $productData['products'];
$total = $productData['total'];

if(isset($basket)) {

	echo "<table id=\"basket_table\">";

	echo "<tr><td>Product</td><td>Price</td><td>Quantity</td>";
	if ($edit == true) {
		echo "<td>Edit</td>";
	}
	echo "</tr>";

	foreach($basket as $i=>$itemData) {

		echo "<tr id=\"".$itemData['product_id']."\">";
		echo "<td>".$this->html->link($products[$i]['Product']['name'], array("controller"=>"products", "action"=>"view", $itemData['product_id']))."</td>";
		echo "<td>".$products[$i]['Product']['price']."</td>";
		if ($edit == true) {
			echo "<td><textarea cols=\"3\" rows=\"1\">".$itemData['quantity']."</textarea></form></td>";
			echo "<td>".$this->html->link("Delete", array("controller"=>"Baskets", "action"=>"edit", $itemData['product_id'], 0, true))."</td>";
		}
		else {
			echo "<td>".$itemData['quantity']."</form></td>";
		}
		echo "</tr>";

	}

	echo "</table>";
	echo "<div id=\"total_frame\">Total: &#163;".$total."</div>";
	if ($edit == true) {
		echo "<span id=\"quantity_edit_link\">Update quantities</span></br></br>";
		echo $this->Html->link('Checkout', array('controller'=>'orders', 'action'=>'login'));
	}
}
else {
	echo "Your basket is currently empty";
}

?>