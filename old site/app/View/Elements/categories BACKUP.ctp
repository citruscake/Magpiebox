<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Nunito' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>

<?php

$categories = $this->requestAction('products/getCategories');
	
	echo "<div class=\"categories\">"; //<div class=\"title_wrapper\"><span class=\"title\">Categories</span></div>
	echo "<div class=\"list_wrapper\"><ul>";
	echo "<li>".$this->Html->link('All Items', array('controller'=>'products', 'action'=>'index'), array("class"=>"link_b"))."</li>";

foreach ($categories as $category) {

	echo "<li>".$this->Html->link($category['Category']['name'], array('controller'=>'products', 'action'=>'index', $category['Category']['category_id']), array("class"=>"link_b"))."</li>";

}
	echo "</ul></div></div>";
?>