<div id="mb_basket_container" class="span8">
	<?php

		$productData = $this->requestAction(array("controller"=>"baskets", "action"=>"getProductData"));
		$products = $productData['products'];
		$total = $productData['total'];

		if(isset($basket)) {

			echo "<table id=\"basket_table\" class=\"table table-hover\">";

			foreach($basket as $i=>$itemData) {

				echo "<tr id=\"".$itemData['product_id']."\">";
				echo "<td>".$this->html->link($products[$i]['Product']['name'], array("controller"=>"products", "action"=>"view", $itemData['product_id']))."</td>";
				echo "<td>&#163;".$products[$i]['Product']['price']."</td>";
				
				if ($edit == true) {
	
					$min_quantity = min($products[$i]['Product']['quantity'], 9);
					echo "<td><select class=\"basket_selects\">";
					
					for($i=1;$i<=$min_quantity;$i++) {
						if(($i) == $itemData['quantity']) {
							echo "<option value=".($i-1)." selected>".($i)."</option>";
						}
						else {
							echo "<option value=".($i-1).">".($i)."</option>";
						}
					}
					echo "</select></td>";
					echo "<td>".$this->html->link("Delete", array("controller"=>"Baskets", "action"=>"edit", $itemData['product_id'], 0, true))."</td>";
			}
			else {
				echo "<td>".$itemData['quantity']."</td>";
			}
			echo "</tr>";
		}

		echo "</table>"; 
	
	?>
	<div class="row">
		<div class="span6"></div>
		<div class="span2">
			<div class="row">
				<div id="mb_total_frame"><?php echo "Total: &#163;".$total; ?></div>
			</div>
			<?php if ($edit == true) { ?>
				<div class="row">
					<a href="/orders/login"><div class="btn" style="margin-left:75px; margin-top:10px;">Checkout</div></a>
				</div>
			<?php } ?>
		</div>
	</div>
<?php 
	}
	else {
		echo "<div class=\"row\">";
		echo "<h2>Your basket is currently empty</h2>";
		echo "</div>";
	}
?>
</div>