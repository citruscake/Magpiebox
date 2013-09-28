<script type="text/javascript">

$(document).ready(function() {

	$('#add_basket_link').click(function() {
		$('#Add').submit();
	});

	$('#add_basket_link').hover(function() {
		$(this).addClass('hover');
	},
	function() {
		$(this).removeClass('hover');
	});

	$('#mb_product_image').elevateZoom({
		zoomWindowFadeIn: 500,
		zoomWindowFadeOut: 500,
		lensFadeIn: 500,
		lensFadeOut: 500,
		//zoomType				: "inner",
		//cursor: "crosshair"
		zoomWindowPosition: 16,
		zoomWindowOffety: 200
	});
	
});
</script>
<?php 
	$quantity_penalty = 0;

	if(isset($basket)) {
		foreach($basket as $i=>$itemData) {
			if($product['product_id'] == $itemData['product_id']) {
				$quantity_penalty = $itemData['quantity'];
			}
		}
	}
?>
<div class-"row-fluid">
	<div class="row-fluid">
			<h2 style="margin: 0px;"><?php echo $product['name']; ?></h2>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<?php 
				$image_url = "/img/product_images/".$product['product_id']."/".$product['product_id']."_".$product['primary_image'].".jpg"; 
			?>
			<img id="mb_product_image" src="<?php echo $image_url; ?>" data-zoom-image="<?php echo $image_url; ?>" width=100% />
		</div>
		<div class="span7">
			<div class="row-fluid">
				Price: &#163;<?php echo $product['price']; ?>
			</div>
			<div class="row-fluid">
				<?php
					if($product['quantity'] > 0) {
						echo $product['quantity']." in stock";
					}
					else {
						echo "Out of stock";
					}
				?>
			</div>
			<div class="row-fluid">
				<?php echo "<p>".$product['description']."</p>"; ?>
			</div>
			<div class="row-fluid">
					<?php 
						if(($product['quantity']-$quantity_penalty) > 0) {
							echo $this->Form->create("Add", array("id" => "Add", "url" => array("controller" => "baskets", "action" => "add"))); 
							$min_quantity = min(($product['quantity']-$quantity_penalty), 9);
							$options = array();
							for($i=1;$i<=$min_quantity;$i++) {
								$options[$i-1] = $i;
							}
							echo $this->Form->input('quantity_index', array("options"=>$options, 'type'=>'select', 'default'=>0, 'label'=>false)); 
							echo $this->Form->input('product_id', array('type'=>'hidden', 'default'=>$product['product_id']));
							echo $this->Form->end();
						}
					?>
			</div>
			<div class="row">
				<?php //echo $this->Html->link('Add to Basket', array('controller' => 'baskets', 'action' => 'add', $product['product_id']), array("class"=>"link_a")); 
				?>
				<div id="row">
					<?php if(($product['quantity']-$quantity_penalty) > 0) { ?>
						<span id="add_basket_link" class="btn">Add to Basket</span>
					<?php } else { ?>
						<span class="btn">Notify me</span>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>