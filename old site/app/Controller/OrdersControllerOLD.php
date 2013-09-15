<?php

class OrdersController extends AppController {

var $components = array('Wizard.Wizard');
var $uses = array('Order_items','User_profile','Order','User','Delivery_address','Billing','Product');

function beforeFilter() {
//$this->Wizard->reset();
//exit();
$this->Wizard->steps = array('address', 'billing', 'review');
echo "hello";
}

function wizard($step = null) {

		if ($step=='address') {
			//$this->saveSessionData();
			$this->saveCheckoutData();
		//	echo var_dump($this->Wizard->read());
		//	exit();
		}
		if($step=='review') {
			//echo var_dump($this->Wizard->read());
		//	exit();
			//$this->set('myvar',var_dump($this->Wizard->read()));
			$session_data = $this->Wizard->read();
			echo var_dump($session_data);
			$this->set('delivery_address', $session_data['address']['Delivery_address']);
			$this->set('order_items', $session_data['basket']);
			
			$item_ids = array();
			
			foreach($session_data['basket'] as $item) {
				array_push($item_ids, $item['id']);
			}
			
			$this->set('products', $this->Product->find('all', array('conditions'=>array('Product.id' => $item_ids))));
			//$this->set('myvar',$session_data);
			//print_r($session_data);
			//exit();
		}
		
		//if($step=='billing') {
		
		//	echo var_dump($this->Delivery_address->data);
		//	exit();
		//}
		//echo var_dump($this->Order->Order_item->data['Order_item']);
		$this->Wizard->process($step);
}

	function saveCheckoutData() {
		$this->Order->set($this->data);
		//set an array of order items
		$this->User->set($this->data);
		
		if ($this->Session->check('basket')) {
			$basket = $this->Session->read('basket');
			$order_items = array();
			
			foreach($basket as $i => $item) {
				array_push($order_items, array('id'=>$basket[$i]['id'], 'quantity'=>$basket[$i]['quantity']));
			}
			
			$this->Order->Order_item->set($order_items);
		}
		else {
			$order_items = array();
		}
		
		$this->User_profile->id = $this->Auth->user('id');
		//$this->set('user_profile', $this->User_profile->data);
		$user_profile = $this->User_profile->data;
		
		//echo var_dump($this->Wizard->read());
		//exit();
		//$this->set('order_items', $order_items);
		//echo var_dump($order_items);
		//echo var_dump($this->Order->Order_item->data['Order_item']);
		//exit();
		//if($this->Client->validates() && $this->User->validates()) {
		if($this->Order->validates()) {
			
				$this->Wizard->save('basket', $order_items);
				$this->Wizard->save('profile', $user_profile);
			//$this->set('order_items', $order_items);
			return true;
		}
		return false;
	}

	//function _processCheckout() {
	
	function _processAddress() {
		
//		$this->Delivery_address->set($this->data);
	//	echo var_dump($this->Delivery_address->data);
	//	echo var_dump($this->Order->Order_item->data);
	//	exit();
		//exit();
		
		//echo var_dump($delivery_address);
		//exit();
	//	$this->set('delivery_address', 'mooooooooooo');
		
		$this->Delivery_address->set($this->data);
		
		//echo var_dump($this->Wizard->read());
		//exit();
		if($this->Delivery_address->validates()) {
		
			$delivery_address = $this->Delivery_address->data;
			$this->Wizard->save('address', $delivery_address);
			//echo $this->delivery_address;
			//exit();
			return true;
		}
		//return true;
		return false;
		//return true;
	}

	function _processBilling() {
	
	//	$billing = $this->Billing->data;
	
		//probs not safe for now!
		
	
		$this->Billing->set($this->data);
		
	//	$billing = $this->Billing->data;
		
		if($this->Billing->validates()) {
		
			$billing = $this->Billing->data;
			$this->Wizard->save('billing', $billing);
			//$this->set('billing', $billing);
			return true;
		}
		return false;
	}

	function _processReview() {
		$email = $this->Wizard->read('account.User.email');
		return true;
	}
	
	function _afterComplete() {
		$wizardData = $this->Wizard->read();
		extract($wizardData);
		
	//	$this->Delivery_address->set($this->data);
		
		$this->Client->save($account['Client'], false, array('first_name', 'last_name', 'phone'));
		$this->User->save($account['User'], false, array('email', 'password'));
		
	}
}
?>