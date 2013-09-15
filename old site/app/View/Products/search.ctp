<div class="row" style="margin-top:40px;">
	<h2 style="margin-left:32px; margin-top:5px;">Search results for "<?php echo $current_query;?>"</h2>
</div>
<?php if(isset($current_query)) { ?>
<div class="row" style="margin-top:-40px;">
	<div class="span3" style="padding-left:35px;">
		<h5>Select a previous search: </h5>
	</div>
	<div class="span5">
		<?php echo $this->Form->create('Search_history', array('id' => 'Search_history', 'url' => array("controller"=>"products", "action"=>"search"))); ?>
		<select id="search_select" name="search_request" style="margin-left:-60px;margin-top:5px;">
		<?php 
			foreach($searches as $i=>$search) {
				echo "<option value=".$i;
				if(isset($current_index)) {
					if($current_index == $i) {
						echo " selected >".$search['query']."</option>";
					}
					else {
						echo ">".$search['query']."</option>";
					}
				}
				else {
					echo ">".$search['query']."</option>";
				}
			}
			?>
		</select>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<?php } ?>
<div class="row" style="margin-top:20px;">
<?php
	//var_dump($products);
	//exit();
	if(isset($products)) {
		echo $this->element('products_list', array('products' => $products));
	}
	else {
		echo "<div class=\"row\"><h3>No results to display</h3></div>";
	}
?>
</div>