<?php class UsersController extends AppController {

var $user; //store the current user
var $uses = array('User','User_profile','User_test');
var $components = array('Auth');

    public function index() {

	   $this->layout = "shop_main";
	   $this->set('page_type', 'account');
    }
	
	public function admin_index() {
	
		$this->layout = "shop_main";
		$this->set('heading', "Admin");
		$this->set('page_type', 'admin');
	}

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
	
        if ($this->request->is('post')) {
            $this->User->create();
			$this->convertPasswords();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
				$this->request->data['User']['original_password'] = '';
				$this->request->data['User']['confirm_password'] = '';
            }
        }
    }
	
	public function register() {
	
		//$this->set('context', $context);
		$this->layout = "shop_main";
		$this->set('page_type', 'account');
		$this->set('heading', 'Register');
	
		if ($this->request->is('post')) {
				//exit();
				$userData = $this->request->data['Register'];
			//	var_dump($userData);
		//		exit();
				$this->User->create();

				$this->User->set(array(
					'username'=>$userData['register_username'],
					'password'=>$userData['register_original_password_hash'],
					'full_name'=>$userData['register_full_name'],
					'role'=>$userData['register_role'],
					'verified'=>false
				));
				
				if($this->User->save()) {
				
					$this->redirect(array("action"=>"confirm", $context));
				
				}

		}
	
	}
	
	public function confirm($context=null) {
	
		//var_dump($this->params);

		$this->layout = "shop";
		$this->set('context', $context);
		
		//$parameters = $this->params['query'];
		$parameters = $this->params['url'];
		if (sizeof($parameters) > 0) {
			$success = true;
			$message = "";
			
			if (in_array("e", array_keys($parameters)) && in_array("k", array_keys($parameters)) && in_array("p", array_keys($parameters))) {
				$email = base64_decode($parameters["e"]);
				$key = base64_decode($parameters["k"]);
				$inProcess = $parameters["p"];
				
				if ($key != substr(md5($email."abcdef"), 20)) {
					$success = false;
					$message = "The email address does not march the corresponding key. Please contact the site admin *here*";
				}
				else {
					//success
					$user = $this->User->find("first", array("conditions"=>array("username"=>$email)));
					//var_dump($user);
					
					$this->Auth->login($user);
					//exit();
					if ($inProcess == 1 && $this->Session->check('basket')) {
						$this->redirect(array("controller"=>"orders", "action"=>"step_1"));
					}
					else if ($inProcess == 1) {
						$message = "Unfortunately the session has expired and your recent shopping history has been lost. We apologise for the inconvenience.";
					}
					else if ($inProcess == 0) {
						//success. just show message (which will be the case as success is true by default)
					}
				}
			}
			else {
				$success = false;
				$message = "The URL does not contain values for all of e,k and p. Please contact the site admin *here*";
			}
			
			//echo $success;
			//exit();
			$this->set('success', $success);
			$this->set('message', $message);
		}
	}

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
		
            throw new MethodNotAllowedException();
			
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
		
            throw new NotFoundException(__('Invalid user'));
        }
		
        if ($this->User->delete()) {
		
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
		
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
		
    }
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(array('register', 'confirm','denied','processAJAXQuery', 'login'));
		
		if($this->Session->check('Auth.User')) {
			$this->set('user', $this->Session->read('Auth.User'));
		}
		//var_dump($this->Session->read('Auth.User'));
		/*if($this->Session->check('Auth.User')) {
			if($this->Session->read('Auth.User')['User']['role'] == "admin") {
				$this->redirect(array('action'=>'admin_index', 'controller'=>'users'));
			}
			else {
				$this->redirect(array('action'=>'index', 'controller'=>'users'));
			}
		}
		else {
			//do nothing
		
		}*/
		//exit();
	}

	public function denied() {
	
		$this->redirect(array('controller' => 'main', 'action' => 'home'));
	
	}
	
	public function login() {

		$this->layout = "shop_main";
		$this->set('page_type', 'account');
		$this->set('heading', 'Login');
		
		if ($this->request->is('post')) {

			$userData = array();
			$userData['User'] = array();
			$userData['User']['username'] = $this->request['data']['Login']['login_username'];
			$userData['User']['password'] = $this->request['data']['Login']['login_password_hash'];

			$user = $this->User->find('first', array("conditions"=>array("username"=>$userData['User']['username'])));
			
			$userData['User']['id'] = $user['User']['id'];

			if($userData['User']['id'] != false) {

				if ($this->Auth->login($userData) == true) {

					$user = $this->User->find('first', array("conditions"=>array("username"=>$userData['User']['username'])));

					$this->Session->write('Auth.User', $user);

					if ($user['User']['role'] == 'admin') {
						$this->redirect(array('controller' => 'users', 'action' => 'admin_index'));
					}
					elseif ($user['User']['role'] == 'customer') {
						$this->redirect(array('controller' => 'users', 'action' => 'index'));
					}
				} else {
					$this->redirect(array('controller' => 'main', 'action' => 'index'));
					$this->Session->setFlash(__('Invalid username or password, try again'));
				}
			}
			else {
				//user does not exist
				$this->redirect(array('controller' => 'main', 'action' => 'index'));
			}
		}
		else {
			//just show the form
		}

	}

	public function logout() {

		if ($this->Auth->logout()) {
				//	$this->Session->setFlash(__('You have been logged out'));
					//$this->redirect(array('controller' => 'products', 'action' => 'index'));
				if(($this->Session->check("context")) && ($this->Session->read("context") == "order")) {
					//do nothing (shows the page)
					$this->Session->delete("context");
				}
				else {
					$this->redirect(array('controller' => 'products', 'action' => 'index'));
				}
		}
		else {
			$this->redirect(array('controller' => 'products', 'action' => 'index'));
			//shouldn't get to this point, perhaps set up an error condition here.
		}
	}
	
	public function processAJAXQuery() {
	
		$this->layout = "ajax";
		//$this->autoRender = false;
		
		$jsonData = json_decode($this->request->query['jsonData'], true);
		$command = $jsonData['command'];
		switch($command) {
			case "check" :
				//echo "hey";
				//exit();
				$this->checkEmail($jsonData['email_address']);
				break;
			case "default" :
				break;
		}
	}
	
	private function checkEmail($email_address) {
	
		//var_dump($jsonData);
		$this->layout = "ajax";
		
		$emails = $this->User->find('all', array('conditions'=>array('username'=>$email_address)));
		if (sizeof($emails) > 0) {
			echo "{ \"response\" : { \"available\" : false }}";
		}
		else {
			echo "{ \"response\" : { \"available\" : true }}";
		}
	}
	
	/*private function convertPasswords() {
	
		if(!empty($this->request->data['User']['original_password'])) {
			$this->request->data['User']['original_password'] = $this->Auth->password($this->request->data['User']['original_password']);
		}
		if(!empty($this->request->data['User']['confirm_password'])) {
			$this->request->data['User']['confirm_password'] = $this->Auth->password($this->request->data['User']['confirm_password']);
		}	
		
	}*/
}	?>