<?php

class OrdersController extends AppController {

	var $uses = array("Order", "Address", "Order_item", "Product", "Order_address");
	var $components = array('Auth');

	public function login() {
		$this->layout = "shop_main";
		$this->set('page_type', 'order');
		$this->Session->write("context", "order");
		$this->Session->write("checkout_progress","login");
		
		if($this->Session->check('Auth.User')) {
			$this->redirect(array("controller"=>"orders", "action"=>"step_1"));
		}
	}
	
	public function step_1() {

		$this->layout = "shop_main";
		//$this->set('page_type', "order");
		
		if($this->Session->check("checkout_progress")) {
			if($this->Session->read("checkout_progress") == "login") {
				$this->Session->write("checkout_progress","step_1");
			//	echo $this->Session->read("checkout_progress");
			}
		}
		else {
			//If the session has expired, this is handled by the beforefilter.
		
		}
		
		if($this->Session->check("Auth.User")) {
			$user = $this->Session->read("Auth.User");
			$addresses = $this->Address->find('all', array("conditions"=>array("user_id"=>$user['User']['id'])));
			$this->set("addresses", $addresses);
		}
		
	}
	
	function step_2($address_id=null) {
		
		$this->layout = "shop_main";

		if($this->Session->check("checkout_progress")) {
			if($this->Session->read("checkout_progress") == "step_1") {
				$this->Session->write("checkout_progress","step_2");
			}
		}
		
		if($this->request->isPost()) {

			$address = $this->request['data'];
			$this->Session->write('address', $address);

		}
		else if($this->Session->check('Auth.User')) {
				$addressId = base64_decode($address_id);
				$this->Session->write('address_id', $addressId);
		}
		else {
			$this->redirect(array("controller"=>"orders", "action"=>"step_1"));
		}
		//(take all of the form info and put in session)
		//all the billing stuff or whatever
		//enter in password and....
	
	}
	
	function step_3() {
	
		$this->layout = "shop_main";
		if($this->Session->check("checkout_progress")) {
			if($this->Session->read("checkout_progress") == "step_2") {
				$this->Session->write("checkout_progress","step_3");
			//	echo $this->Session->read("checkout_progress");
			}
		}

		if($this->request->isPost()) {
			$billing = $this->request['data'];
			$this->Session->write('billing', $billing);
			
			if($this->Session->check('Auth.User')) {
				$address = $this->Address->find('first', array("conditions"=>array("address_id"=>$this->Session->read('address_id'))));
				$this->set('address', $address);
			}
			else {
				$this->set('address', $this->Session->read('address'));
			}
			
			$this->set('billing', $billing);
			$this->set('basket', $this->Session->read('basket'));
			
		}
		else { //should have already posted
			if($this->Session->check('Auth.User')) {
				$address = $this->Address->find('first', array("conditions"=>array("address_id"=>$this->Session->read('address_id'))));
				$this->set('address', $address);
			}
			else {
				$this->set('address', $this->Session->read('address'));
			}
			$this->set('billing', $this->Session->read('billing'));
			$this->set('basket', $this->Session->read('basket'));
			//echo "Please go back and resubmit the form";
		}
	}
	
