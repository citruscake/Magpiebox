$(document).ready(function() {

	$('select.basket_selects').change(function() {
	
		var JSON_data = "{ \"command\" : \"update\", ";
		JSON_data += "\"products\" : [";
	
		$('#basket_table tr').each(function() {
			if ($(this).attr('id')) {
				JSON_data += "{ \"product_id\" : "+$(this).attr('id')+", ";
				JSON_data += " \"quantity_index\" : "+parseInt($(this).children('td:nth-child(3)').children('select:first').val());
				JSON_data += "},";
			}
		});
		
		JSON_data = JSON_data.substring(0,JSON_data.length-1);
		JSON_data += "] }";

		var url = "/baskets/processAJAXQuery";
			
		$.post(url, {jsonData : JSON_data}, function(data) {
			console.log("Query executed successfully");
			location.reload();
		}, "json");
	});
});