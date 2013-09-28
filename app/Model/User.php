<?php class User extends AppModel {
	public $validate = array(
		'username' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A username is required'
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please enter an email address'
			)
		),
		'original_password' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'A password is required'
			),
			'identicalFieldValues' => array(
				'rule' => array('identicalFieldValues', 'confirm_password'),
				'message' => 'Please enter in identical passwords'
			)
		),
		'role' => array(
			'valid' => array(
				'rule' => array('inlist', array('admin', 'customer')),
				'message' => 'Please enter a valid role',
				'allowEmpty' => false
			)
		)
	);
	
	/*public function beforeSave($options = array()) {
		if (!isset($this->data['User']['password'])) {
			//$this->data['User']['password'] = AuthComponent::password($this->data[$this->alias]['password']);
			$this->data['User']['password'] = $this->data['User']['original_password'];
		}
		//$this->setNewPassword();
		return true;
	}*/

	/*private function setNewPassword() {
		$this->data['User']['password'] = $this->data['User']['original_password'];
		return true;
	}*/
	
	/*function identicalFieldValues($field=array(), $compare_field=null) {
	
		foreach( $field as $key => $value) {
			$v1 = $value;
			$v2 = $this->data[$this->name][$compare_field];
			//echo $v1." ".$v2;
			//exit();
			if($v1 != $v2) {
				return false;
			}
			else {
				continue;
			}
		}
		return true;
	}*/
}
?>