<div id="mb_blog_container">
	<div class="span10">
<?php

foreach($posts as $post) {

	echo "<div class=\"row\">";
	echo "<div class=\"row\"><h2>".$post['title']."</h2></div>";
	echo "<div class=\"row\"><div class=\"span2\">".$post['author']."</div><div class=\"span4\">".$post['pubDate']."</div></div>";
	echo "<div class=\"row\" style=\"margin-top:10px;\">".$post['description']."</div>";
	echo "</div>";
}

?>
	</div>
</div>