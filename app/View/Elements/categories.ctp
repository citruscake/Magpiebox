<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>

<?php

$categories = $this->requestAction('products/getCategories');
	
	echo "<div class=\"row-fluid\"><ul class=\"nav nav-tabs nav-stacked\">";
	echo "<li>".$this->Html->link('All Items', array('controller'=>'products', 'action'=>'index'))."</li>";

foreach ($categories as $category) {

	echo "<li>".$this->Html->link($category['Category']['name'], array('controller'=>'products', 'action'=>'index', $category['Category']['category_id']))."</li>";

}
if(isset($current_query)) {
	if($current_query == true) {
		echo "<li>".$this->Html->link('Search results', array('controller'=>'products', 'action'=>'search'))."</li>";
	}
}
	echo "</ul></div>";
?>