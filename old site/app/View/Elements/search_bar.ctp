	<?php /*
		if($this->action != "search") {
			echo "<div id=\"mb_search_container\" style=\"top: 25px;left: 685px;\">";
		}
		else {
			echo "<div id=\"mb_search_container\" style=\"top:-95px;left:684px;\">";
		}*/
	?>
		<?php echo $this->Form->create('Search', array('id' => 'Search', 'url' => array("controller"=>"products", "action"=>"search"), 'class'=>'form-search form-horizontal')); ?>
			<div class="input-append">
			<input type="text" id="search_text_box" autocomplete="off" name="query" class="search-query"
				<?php
					if(isset($search_query)) {
						echo " value=\"".$search_query."\" ";
					}
				?>
			placeholder="Search products" style="width:400px;">
			<div id="search_submit_link" class="btn"><i class="icon-search"></i></div>
		<?php echo $this->Form->end(); ?>
	</div>