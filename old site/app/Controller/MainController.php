<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
 
class MainController extends AppController {

var $components = array('Email');
//$uses = array('Xml', 'Lib');

public function home() {
	$this->layout = "shop_main";
	$this->set('page_type','home');
}

public function welcome($type="splash") {
	if($type=="splash1") {$type="splash";}
	//$this->set('custom_title', "Main");
	//$this->layout = 'splash';	
	$this->layout = $type;	
	$this->Session->write('mode', 'splash');
	//$this->set('style', $style);
	//echo $style;
	//exit();
}

public function index() {
	//echo "hey";
	//$this->redirect(array("controller"=>"main", "action"=>"welcome"));
	$this->layout = "splash";
	$this->Session->write('mode', 'splash');
	//echo Router::url(array("controller"=>"main", "action"=>"welcome"),true)."</br>";
	//echo $this->webroot;
	//exit();
	//$this->redirect("/main/welcome");
	//echo $this->webroot;
}

public function contact() {

	$this->layout = 'shop_main';
	$this->set('page_type', "contact");
	$this->set('heading', 'Contact us');
	//display page
	
	if($this->request->is('post')) {
	
		//var_dump($this->request);
		$message_subject = $this->request['data']['message_subject'];
		$reply_email_address = $this->request['data']['contact_email_address'];
		$message_body = $this->request['data']['message_body'];
		$message_subject = $this->request['data']['message_subject']." [via Magpiebox.com]";
		$sender_name = $this->request['data']['full_name'];
		
		$headers = 'From: '.$reply_email_address;
		//echo $message_subject." ".$email_address." ".$message_body." ".$message_subject;
		
		//if(mail("efblundell@hotmail.co.uk", $message_subject, $message_body, $headers)) {
		if(mail("management@magpiebox.com", $message_subject, $message_body, $headers)) {
			//echo "success";
		}
		else {
			//echo "fail";
		}
	}
	else {
		//load the form as usual
	}
}

public function blog() {

	//$this->layout = 'ajax';
	$this->layout = 'shop_main';
	$this->set('heading', 'Blog');
	$this->set('page_type', 'main');
	$this->set('custom_title', 'Blog');
	App::uses('Xml', 'Utility'); 
	$parsed_xml = Xml::build('http://efblundell.blogspot.com/feeds/posts/default?alt=rss');
	$parsed_xml = Set::reverse($parsed_xml);
	$this->set('posts', $parsed_xml['rss']['channel']['item']);
	
	//var_dump($parsed_xml);
	//var_dump($blogXml->children[0]->children[0]);
	//connect to the tumblr rss feed
	//then use Blog model to store data (without table).

}

public function find_us() {
	$this->layout = 'shop_main';
	$this->set('page_type', "main");
	$this->set('heading', 'Find us');
	//$this->set('custom_title', "Find our shop");
}

public function meet_the_team() {
	$this->layout = 'shop_main';
	$this->set('page_type', 'meet_the_team');
	$this->set('heading', 'Meet the team');
	
	//$this->set('test', "hi");
}

public function the_shop() {

}

public function validateSignup($address, $encrypted_string) {

		//$address = Security::cipher($encrypted_string, 'hlf#&gg987');
	//if (address is valid email) {
		/*if($encryped_string = crypt($address.'hlf#&gg987')) {
			$this->Email->create();
			$this->Email->set(array('address'=>$address));
			$this->Email->save();
		}*/
		//message for view is "added successfully".
	//}
	//else {
		//message for view is "there was an error"
	
	//}

}

}
