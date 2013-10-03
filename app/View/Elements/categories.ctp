<div id='categories_container'>
  <div class='row-fluid'>
    <nav>
      <ul class='nav nav-pills nav-stacked'>
        <li>
          <?php
          	echo $this->Html->link('All Items', array('controller'=>'products', 'action'=>'index'));
          ?>
        </li>
        <?php
        	foreach ($categories as $category) {
        
        		echo "<li>".$this->Html->link($category['name'], array('controller'=>'products', 'action'=>'index', $category['category_id']))."</li>";
        
        	}
        ?>
      </ul>
    </nav>
  </div>
</div>
<?php
	/* if(isset($current_query)) {
	if($current_query == true) {
		echo "<li>".$this->Html->link('Search results', array('controller'=>'products', 'action'=>'search'))."</li>";
	}
}*/
?>
