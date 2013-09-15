
<?php /*<script src="http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<?php /*<script src="/jquery/fineuploader/jquery.fineuploader-3.3.0.min.js"></script> */?>

<style type="text/css">

.qq-upload-list {
display:none;
}

.qq-upload-drop-area {
width:150px;
height:150px;
background-color:#444444;
//display:block;
}

.qq-upload-button {
width: 150px;
//top: -150px;
height: 150px;
//display:none;
position:absolute;
top:-1200px;
}

.qq-drop-processing {
display:none;
}

#qq-file-input {


}

#sortable ul { list-style-type: none; margin: 0; padding: 0; width: 100%; }

#sortable li { float:left; }

#uploader_spinner {
visibility:hidden;
position:relative;
top:-85px;
left:60px;
}

textarea {
border:none;
resize:none;
overflow:hidden;
}

#spreadsheet_container {

overflow:auto;
//height:800px;

}

#spreadsheet_container td {

vertical-align:top;

}

.edit_button {

cursor:pointer;

}

.confirm_button {

visibility:hidden;
cursor:pointer;

}

.delete_button {

//visibility:hidden;
cursor:pointer;

}

.picture_button {

cursor:pointer;


}

#image_editor {

display:none;
opacity:0;
position:absolute;
z-index:10000;
height:420px;
//width:1200px;
//height:300px;
//margin-top:300px;
//border: 1px solid #000000;
background-color:#FFFFFF;
//left:10px;
//top:30px;
//display:block;
width:90%;
margin-left:-15%;
margin-top:-120px;
//margin-left:-200px;
//position:fixed;
}

#image_editor .image_gallery {

position:relative;
height:200px;
width:750px;
margin-top:10px;
margin-left:10px;

}

#image_editor .image_outer_frame {

position:relative;
height:200px;
width:200px;
//border: 2px solid #333333;
//display:inline;
//float:left;
padding:5px;

}

#image_editor .image_inner_frame  {

border: 2px solid #333333;
background-color:#dddddd;
height:100%;
width:100%;
}

#uploader_container {
//width:100px;
//height:100px;
background-color:#eeeeee;
width:150px;
height:150px;
}

.mb_checkbox_buttons {

}

.mb_checkbox_buttons ul {
	list-style:none;
	margin-top: -14px;
	display:block;
}

.mb_checkbox_buttons ul li {
  //padding-top: 8px;
  //padding-bottom: 8px;
  //margin-top: 2px;
  //margin-bottom: 2px;
  margin-right:5px;
  padding:5px 7px 5px 7px;
  -webkit-border-radius: 3px;
     -moz-border-radius: 3px;
          border-radius: 3px;
		  display:list-item;
		  float:left;
	//background-color:#F3DBFF;
}

.mb_checkbox_buttons ul li:hover {
	cursor:pointer;
}

.mb_button_checked {
	//background-color:#F3DBFF;
}

.mb_button_unchecked {
	//background-color:#FFFFFF;
}

#product_editor {

display:none;
position:absolute;
z-index:10000;
//margin-top:360px;
width:70%;
left:0;
margin-left:auto;
margin-right:auto;
//width:1200px;
//height:300px;
//border: 1px solid #000000;
//background-color:#FFFFFF;
//left:10px;
//top:30px;
//display:block;

}

.product_editor_styles {

margin-left:10%;
width:80%;
background-color:#ffffff;
//background-color:#bbbbbb;
border-radius:3px;
}

#page_overlay {
position: absolute;
top: 0;
left: 0;
width: 100%;
min-height: 100%;
background-color: #ebecff;
z-index: -90;
opacity:0;
//background-image:url('/img/wavegrid.png');
-webkit-box-shadow:  2px 2px 2px 2px rgba(0.5, 0.5, 0.5, 0.1);
        
        box-shadow:  2px 2px 2px 2px rgba(0.5, 0.5, 0.5, 0.1);
border-width:1px;
border-style:solid;
border-color:#999999;
}

#product_edit_image {

background-image:url('/img/product_images/image1.jpg');
background-repeat:no-repeat;
background-position:center center;
background-size:auto 100%;
height:200px;

}

#dummy_uploader_container {

