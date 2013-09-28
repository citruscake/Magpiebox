<div class="row">
	<?php
		if($this->action != "search") {
			echo "<div id=\"mb_search_container\" style=\"top:-5px;left:484px;\">";
		}
		else {
			echo "<div id=\"mb_search_container\" style=\"top:-95px;left:484px;\">";
		}
	?>
	<div id="mb_search_container">
	
	
		<?php echo $this->Form->create('Search', array('id' => 'Search', 'url' => array("controller"=>"products", "action"=>"search"), 'class'=>'form-search')); ?>
			<input type="text" id="search_text_box" autocomplete="off" name="query" class="input-medium search-query"
				<?php
					if(isset($search_query)) {
						echo " value=\"".$search_query."\" ";
					}
				?>
			>
			<div id="search_submit_link" class="btn"><i class="icon-search"></i></div>
		<?php echo $this->Form->end(); ?>
		
		<?php /*<label for="basic_autocomplete_field">Favorite Fruit</label>
         <input type="text" autocomplete="off" id="search_text_box"/>*/?>
	</div>
</div>