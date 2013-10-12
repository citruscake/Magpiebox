<?php

class AddressesController extends AppController {

var $uses = array('Address','Default_delivery_address', 'User');
var $components = array('Auth');

public function add() {
	$this->layout = "shop";

	if($this->request->is('post')) {

		$this->Address->create();
		$user = $this->Session->read('Auth.User');
		//var_dump($user);
		//exit();
		$this->Address->set('user_id', $user['User']['id']);
		//$this->Address->set($this->request->data);
		if ($this->Address->save($this->request->data)) {
			$this->Session->setFlash(__('The address has been saved'));
		}
		else {
			$this->Session->setFlash(__('The address could not be saved'));
		}
		if($this->Session->check("context") && ($this->Session->read("context") == "order")) {
			$this->redirect(array('controller'=>'orders', 'action' => 'step_1'));
		}
		else {
			$this->redirect(array('controller'=>'addresses', 'action' => 'index'));
		}
	}	
}

public function edit($address_id=null) {
	$this->layout = "shop";

	if($this->request->is('post')) {
		
		//$this->Address->address_id = $this->request->data['address_id'];
		$this->Address->id = base64_decode($this->request->data['Address']['address_id']); //hidden field
		//echo base64_decode($this->request->data['Address']['address_id']); 
		//exit();
		foreach($this->request->data['Address'] as $field=>$value) {
			if($field != "address_id") {
				$this->Address->set($field, $value);
			}
		}
		//$this->Address->set($this->request->data['Address']);
		//$user = $this->Session->read('Auth.User');
		//$this->Address->set('user_id', $user['User']['id']);
		
		//if($this->Address->save($this->request->data['Address'])) {
		if($this->Address->save()) {
			$this->Session->setFlash(__('The address has been edited successfully'));
			//$this->redirect(array('action' => 'index'));		
			if($this->Session->check("context") && ($this->Session->read("context") == "order")) {
				$this->redirect(array('controller'=>'orders', 'action' => 'step_1'));
			}
			else {
				$this->redirect(array('controller'=>'addresses', 'action' => 'index'));
			}
		}
		else {
			$this->Session->setFlash(__('The address has not been edited successfully'));
			//$this->redirect(array('action' => 'index'));
		}
	}
	else {
	//	$this->Address->id = 1;
		$this->Address->id = base64_decode($address_id);
		//$address = $this->Address->find('first', array('conditions'=>array('address_id'=>$address_id)));
		$this->Address->read();
		//var_dump($this->Address->read()['Address']);
		//exit();
		$this->set('address', $this->Address->data);
	}
}

public function delete($address_id) {

		if ($this->Address->delete(base64_decode($address_id))) {
			$this->Session->setFlash(__('The address has been deleted successfully'));
			//$this->redirect(array('action' => 'index'));
		}
		else {
			$this->Session->setFlash(__('The address has not been deleted successfully'));
			//$this->redirect(array('action' => 'index'));
		}
		
		if($this->Session->check("context") && ($this->Session->read("context") == "order")) {
			$this->redirect(array('controller'=>'orders', 'action' => 'step_1'));
		}
		else {
			$this->redirect(array('controller'=>'addresses', 'action' => 'index'));
		}
}

public function index() {
	$this->layout = "shop";

	$user = $this->Auth->user();
	$addresses = $this->Address->find('all', array('conditions'=>array('user_id'=>$user['User']['id'])));
	//var_dump($this->Auth->user());
	$this->set('addresses', $addresses);
}

/*public function setDefaultBillingAddress($address_id) {
	if($this->request->is('post')) {

		$this->Default_Billing_Address->create();
		$this->Default_Billing_Address->set('user_id', $this->Auth->user('id'));
		$this->Default_Billing_Address->set('address_id', $address_id);
		$this->Default_Billing_Address->set($this->request->data);
		if ($this->UserProfile->save()) {
			$this->Session->setFlash(__('The default billing address has been saved'));
		}
		else {
			$this->Session->setFlash(__('The address could not be saved'));
		}
		//$this->redirect(array('action' => 'index'));
	}	
	else {
		$this->redirect(array('action' => 'index'));
	}
}*/

public function setDefaultDeliveryAddress($address_id) {
	if($this->request->is('post')) {

		$this->Default_Delivery_Address->create();
		$this->Default_Delivery_Address->set('user_id', $this->Auth->user('id'));
		$this->Default_Delivery_Address->set('address_id', $address_id);
		$this->Default_Delivery_Address->set($this->request->data);
		if ($this->UserProfile->save()) {
			$this->Session->setFlash(__('The default delivery address has been saved'));
		}
		else {
			$this->Session->setFlash(__('The address could not be saved'));
		}
		//$this->redirect(array('action' => 'index'));
	}	
	else {
		$this->redirect(array('action' => 'index'));
	}
}

	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow(array('add'));
		$this->Auth->deny('*');
	}




}


?>