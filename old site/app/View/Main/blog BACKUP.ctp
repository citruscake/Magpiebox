<style type="text/css">

#blog_list_container {
	width:81%;
	//background-color:#eeeeee;
}

#blog_post_inner_container {

	width:95%;
	//background-color:#bbbbbb;

}

#blog_post_author_frame {
	width:200px;
	height:20px;
	display:inline;
	float:left;
	padding:5px 0px 5px 0px;
	color:#333333;
	font-size:18px;
}

#blog_post_date_frame {
	width:300px;
	height:20px;
	display:inline;
	float:left;
	padding:5px 0px 5px 0px;
	color:#333333;
	font-size:18px;
}

#blog_post_content_container {
	width: 96%;
	background-color: rgb(248, 240, 255);
	padding: 11px;
	margin-top: -12px;
	font-family: arial;
	color: #333333;
	margin-left: 5px;
	font-size: 18px;
}

#blog_post_info_bar {
	height: 30px;
	width: 798px;
	padding: 1px 5px 1px 10px;
	position: relative;
	top: -18px;
}

#blog_post_title_container {

	width: 797px;
	font-family: Bad Script;
	padding: 9px;
	color: #333333;
	font-size: 30px;

}

#blog_post_container {

	width: 100%;
	//background-color: #dddddd;
	margin-bottom: 20px;
	border-radius: 5px 5px 0px 0px;

}
</style>
<div id="blog_list_container">
<?php

foreach($posts as $post) {

	echo "<div id=\"blog_post_container\">";
	echo "<div id=\"blog_post_title_container\">".$post['title']."</div>";
	echo "<div id=\"blog_post_info_bar\"><div id=\"blog_post_author_frame\">".$post['author']."</div><div id=\"blog_post_date_frame\">".$post['pubDate']."</div></div>";
	echo "<div id=\"blog_post_content_container\">".$post['description']."</div>";
	echo "</div>";
}

?></div>