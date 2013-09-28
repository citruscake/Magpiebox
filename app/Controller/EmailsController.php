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
class EmailsController extends AppController {

var $components = array('Email', 'Security'=>array('csrfCheck'=>false,'validatePost'=>false));
//var $components = array('Email');

public function validateSignup($address, $encrypted_string) {

		//$address = Security::cipher($encrypted_string, 'hlf#&gg987');
	//if (address is valid email) {
		if($encryped_string = crypt($address.'hlf#&gg987')) {
			$this->Email->create();
			$this->Email->set(array('address'=>$address));
			$this->Email->save();
		}
		//message for view is "added successfully".
	//}
	//else {
		//message for view is "there was an error"
	
	//}

}

	public function signup() {

		//echo "MOOO";
		//exit();
		//if request
		$address = $this->request['data']['address'];
		//var_dump($this->request['data']);
		//echo $address;
		//exit();
		$this->Email->to = $address;
		$this->Email->sendAs = 'both';
		$this->set('encrypted_string', Security::cipher($address, 'hlf#&gg987'));
		//echo intval(Security::cipher($address, 'hlf#&gg987'));
		//exit();
		$this->set('encrypted_string', crypt($address.'hlf#&gg987'));
		$this->set('address', $address);
		$this->Email->from = "no-reply@magpiebox.co.uk";
		$this->Email->subject = "Confirm sign up to email list";
		$this->Email->template = "signup_email";
		$this->Email->send();
		//else do nothing.
		//echo "moo";
}

}
