<div class="span6">
<?php if($this->action != "view") {
	echo "<ul class=\"breadcrumb\ style=\"margin: 0px;\">";
}
else {
	echo "<ul class=\"breadcrumb\" style=\"margin: 0px;\">";
}
?>
<ul class="breadcrumb">

	<?php
	
			echo "<li>".$this->html->link("All items", array('controller'=>'products', 'action'=>'index'))."</li>";
		
			if($breadcrumb_depth>=2) {
				echo "<li><span class=\"divider\"> / </span></li> ".$this->html->link($category['name'], array('controller'=>'products', 'action'=>'index', $category['category_id']))."</li>";
			}
			if($breadcrumb_depth==3) {
				echo "<li><span class=\"divider\"> / </span></li>";
				echo $this->html->link($product['name'], array('controller'=>'products', 'action'=>'view', $product['product_id']));
			}
		
			echo "</ul>";
	?>
	
</div>