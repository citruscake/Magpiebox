<?php

class BasketsController extends AppController {

var $uses = array('Product', 'Basket');
var $helpers = array('Form', 'Html');

public function index() {

	$this->layout = "shop_main";
	$this->set("page_type", "shop");
	$this->set('heading', 'Basket');
	
	//$this->Session->delete('basket');
	
	//The following is to remove any previous checkout attempts
	foreach(array("checkout_progress","delivery_address","delivery_address_id","billing") as $variable) {
		if($this->Session->check($variable)) {
			$this->Session->delete($variable);
		}
	}
	//$this->Session->destroy();
	//exit();
	
	if($this->Session->check("context") && $this->Session->read("context") == "order") {
		$this->Session->delete("context");
	}
	
	if ($this->Session->check('basket')) {
		
		$basket = $this->Session->read('basket');
		$this->set('basket', $basket);
	}
/*
		if(isset($this->params['requested'])) {
			return $basket;
		}	
		else {

			$products = array();
			
			foreach($basket as $i => $itemData) {
				array_push($products, $this->Product->find('first', array('conditions'=>array('product_id'=>$itemData['product_id']))));
			}

			$this->set('products', $products);
			if ($this->Session->check('total')) {
				$this->set('total',$this->Session->read('total'));
			}
			else {
				$this->set('total',0); //this should not happen
			}

			$this->set('basket', $basket);
		}
	}
	else if(empty($basket)) {
		if(isset($this->params['requested'])) {
			return false;
		}
		else {
			//$this->Session->setFlash(__('You currently have no items in your basket'));
		}
	}*/
	
	if (!$this->Session->check('total')) {
		$this->Session->write('total', 0);
	}

}

//public function add($product_id) {
public function add() {

	if ($this->request->is('post')) {
		$inArray = false;

		if(empty($basket)) {
			$basket = array();
		}
	
		if ($this->Session->check('basket')) {
			$basket = $this->Session->read('basket');
		}	
		
		$itemData = $this->request->data['Add'];
		//var_dump($itemData);
		//echo"</br></br>";
		
		foreach($basket as $i => $item) {
			if ($basket[$i]['product_id'] == $itemData['product_id']) {
				$basket[$i]['quantity'] = $basket[$i]['quantity'] + $itemData['quantity_index']+1;
				$inArray = true;
				break;
			}
		}
	
		if($inArray == false) {
			array_push($basket, array('product_id' => $itemData['product_id'], 'quantity' => $itemData['quantity_index']+1));
		}
	//	echo $inArray;
		//var_dump($basket);
		//exit();
		$this->Session->write('basket', $basket);
		$this->updateTotal();
		$this->redirect($this->referer());
	}
	else {
		//should only be accessed through post
		$this->redirect($this->referer());
	}
}

public function edit($product_id, $quantity, $isDelete=false) {

	if ($this->Session->check('basket')) {
		$basket = $this->Session->read('basket');
		if ($quantity == 0) {
		
			$newBasket = array();
		
			foreach($basket as $i => $itemData) {
				if ($itemData['product_id'] != $product_id) {
					//unset($basket[$i]);
					array_push($newBasket, $itemData);
				}
			}
			
			$this->Session->write('basket', $newBasket);
		}
		else {
			foreach($basket as $i => $itemData) {
				if ($itemData['product_id'] == $product_id) {
					$basket[$i]['quantity'] = $quantity;
					break;
				}
			}
			
			$this->Session->write('basket', $basket);
		}	
		
	}
	else {
		$this->Session->setFlash(__('Could not alter the basket value'));
	}
		
	$this->updateTotal();
	
	if($isDelete == true) {
		$this->redirect($this->referer());
	}
}

public function getItems() {
	
	if(isset($this->params['requested'])) {	
		if ($this->Session->check('basket')) {
			return $this->Session->read('basket');
		}
		else {
			return false;
		}
	}
	else {
			//should only be called from requested context
			return false;
	}
	
}

public function processAJAXQuery() {

	$this->autoRender = false;

	$jsonData = json_decode($this->params['data']['jsonData'], true);
	$command = $jsonData['command'];

	//echo $command;
	//exit();
	//var_dump($this->params['data']['jsonData']);
	//var_dump($jsonData);
	//var_dump($this->params['data']['jsonData']);
	//exit();
		switch($command) {
			case "update" :
				foreach($jsonData['products'] as $product) {
					//exit();
					$this->edit($product['product_id'],($product['quantity_index']+1));
				}
				break;
			default :
				break;
		}
		
	//echo "here";
	//exit();
		
	return true;
}

private function updateTotal() {

	$this->autoRender = false;
	
	if ($this->Session->check('basket')) {

		$basket = $this->Session->read('basket');
		$total = 0;
		
		foreach($basket as $i => $itemData) {
			$product = $this->Product->find('first', array('conditions'=>array('product_id'=>$itemData['product_id'])));
			$total += $product['Product']['price'] * $itemData['quantity'];
		}
		
		$this->Session->write('total', $total);
	}	
}

public function getProductData() {

	if ($this->Session->check('basket')) {
		
			$basket = $this->Session->read('basket');

			$products = array();
			
			foreach($basket as $i => $itemData) {
				array_push($products, $this->Product->find('first', array('conditions'=>array('product_id'=>$itemData['product_id']))));
			}

			$this->set('products', $products);
			if ($this->Session->check('total')) {
			//	$this->set('total',$this->Session->read('total'));
				$total = $this->Session->read('total');
			}
			else {
			//	$this->set('total',0); //this should not happen
				$total = 0;
			}

			$productData = array();
			$productData['products'] = $products;
			
			if(strrpos((string)$total,".") == false) {
				$total = (string)$total.".";
			}
			
			while (strlen($total) - strrpos((string)$total,".") <= 2) {
				$total = (string)$total."0"; 
			}
			
			$productData['total'] = $total;
			//$this->set('basket', $basket);
			return $productData;
	}
	else if(empty($basket)) {
		return false;
	}		
}

}

?>