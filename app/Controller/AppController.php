<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	var $pages;
	var $pageTitle;

	public function beforeFilter() {
		$pages = array(
			array(
				'url' => '/home',
				'action' => 'home',
				'title' => 'Welcome'
			),
			/*array(
				'url' => '/products/',
				'action' => 'products',
				'title' => 'Products'
			),*/
			array(
				'url' => '/visit_us',
				'action' => 'visit_us',
				'title' => 'Visit us'
			),
			/*array(
				'url' => '/main/brands',
				'action' => 'brands',
				'title' => 'Brands'
			),*/
			/*array(
				'url' => '/main/meet_the_team',
				'action' => 'meet_the_team',
				'title' => 'Meet the team'
			),*/
			/*array(
				'url' => '/main/blog',
				'action' => 'blog',
				'title' => 'Blog'
			),*/
			array(
				'url' => '/contact_us',
				'action' => 'contact_us',
				'title' => 'Contact us'
			)
		);
		$this->set('pages', $pages);
	}
	
	protected function parseResult($result) {
		if($result instanceof stdClass) {
			return get_object_vars($result);
		}
		else {
			return "undefined error";
		}
	}
	
	public function beforeRender() {
		$this->set('title_for_layout', $this->pageTitle);
	}
}
