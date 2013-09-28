<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="/jquery/timeout/jquery.ba-dotimeout.min.js"></script>
<script src="/jquery/jquery-ui-1.10.2/ui/jquery-ui.js"></script>
<script type="text/javascript">

$(document).ready(function() {

	$('#add_basket_link').click(function() {
		$('#Add').submit();
	});

	$('#add_basket_link').hover(function() {
		$(this).addClass('hover');
	},
	function() {
		$(this).removeClass('hover');
	});

});
</script>
<style type="text/css">
	.hover {
		text-decoration:underline;
		cursor:pointer;
	}
</style>
<style type="text/css">
	#product_outer_container {
		width:880px;
		//background-color:#dddddd;
		margin-left:10px;
	}
	
	#product_inner_container {
		width:880px;
		//background-color:#cccccc;
		position:relative;
		margin-top:15px;
		margin-left:28px;
	}
	
	#product_inner_container #product_primary_column {
		width: 430px;
		float:left;
		position:relative;
	}
	
	#product_inner_container #product_secondary_column {
		width:400px;
		float:left;
		position:relative;
		//background-color:#bbbbbb;
	}
	
	#product_inner_container #main_image_outer_frame {
		width:400px;
		//height:350px;
		//background-color:#aaaaaa;
	}
	
	#product_inner_container #main_image_inner_frame {
		width:375px;
		//height:350px;
		//background-color:#aaaaaa;
		margin-left:13px;
		//margin-top:25px;
	}
	
	#product_outer_container #title_container {
	
		width:100%;
		//height:50px;
		//background-color:#eeeeee;
	
	}
	
	#product_outer_container #title_frame {
	
		position:relative;
		padding-left:28px;
		//margin-top:10px;
		width:100%;
		//height:40px;
		//background-color:#777777;
		//top:5px;
	
	}
	
	#product_price_frame {
		position:relative;
		//padding-left: 15px;
		padding-top: 20px;
		height:25px;
		width:100%;
	}
	
	#product_description_frame {
		position:relative;
		padding-top:20px;
		//padding-left:15px;
		width:100%;
		padding-bottom:5px;
	}
	
	#product_quantity_frame {
		position:relative;
		//top:45px;
		//padding-left:15px;
		width:100%;
		height:30px;
	}
	
	#product_add_to_basket_form_frame {
		position:relative;
		top:6px;
		//background-color:#dddddd;
		padding-top:15px;
		//padding-left:8px;
		width:100%;
		height:100px;
	}
	
	#product_add_to_basket_link_frame {
		position:relative;
		//padding-top:5px;
		height:30px;
		width:100%;
		top:-5px;
	}
	
</style>
<div id="product_outer_container">
	<div id="title_container">
		<div id="title_frame">
			<span class="title_d"><?php echo $product['name']; ?></span>
		</div>
	</div>
	<div id="product_inner_container">
		<div id="product_primary_column">
			<div id="main_image_outer_frame">
				<div id="main_image_inner_frame">
					<img src="<?php echo $product['image_url']; ?>" width=100% />
				</div>
			</div>
		</div>
		<div id="product_secondary_column">
			<div id="product_price_frame">
				<span class="title_b">Price: &#163;<?php echo $product['price']; ?></span>
			</div>
			<div id="product_quantity_frame">
				<?php
					if($product['quantity'] > 0) {
						echo "<span class =\"title_b\">".$product['quantity']." in stock</span>";
					}
					else {
						echo "<span class =\"red_text\">Out of stock</span>";
					}
				?>
			</div>
			<div id="product_description_frame">
				<?php echo $product['description']; ?>
			</div>
			<div id="product_add_to_basket_form_frame">
				<div id="product_quantity_select_frame">
					<?php 
						echo $this->Form->create("Add", array("id" => "Add", "url" => array("controller" => "baskets", "action" => "add"))); 
					
						$options = array();
						for($i=1;$i<10;$i++) {
							$options[$i-1] = $i;
						}
						echo $this->Form->input('quantity_index', array("options"=>$options, 'type'=>'select', 'default'=>0, 'class'=>'select_a', 'label'=>false)); 
						echo $this->Form->input('product_id', array('type'=>'hidden', 'default'=>$product['product_id']));
						echo $this->Form->end();
					?>
				</div>
				<?php //echo $this->Html->link('Add to Basket', array('controller' => 'baskets', 'action' => 'add', $product['product_id']), array("class"=>"link_a")); 
				?>
				<div id="product_add_to_basket_link_frame"><span id="add_basket_link" class="link_a">Add to Basket</span></div>
			</div>
		</div>
	</div>
</div>