width:150px;
height:40px;
background-color:#dddddd;
//top:-20px;
position:relative;
cursor:pointer;
}

</style>
<script type="text/javascript">

<?php

	echo "var categories = {";
	foreach($categories as $i=>$category) {
		echo "'".$category['Category']['category_id']."'";
		echo ": ";
		echo "'".$category['Category']['name']."'";
		if($i != (sizeof($categories)-1)) {
			echo ",";
		}
	}
	echo "}";

?>

var row_id = 0;
var selected_columns = new Array();

function resize_textbox() {
	$(this).attr('rows', 1); //means scrollheight becomes the actual content height
	$(this).attr('rows', Math.ceil(($(this).context.scrollHeight-4)/(($(this).context.clientHeight-4)/$(this).context.rows))); //as there is 5px padding
}

function html_escape(str) {

	return String(str).replace(/"/g, "&quot;");
}

$(document).ready(function() {  

$(".close_image_editor").click(function() {

	//$('#page_overlay').css('z-index',90);
	//$("#page_overlay").css("visibility", "visible");
	$('#page_overlay').fadeTo('fast', 0, "easeInCubic", function(){
		//animation complete
		$('#page_overlay').css('z-index',-90);
	});
	$('#image_editor').fadeTo('fast', 0, "easeInCubic", function(){
		//animation complete
		$('#image_editor').css("display", "none");
	});
	
	product_id = $("#image_editor_product_id").html();
	
	url = "/images/cancelEdit"; 
	
	JSON_data = "{ \"product_id\" : \""+product_id+"\"}";
	
	$.post(url, {jsonData : JSON_data}, function(data) {
		console.log("Query executed successfully");
	}, "json");

});

$(".confirm_image_editor").click(function() {

	$('#page_overlay').fadeTo('fast', 0, "easeInCubic", function(){
		//animation complete
		$('#page_overlay').css('z-index',-90);
	});
	$('#image_editor').fadeTo('fast', 0, "easeInCubic", function(){
		//animation complete
		$('#image_editor').css("display", "none");
	});
	
	product_id = $("#image_editor_product_id").html();
	row_index = $("#image_editor_row_index").html();
	//primary_image = $("#images_frame ul:first li .primary_image").children().eq(0);
	
	secondary_images = "";
	$.each($("#images_frame ul:first li"), function(index, item) {
		//if(!$(image).hasClass("primary_image")) {
			id = $(item).children().eq(0).attr('id');
			secondary_images += id+",";
			if ($(item).hasClass("primary_image")) {
				primary_image = id;
			}
		//}
	});
	secondary_images = secondary_images.slice(0,-1);
	//console.log(primary_image);	
	//console.log(secondary_images);	
	//return false;
	
	url = "/images/confirmEdit"; 
		
	JSON_data = "{ \"product_id\" : \""+product_id+"\",";
	JSON_data += " \"primary_image\" : \""+primary_image+"\",";
	JSON_data += " \"secondary_images\" : \""+secondary_images+"\" }";
	
	var cell = document.getElementById("cell("+row_index+","+7+")");
	alert("cell("+row_index+","+7+")");
	cell.innerHTML = primary_image;
	cell = document.getElementById("cell("+row_index+","+8+")");
	cell.innerHTML = secondary_images;
	
	$.post(url, {jsonData : JSON_data}, function(data) {
		console.log("Query executed successfully");
	}, "json");

});

$("#product_edit_tags").tagit();

var image_url;
$("#product_edit_image").hover(function() {
	image_url = $("#product_edit_image").css("background-image");
	$("#product_edit_image").animate({
		opacity:0
	}, 0, function() {
		$("#product_edit_image").css("background-image","url('/img/wood123.jpg')");
		$("#product_edit_image").animate({
		opacity:1
		}, 0);
	});
	//$("#product_edit_image").delay(1000).css("background-image","url('/img/wood123.jpg')");
	//$("#product_edit_image").delay(1000).animate({
	//	opacity:1
	//}, 100);
},
function() {
	$("#product_edit_image").css("background-image",image_url);
	$("#product_edit_image").animate({
		opacity:0
	}, 0, function() {
		$("#product_edit_image").css("background-image",image_url);
		$("#product_edit_image").animate({
		opacity:1
		}, 0);
	});
});

$(".mb_checkbox_buttons ul").on("click", ".mb_button_checked", function(event) {

		$(event.target).animate({
			//"background-color":'#925CBD'
			"background-color":'#ffffff'
		}, 50);
		$(event.target).removeClass("mb_button_checked");
		$(event.target).addClass("mb_button_unchecked");
});

$(".mb_checkbox_buttons ul").on("click", ".mb_button_unchecked", function(event) {

		$(event.target).animate({
			//"background-color":'#925CBD'
			"background-color":'#F3DBFF'
		}, 50);
		$(event.target).removeClass("mb_button_unchecked");
		$(event.target).addClass("mb_button_checked");
});

$("#spreadsheet_container").on('input propertychange', 'textarea', function() {
	console.log(this);
	resize_textbox.apply(this);
});

$("#spreadsheet_container").on('click', '.picture_button', function() {

	$('#page_overlay').css('z-index',90);
	//$("#page_overlay").css("visibility", "visible");
	$('#page_overlay').fadeTo('fast', 0.9, "easeInCubic", function(){
		//animation complete
	});
	$('#image_editor').css("display", "block");
	$('#image_editor').fadeTo('fast', 1, "easeInCubic", function(){
		//animation complete
	});
	//$('#image_editor').css("display", "block");
	
	row_index = $(event.target).parent().attr("id");
				
	cell_value = document.getElementById("cell("+row_index+",0)");
	product_id = $(cell_value).html();
	$("#image_editor_product_id").html(product_id);
	$("#image_editor_row_index").html(row_index);
	
	cell_value = document.getElementById("cell("+row_index+",7)");
	//primary_image = new Array();
	primary_image = $(cell_value).html();
					
	cell_value = document.getElementById("cell("+row_index+",8)");
	secondary_images = new Array();
	secondary_images = ($(cell_value).html()).split(",");
	//alert($.merge(primary_image,secondary_images));				
	var gallery_html = "";
	$.each(secondary_images, function(index, image_id) {

		if(image_id == primary_image) {
			gallery_html += "<li class=\"ui-state-default primary_image\"><div id=\""+image_id+"\" class=\"thumbnail\" style=\"height:130px;\">";
		}
		else {
			gallery_html += "<li class=\"ui-state-default\"><div id=\""+image_id+"\" class=\"thumbnail\" style=\"height:130px;\">";
		}
		
		gallery_html += "<a href=\"/img/product_images/"+product_id+"/"+product_id+"_"+image_id+".jpg\"><img src=\"/img/product_images/"+product_id+"/"+product_id+"_"+image_id+".jpg\" style=\"height:130px;\"/></a>";
		gallery_html += "</div></li>";
								
	});
							
	$('#images_frame ul:first').html(gallery_html);
						
	//$('#image_editor').css("display", "block");

	$( "#sortable" ).sortable({
		items: "li:not(.ui-state-disabled)",
		appendTo:'body'
	});
	$( "#sortable" ).disableSelection();

	$('#uploader_container').fineUploader({
		request : {
			endpoint : '/images/uploadimage/'+product_id,
			debug : true
		}
	}).on('complete', function(event, id, name, responseJSON){ //image was "responseJSON"

		var image_frame_html = ""; 
		image_frame_html += "<li class=\"ui-state-default\"><div id=\""+responseJSON.image_id+"\" class=\"thumbnail\" style=\"height:130px;\">";
		image_frame_html += "<a href=\"/img/temporary/temp_product_images/"+product_id+"/"+product_id+"_"+responseJSON.image_id+".jpg\"><img src=\"/img/temporary/temp_product_images/"+product_id+"/"+product_id+"_"+responseJSON.image_id+".jpg\" style=\"height:130px;\"/></a>";
		image_frame_html += "</div></li>";
		console.log("moo")				
		$(image_frame_html).insertAfter($('#images_frame ul:first').children('li:last'));
		//$("#sortable").sortable('refresh');
		$('#uploader_spinner').css('visibility', 'hidden');
	}).on('upload', function(id, name, uploadedBytes, totalBytes) {
			$('#uploader_spinner').css('visibility', 'visible');
	});
	$('.qq-upload-drop-area').children().eq(0).html('');
	$('.qq-upload-button').children().eq(0).html('');
	$('.qq-upload-button').children().eq(1).css('height','210px');
			
	/*row_index = $(this).attr("id");
	//console.log(id);
	cell_value = document.getElementById("cell("+row_index+",0)");
	//product_values[i] = $(cell_value).html();
	$("image_upload_frame").attr("id", row_index);*/
});

$("#spreadsheet_container").on('click', '.edit_button', function(event) {

	/*row_id = $(this).parent().parent().attr("id");
	$("tr#"+row_id).children(".field").each(function() {
		$(this).html("<textarea class=\"cell\">"+$(this).text()+"</textarea>");
	});
	$("textarea.cell").each(function() {
		resize_textbox.apply(this);
	});
	$("#"+row_id+" .confirm_button").css("visibility", "visible");
	$("#"+row_id+" .delete_button").css("visibility", "visible");
	$("#"+row_id+" .edit_button").css("visibility", "hidden");*/
	
	var row_index = $(this).parent().parent().attr("id");
	
	//alert($("#cell("+row_index+",0)").html());
//	var test = document.getElementById("cell("+row_index+",1)");
//	alert($(test).html());
	
	var product_values = new Array();
	var cell;
	for(i=0;i<8;i++) {
		cell_value = document.getElementById("cell("+row_index+","+i+")");
		product_values[i] = $(cell_value).html();
	}
	
	$("#product_edit_product_id").val(product_values[0]);
	$("#product_edit_name").val(product_values[1]);
	$("#product_edit_category").val(product_values[2]);
	$("#product_edit_price").val(product_values[3]);
	$("#product_edit_description").val(product_values[4]);
	$("#product_edit_quantity").val(product_values[5]);
	
	$("#product_edit_tags").tagit("removeAll");
	var tags = product_values[6].split(",");
	for(i=0;i<tags.length;i++) {
		//$("#product_edit_tags").val(product_values[6]);
		$("#product_edit_tags").tagit("createTag", tags[i]);
	}
	//$("#product_edit_tags").tagit();
	
	$("#product_edit_image").attr("src", product_values[7]);

});

$("#spreadsheet_container").on('click', '.confirm_button', function() {

	row_id = $(this).parent().parent().attr("id");
	
	var field_value;
	var JSON_data = "{ \"command\" : \"update\", ";
	JSON_data += "\"product\" : {";
	$(selected_columns).each(function(index, column) {
		field_value = $("#"+row_id).children(".field").eq(index).children("textarea").eq(0).val();
		JSON_data += "\""+column+"\" : \""+html_escape(field_value)+"\", ";
		$("#"+row_id).children(".field").eq(index).html(field_value);
	});
	
	JSON_data = JSON_data.substring(0,JSON_data.length-2);
	JSON_data += "}}";

	var url = "/products/processAJAXQuery"; 
	
	$.post(url, {jsonData : JSON_data}, function(data) {
		console.log("Query executed successfully");
	}, "json");

	$("#"+row_id+" .confirm_button").css("visibility", "hidden");
	$("#"+row_id+" .delete_button").css("visibility", "hidden");
	$("#"+row_id+" .edit_button").css("visibility", "visible");
});

$("#dummy_uploader_container").click(function() {
	//event.stopPropagation();
	$("#qq-file-input").trigger("click");
});

$(".delete_button").click(function() {

	//get parent id (should be the row)

});

$("#search_query").keypress(function(event) {
	if(event.keyCode == 13) {
		//alert("hi");
		$("#submit_product_admin_search_link").click();
		return false;
	}
});

//var window_offset = $("#image_editor").offset().left - ($(window).width()*((($(window).width()-$("#image_editor").width())/2)*$("#image_editor").width()));

//alert($("#image_editor").offset().left);
//exit();
//$("#image_editor").css('margin-left', -window_offset);

$("#submit_product_admin_search_link").click(function() {

	var search_query = $("#search_query").val();
	var url = "/products/productsToJSON/?search_query="+search_query;
	
	var spreadsheet = "<table class=\"table table-hover\">";
	
	/*$("input:checkbox[name=column_select]:checked").each(function() {
		selected_fields.push($(this).val());
		spreadsheet += "<td>"+$(this).val()+"</td>";
		url += "&fields[]="+$(this).val();
	});*/

	$(".mb_checkbox_buttons ul li.mb_button_checked").each(function() {
		//spreadsheet += "<td>"+$(this).attr('id')+"</td>";
		url += "&fields[]="+$(this).attr('id');
	});
	//return false;
	//spreadsheet += "<td>Edit</td><td></td>";
//	spreadsheet += "</tr>";
	
	// Print the column names
	//alert(url);
	$.get(url,
		function(data) {
			$.each(data, function(index, products) {

				spreadsheet += "<tr><td></td>"; //one cell for thumbnail
				$.each(["Name","Category","Price", "Description", "Quantity", "Tags", "Edit", "Images", "Delete"], function(index, field) {
					spreadsheet += "<td>"+field+"</td>";					
				});
					
				spreadsheet += "</tr>";
			
				$.each(products, function(index, product) {
				
					//row_id = product.product_id;
					console.log(product);
					
					spreadsheet += "<tr id="+index+"><td>";
					spreadsheet += "<div class=\"thumbnail\"><img src=\"/img/product_thumbnails/"+product.product_id+"/"+product.product_id+"_"+product.primary_image+".jpg\" style=\"width:60px;\"/></div>";
					spreadsheet += "</td>";
					
					/*$.each(product, function(index, field) {
						
						$.each(["Name","Category","Price", "Description", "Quantity", "Tags", "Edit"], function(index, field) {
						spreadsheet += "<td>"+field+"</td>";
					});
					});*/
					
					spreadsheet += "<td id=\"cell("+index+","+0+")\" style=\"display:none;\">"+product.product_id+"</td>";
					spreadsheet += "<td id=\"cell("+index+","+1+")\">"+product.name+"</td>";
					
					var category_id = product.category_id;
					category_name = categories[category_id];
					
					spreadsheet += "<td>"+category_name+"</td>";
					spreadsheet += "<td id=\"cell("+index+","+2+")\" style=\"display:none;\">"+category_id+"</td>";
					spreadsheet += "<td id=\"cell("+index+","+3+")\">"+product.price+"</td>";
					spreadsheet += "<td id=\"cell("+index+","+4+")\">"+product.description+"</td>";
					spreadsheet += "<td id=\"cell("+index+","+5+")\">"+product.quantity+"</td>";
					spreadsheet += "<td id=\"cell("+index+","+6+")\">"+product.tags+"</td>";
					spreadsheet += "<td id=\"cell("+index+","+7+")\" style=\"display:none;\">"+product.primary_image+"</td>";
					spreadsheet += "<td id=\"cell("+index+","+8+")\" style=\"display:none;\">"+product.secondary_images+"</td>";
					
					spreadsheet += "<td><span id=\""+index+"\" class=\"edit_button\" rel=\"#product_editor\" ><i class=\"icon-edit icon-large\"></i></span></td>";
					spreadsheet += "<td><span id=\""+index+"\" class=\"picture_button\" rel=\"#image_editor\" ><i class=\"icon-camera icon-large\"></i></span></td>";
					spreadsheet += "<td><span id=\""+index+"\" class=\"delete_button\" ><i class=\"icon-remove icon-large\"></i></span></td>";
					spreadsheet += "</tr>";
					
				});
				//spreadsheet += "</tr>";
			});
			
			spreadsheet += "</table>";
			
			//alert(spreadsheet);
			//return false;
			$("#spreadsheet_container").html(spreadsheet);
			
			$(".edit_button[rel]").overlay({
				top:100,
				mask: {
					color: '#ebecff',
					loadSpeed: 200,
					opacity: 0.9
				}
			});
			
				/*$(".picture_button").click(function(event) {
				
					row_index = $(event.target).parent().attr("id");
					
					cell_value = document.getElementById("cell("+row_index+",0)");
					product_id = $(cell_value).html();
					
					cell_value = document.getElementById("cell("+row_index+",7)");
					primary_image = $(cell_value).html();
					
					cell_value = document.getElementById("cell("+row_index+",8)");
					secondary_images = $(cell_value).html().split(",");
					
					var gallery_html = "";
					$.each($.merge(primary_image,secondary_images), function(index, image_id) {

						gallery_html += "<li class=\"ui-state-default\"><div id=\""+image_id+"\" class=\"thumbnail\" style=\"height:130px;\">";
						gallery_html += "<a href=\"/img/temporary/temp_product_images/"+product_id+"/"+product_id+"_"+image_id+".jpg\"><img src=\"/img/temporary/temp_product_images/"+product_id+"/"+product_id+"_"+image_id+".jpg\" style=\"height:130px;\"/></a>";
						gallery_html += "</div></li>";
									
					});
							
					$('#images_frame ul:first').html(gallery_html);
						
					$('#image_editor').css("display", "block");

					$( "#sortable" ).sortable({
						items: "li:not(.ui-state-disabled)",
						appendTo:'body'
					});
					$( "#sortable" ).disableSelection();

					$('#uploader_container').fineUploader({
						request : {
							endpoint : '/images/uploadimage/'+product_id,
							debug : true
						}
					}).on('complete', function(event, id, name, responseJSON){ //image was "responseJSON"

						var image_frame_html = ""; 
						image_frame_html += "<li class=\"ui-state-default\"><div id=\""+responseJSON.image_id+"\" class=\"thumbnail\" style=\"height:130px;\">";
						image_frame_html += "<a href=\"/img/product_images/"+product_id+"/"+product_id+"_"+responseJSON.image_id+".jpg\"><img src=\"/img/product_thumbnails/"+product_id+"/"+product_id+"_"+responseJSON.image_id+".jpg\" style=\"height:130px;\"/></a>";
						image_frame_html += "</div></li>";
						
						$(image_frame_html).insertAfter($('#images_frame ul:first').children('li:last'));
						$('#uploader_spinner').css('visibility', 'hidden');
					}).on('upload', function(id, name, uploadedBytes, totalBytes) {
						$('#uploader_spinner').css('visibility', 'visible');
					});
					$('.qq-upload-drop-area').children().eq(0).html('');
					$('.qq-upload-button').children().eq(0).html('');
					$('.qq-upload-button').children().eq(1).css('height','210px');
				});*/
				/*onClose: function(event, index) {
					$('#uploader_container').unbind();
					//$('#page_overlay').delay(100).css('z-index',90);
					//$("#page_overlay").css("visibility", "visible");
					//$('#page_overlay').fadeTo('fast', 0, "easeInCubic", function(){
					//animation complete
					//});
				}*/
		},
		"json");
	});
});
</script>
<div id="image_editor" style="overflow:auto;">
	<div class="row-fluid">
		<?php echo $this->element("image_editor"); ?>
	</div>
</div>
<div id="product_editor">
		<div class="row-fluid">
			<div class="span12 product_editor_styles">
				<?php 
					echo $this->element('product_edit_panel', array('fields'=>$fields)); 
				?>
			</div>
		</div>
</div>
<div id="page_overlay"></div>
<?php echo $this->Form->create('Product_admin_search', array('id' => 'Product_admin_search', 'class'=>'form-search form-horizontal')); ?>
<div class="row-fluid">
	<div class="span5">
		<div class="control-group">
			<?php /* <label class="control-label" for="search_term">Search</label> */ ?>
				<div class="controls" style="margin-left:0px;">
				<div class="input-append">
				<input type="text" class="search-query" id="search_query" name="data[Product_search][search_term]" placeholder="Search Products" style="width:400px;">
				<div class="btn" id="submit_product_admin_search_link"><i class="icon-search"></i></div>
				</div>
			</div>
		</div>
	</div>
	<div class="span7">
	<?php 
		$i = 0;
		echo "<div class=\"mb_checkbox_buttons\"><ul>";
		foreach($fields as $field) {
			//echo "<input type=\"checkbox\" name=\"column_select\" value=\"".$column."\" checked>".str_replace("_"," ",$column)." ";
			echo "<li class=\"mb_button_checked\" id=\"".$field."\" style=\"background-color:#F3DBFF;\">".$field."</li>";
			$i++;
		}
		echo "</ul></div>";
	?>
	</div>
<?php echo $this->Form->end(); ?>
<div class="row-fluid">
	<div id="spreadsheet_container" class="span12">
	</div>
</div>