<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
<ul class="thumbnails">

<?php 

	$counter = 0;

	foreach($products as $product) {

		if (($counter % 4) == 0) {
			//echo "<li class=\"span2\">";
		}

?>
	<li class="mb_thumbnail_width">
		<div class="thumbnail" style="height:270px;">
				<div class="row" style="height:180px;">
				<?php echo $this->Html->image("/img/product_images/".$product['Product']['product_id']."/".$product['Product']['product_id']."_".$product['Product']['primary_image'].".jpg", array('alt' => $product['Product']['name'], 'width'=>'100%', 'url'=>array('controller'=>'products', 'action'=>'view',  $product['Product']['product_id']))); ?>
					</div>
					<div class="caption">
					<div class="row">
						<?php echo $this->html->link($product['Product']['name'], array("controller"=>"products", "action"=>"view", $product['Product']['product_id']), array("class"=>"title_link_a")); ?>
					</div>
					<div class="row">
						<?php echo " &#163;".$product['Product']['price']; ?>
					</div>
					</div>
		</div>
	</li>
<?php

		if (($counter % 4) == 3 || $counter == (count($products)-1)) {
			//echo "</div>";
		}

		$counter++;

	}

?>

</ul>