	function process_order() {
	
		$this->autoRender = false;
		if($this->Session->check("checkout_progress")) {
			if($this->Session->read("checkout_progress") == "step_3") {
				$this->Session->write("checkout_progress","process_order");
			//	echo $this->Session->read("checkout_progress");
			}
		}
		
		$billingInformation = $this->Session->read('billing');
		$basket = $this->Session->read('basket');
	
		$this->Order_address->create();
	
		if($this->Session->check('Auth.User')) { //logged in user
			
			$address = $this->Address->find('first', array("conditions"=>array("address_id"=>$this->Session->read('address_id'))));
			foreach($address['Address'] as $field=>$value) {
				$this->Order_address->set($field, $value);
			}
		
		}
		else { //one time visitor
					
			$address =  $this->Session->read('address');
			$this->Order_address->set(
				array('full_name'=>$address['first_name']." ".$address['last_name'],
				'address_1'=>$address['address_1'],
				'address_2'=>$address['address_2'],
				'city'=>$address['city'],
				'county'=>$address['county'],
				'country'=>$address['country'],
				'state'=>$address['state'],
				'post_code'=>$address['post_code'],
				'contact_number'=>$address['contact_number']
				)
			);
		}
		
		$this->Order_address->save();
	
		$customer_ref = substr(md5(time()),20);
	
		$this->Order->create();
		$this->Order->set('customer_ref', $customer_ref);
		$this->Order->set(array(
			'status'=>'ordered',
			'billing_id'=>1,
			'delivery_id'=>$this->Order_address->getInsertID(),
		));
		
		if($this->Session->check('Auth.User')) {
			$user = $this->Session->read('Auth.User');
			$this->Order->set('user_id', $user['User']['id']);
		}
		else {
			$this->Order->set('user_id', -1); //anonymous id
		}
	
		$this->Order->save();
		
		foreach($basket as $i=>$itemData) {
		
			$product = $this->Product->find('first', array('conditions'=>array('product_id'=>$itemData['product_id'])));
		
			$this->Order_item->create();
			$this->Order_item->set(
				array(
					"order_id"=>$this->Order->getInsertID(),
					"product_id"=>$itemData['product_id'],
					"quantity"=>$itemData['quantity'],
					"price"=>$product['Product']['price']
				)
			);
			$this->Order_item->save();
		}

		$this->Session->delete("basket");
		$this->Session->delete("total");
		
		$this->redirect(array("action"=>"order_confirm", $customer_ref));
	
	}
	
	public function order_confirm($customer_ref) {
		
		$this->layout = "shop";
		if($this->Session->check("checkout_progress")) {
			if($this->Session->read("checkout_progress") == "process_order") {
				$this->Session->write("checkout_progress","order_confirm");
			}
		}
		$this->set('customer_ref', $customer_ref);
		$this->Session->delete("context");
		
		
		//Here is a thank you and a reference number. "you've been sent an email receipt"
		//"would you like to sign up and keep a record?"

	}
	
	public function index() {
		$user = $this->Session->read('Auth.User');
		if($user['User']['role'] == "customer") {
			$orders = $this->Order->find('all', array("conditions"=>array("user_id"=>$user['User']['id']), "order"=>array("created DESC")));
			$this->set("orders",$orders);
			//var_dump($orders);
		}
	}
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		
		$this->Auth->allow();
		
		$this->set("page_type", "order");
		//$this->Session->delete("checkout_progress");
		//		exit();
		/*$this->Auth->deny('*');
		$this->Auth->unauthorisedRedirect = array("controller"=>"users","action"=>"logout");
		$this->Auth->logoutRedirect = array("controller"=>"users","action"=>"logout");*/
		
		//if($this->Session->check('checkout_progress')) { //therefore process has started
		
			//$progress = $this->Session->read('checkout_progress');
		
			/*if($this->referer() = )) {
				$this->Auth->allow(array("step_1"));
			}*/
		
