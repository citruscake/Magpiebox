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
App::uses('Xml', 'Utility'); 
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

	public function beforeFilter() {
		parent::beforeFilter();
		$this->layout = "main";
	}
	
	public function home() {

	}

	public function brands() {
		$this->layout = "main";
		$contents = file_get_contents('json/brands.json');
		$json = json_decode($contents,true);
		//var_dump($json);
		$this->set("brands", $json['brands']);
		//get xml
		//paste it all
	
	}

	public function index() {
	
		$this->redirect("/main/home");
	
	}

public function contact() {

	$this->layout = 'main';
	
	if($this->request->is('post')) {
	
		$message_subject = $this->request['data']['message_subject'];
		$reply_email_address = $this->request['data']['contact_email_address'];
		$message_body = $this->request['data']['message_body'];
		$message_subject = $this->request['data']['message_subject']." [via Magpiebox.com]";
		$sender_name = $this->request['data']['full_name'];
		
		$headers = 'From: '.$reply_email_address;

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

	$this->layout = 'main';
	$parsed_xml = Xml::build('http://magpieboxstratford.blogspot.com/feeds/posts/default?alt=rss');
	$parsed_xml = Set::reverse($parsed_xml);

	$lowerBound = 0;
	$upperBound = 5;
	
	$blog_posts_xml = array_slice($parsed_xml['rss']['channel']['item'], $lowerBound, $upperBound);
	$posts = array();
	foreach($blog_posts_xml as $blog_post_xml) {
		$post = array();
		$post['title'] = $blog_post_xml['title'];
		$post['description'] = $blog_post_xml['description'];
		$post['pubDate'] = $blog_post_xml['pubDate'];
		$post['author'] = $blog_post_xml['author'];
		array_push($posts, $post);
	}
	$this->set('posts', $posts);
}

public function find_us() {
	$this->layout = 'main';
}

public function meet_the_team() {
}

public function the_shop() {

}

}