			$checkout_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"baskets", "action"=>"index")));
			$login_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"orders", "action"=>"login")));
			$process_order_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"orders", "action"=>"process_order")));
			$step_1_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"orders", "action"=>"step_1")));
			$step_2_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"orders", "action"=>"step_2")));
			$step_3_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"orders", "action"=>"step_3")));
			$address_add_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"addresses", "action"=>"add")));
			$address_edit_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"addresses", "action"=>"edit")));
			$address_delete_link = strtolower(substr(Router::url('/', true), 0, -1).Router::url(array("controller"=>"addresses", "action"=>"delete")));
		
			/*echo $this->referer();
			//echo "</br>".$checkout_link;
			echo " moo ".$login_link;
			exit();*/
			$redirect = false;
			$referer = strtolower($this->referer());
			$current = strtolower(Router::url($this->here, true));
			//FOR LOGIN
			 //here we are refreshing the page
				//$this->Session->delete("checkout_progress");
				//exit();
				//echo $current;
				//echo $login_link;
				//exit();
				
				if($current == $login_link) {
					//echo "HEEYY";
					//exit();
					if($this->Session->check("checkout_progress")) {
						if($this->Session->read("checkout_progress") == "login" && $referer == $login_link) {
							//fine
						//	echo "here?!";
						//	exit();
						}
						else {
						//	echo "moohere?!";
						//	exit();
							$redirect = true;
						}
					}
					else if ($referer == $checkout_link || $referer == $checkout_link."/index") {
						//echo "should be true?";
						//exit();
						//fine
					}
					else {
						//echo "here";
						//exit();
						//There is no order process and the referrer is not the basket...
						$redirect = true;
					}
				}
				else if ($current == $step_1_link) {
				
			//	echo $this->referer();
			//echo "</br>".$checkout_link;
			//echo " moo ".$login_link;
			//exit();
				
					//echo substr($referer, 0, strrpos($referer,'/'));
				
					if($this->Session->check("checkout_progress")) {
						if($this->Session->read("checkout_progress") == "login" && ($referer == $login_link || ($this->Session->check('Auth.User') && $referer == $checkout_link))) {
							//fine
						}
						else if($this->Session->read("checkout_progress") == "step_1" && (($referer == $step_1_link) || ($referer == $address_add_link) || ($address_edit_link == substr($referer, 0, strrpos($referer,'/'))) || ($address_delete_link == substr($referer, 0, strrpos($referer,'/'))) || ($referer == "/"))) {
							//fine as it is referring to itself
						}
						else if($this->Session->read("checkout_progress") == "step_2" && (($referer == $step_1_link) || ($referer == $step_2_link) || ($referer == $address_add_link) || ($address_edit_link == substr($referer, 0, strrpos($referer,'/'))) || ($address_delete_link == substr($referer, 0, strrpos($referer,'/'))) || ($referer == "/"))) {
							//fine as step 2 has been visited already
						}
						else if($this->Session->read("checkout_progress") == "step_3" && (($referer == $step_1_link) || ($referer == $step_2_link)|| ($referer == $step_3_link) || ($referer == $address_add_link) || ($address_edit_link == substr($referer, 0, strrpos($referer,'/'))) || ($address_delete_link == substr($referer, 0, strrpos($referer,'/'))) || ($referer == "/"))) {
							//fine as step 3 has been visited already, so we can get here from either steps 2 or 3.
						}
						else {
						//	echo "here";
						//	echo $this->Session->read("checkout_progress");
						//	echo $referer;
						//	echo $step_2_link;
						//	exit();
							$redirect = true;
						}
					}
					else {
							//The step can only be visited in the context of an order (i.e. the checkout_progress session var. has already been
							//set by the login step
							//echo "here2";
						//	exit();
							$redirect = true;
					}
				}
				else if ($current == $step_2_link) {
					if($this->Session->check("checkout_progress")) {
						/*if($this->Session->read("checkout_progress") == "login" && $referer == $login_link) {
							//fine
						}*/
						if($this->Session->read("checkout_progress") == "step_1" && $referer == $step_1_link) {
							//fine as it is the next step from step_1.
						}
						else if($this->Session->read("checkout_progress") == "step_2" && (($referer == $step_1_link) || ($referer == $step_2_link) || ($referer == "/"))) {
							//fine as step 2 has been visited already (i.e. referring to itself). Also, can return from step 1 after visiting previously.
						}
						else if($this->Session->read("checkout_progress") == "step_3" && (($referer == $step_1_link) || ($referer == $step_2_link)|| ($referer == $step_3_link) || ($referer == "/"))) {
							//fine as step 3 has been visited already, so we can get here from either steps 2 or 3. Also, step 2 can refer to itself.
							//If step 1 has been revisited, and step 3 has been visited, we can still get back to step 2.
						}
						else {
							$redirect = true;
						}
					}
					else {
							//The step can only be visited in the context of an order (i.e. the checkout_progress session var. has already been
							//set by the login step.
							$redirect = true;
					}
				}
				else if($current == $step_3_link) {
				
					//echo $this->Session->read("checkout_progress");
					//echo substr($referer, 0, strrpos($referer,'/'));
					//echo $step_2_link;
					//exit();
				
					if($this->Session->check("checkout_progress")) {
						if($this->Session->read("checkout_progress") == "step_2" && (($referer == $step_1_link) || ($referer == $step_2_link) || ($step_2_link == substr($referer, 0, strrpos($referer,'/'))))) {
							//fine as we want to transition as usual from step_2.
						}
						else if($this->Session->read("checkout_progress") == "step_3" && (($referer == $step_1_link) || ($referer == $step_2_link)|| ($referer == $step_3_link) || ($referer == "/"))) {
							//fine as step 3 can be visited by itself, or any of the previous steps when the progress is at step_3.
						}
						else if($this->Session->read("checkout_progress") == "step_3" && ($referrer == $process_order_link)) {
							//fine as this is only because process_order_link was accessed from step_1 or step_2.
						}
						else {
							$redirect = true;
						}
					}
					else {
							//The step can only be visited in the context of an order (i.e. the checkout_progress session var. has already been
							//set by the login step.
							$redirect = true;
					}
				}
				else if($current == $process_order_link) {
					if($this->Session->check("checkout_progress")) {
						if($this->Session->read("checkout_progress") == "step_3" && ($referer == $step_3_link)) {
							//fine as step 3 should be the predecessor.
						}
						else if($this->Session->read("checkout_progress") == "step_3" && (($referer == $step_1_link) || ($referer == $step_2_link))) {
							//Should really only call this from step_3.
							$this->redirect(array("controller"=>"orders", "action"=>"step_3"));
						}
						else {
							$redirect = true;
						}
					}
					else {
							//The step can only be visited in the context of an order (i.e. the checkout_progress session var. has already been
							//set by the login step.
							$redirect = true;
					}
				}
							
				if($redirect == true) {
					$this->redirect(array("controller"=>"baskets", "action"=>"index"));
				}
			
			//
			/*switch($this->referer()) {
				case $process_order_link:
					$this->Session->delete('checkout_progress');
					break;
				case $step_3_link:
					$this->Auth->allow(array("process_order"));
					break;
				case $step_2_link:
					$this->Auth->allow(array("step_3"));
					//$this->allow(array("step_2"));
					//$this->allow(array("step_1"));
				case $step_1_link:
					$this->Auth->allow(array("step_2"));
					//$this->allow(array("step_1"));
				case $login_link:
					$this->Auth->allow(array("step_1"));
					break;
				default:
					$this->Auth->allow(array('login'));
					break;
			}*/
			
			/*if($referer == $process_order_link) {
				$this->Session->delete('checkout_progress');
			}
			else if($referer == $step_3_link) {
				$this->Auth->allow(array("process_order"));
			}
			else if($referer == $step_2_link) {
				echo "here 3";
				$this->Auth->allow(array("step_3"));
				$this->Auth->allow(array("step_2"));
				$this->Auth->allow(array("step_1"));
			}
			else if ($referer == $step_1_link) {
				echo "allowing 2";
				$this->Auth->allow(array("step_2"));
				$this->Auth->allow(array("step_1"));
			}
			else if ($referer == $login_link) {
				echo "IT IS EQUAL SURELY?";
				$this->Auth->allow(array("step_1"));
			}
			else {
				$this->Auth->allow(array('login'));
			}*/
		}
		/*else {
		
			$this->Auth->allow(array('login'));
		
		}*/
}

?>