<?php

App::uses('AppController', 'Controller');

class ProductsController extends AppController {

	//App::uses('AppController', 'Controller');

	var $helpers = array('Form','Html','Session');
	//var $components = array('wizard');
	var $uses = array('Product', 'Category', 'Basket', 'DailyItem');
	var $validateFile = array(
						'size' => 204800,
						'type' => array('image/jpg','image/jpeg','image/png','image/gif')
						);
	var $fileData;
	//var $excludedColumns = array('created', 'modified', 'image_url', 'thumbnail_url');
							
	public function view($id = null) {
			$this->layout = "shop_main";
			$this->set('page_type', 'shop');
			$this->set('heading', '');
			
			if($this->Session->check('last_search')) {
		
				$this->set("last_search", true);
		
			}
			
			if($this->Session->check('basket')) {
			
				$this->set("basket", $this->Session->read('basket'));
			
			}
			
			if (isset($id)) {
			
				$this->Product->id = $id;
				$product = $this->Product->read();
				$this->set('product', $product['Product']);
				$this->set('custom_title',$product['Product']['name']);
				$this->Category->id = $product['Product']['category_id'];
				//var_dump($this->Category);
				$category = $this->Category->read();
				$this->set('category', $category ['Category']);
				$this->set('breadcrumb_depth',3);
			}

			if(isset($this->params['requested'])) {
			
				$products = $this->Product->find('all');
				return $products;
				
			}
			
			//$this->set('categories', $this->Category->getCategories());

	}
	
	public function admin_add() {
	
		if($this->request->is('post')) {
	
		$fileData = $this->request->data['Product_image']['File'];
			
			if(is_uploaded_file($fileData['tmp_name'])) {
			
				if($fileData['size'] > $this->validateFile['size'] || $fileData['error'] == UPLOAD_ERR_INI_SIZE) {
				
					$this->Session->setFlash(__('The file size is too big'));
					unlink($fileData['tmp_name']);
					
				}
				else if(!in_array($fileData['type'],$this->validateFile['type'])) {
				
					$this->Session->setFlash(__('The file is not of the format .jpg, .jpeg, .png or .gif'));
					unlink($fileData['tmp_name']);
					
				}
				else {

					move_uploaded_file($fileData['tmp_name'], WWW_ROOT.'img/product_images/'.$fileData['name']);

					$this->Product->create();
					$this->Product->set(array(
					'category_id' => 1,
					'image_url' => 'product_images/'.$fileData['name'],
					'thumbnail_url' => 'product_images/'.$fileData['name']));
					$this->Product->save($this->request->data);
					$this->Session->setFlash(__('Image uploaded successfully'));
				}
			}
			else {
				$this->Session->setFlash(__('Image did not upload successfully'));
			}
		}	
	}
	
	public function admin_index() {
		$this->layout = "shop_main";
		$this->set('page_type', 'admin');
		$this->set('heading', 'Manage Products');
		
		$categories = $this->Category->find('all');
		$this->set("categories", $categories);
		//echo array_diff(array_keys($this->Product->getColumnTypes()), $excludedColumns);
		$excludedColumns = array('product_id','created', 'modified', 'image_url', 'thumbnail_url', 'category_id', 'primary_image', 'secondary_images');
		$fields = array_diff(array_keys($this->Product->getColumnTypes()), $excludedColumns);
		//array_push($fields, "Category");
		$this->set('fields', $fields);
		
		//$this->set('columns', "me");
		//$products = $this->Product->find('all');
		//$this->set('products', $products);
	}
	
	public function admin_preview() {
	
	if($this->request->is('post')) {
	
			if($this->request->data['submit'] == 'Preview') {
				
				$product = $this->request->data['Product'];
				$product_image = $this->request->data['Product_image'];
				$product_thumbnail = $this->request->data['Product_thumbnail'];
				$id = $product['id'];

				$fileData = $product_image['File'];
				
				if($fileData['size']>0) {
				
					if($this->uploadFile($fileData, 'temp_images', 'normal')) {
					
						$product['image_url'] = '/img/temp_images/'.$fileData['name'];
					}
					
				}
				
				$fileData = $product_thumbnail['File'];
				if($fileData['size']>0) {
				
					if($this->uploadFile($fileData, 'temp_images', 'thumbnail')) {
					
						$product['thumbnail_url'] = '/img/temp_images/thumb_'.$fileData['name'];
						
					}
					
				}
				
				$this->set('product', $product);
				$this->Session->write("Products.admin_edit.$id", $product);
				
			}
			else if($this->request->data['submit'] == 'Save') {

				$id = $this->request->data['Product']['id'];
				$this->Product->create();
				$this->Product->id = $id;

				if($this->Product->save($this->request->data['Product'])) {
				
					$this->Session->setFlash(__('Record updated successfully'));
					$this->Session->delete("Products.admin_edit.$id");
					$this->redirect(array('action' => 'admin_view',$id));
					
				}
			}
	}
	}
	
	public function admin_edit($id=null) {
	
	if($this->Session->check("Products.admin_edit.$id")) {
	
		$product = $this->Session->read("Products.admin_edit.$id");
		$this->set('product', $product);
		
	}
		else if(isset($id)){
		
			$this->Product->id = $id;
			$this->set('product', $this->Product->read());
			
		}	
	}
	
	public function process_admin_edit() {

		if($this->request->data['submit'] = 'preview') {
			
		
		
		}
		$product = $this->request->data['Product'];
	
	
	
		$this->redirect(array('controller' => 'products', 'action' => 'admin_view'));
	}

	private function uploadFile($fileData, $folder, $imageRole) {
	
		if(is_uploaded_file($fileData['tmp_name'])) {
		
				if($fileData['size'] > $this->validateFile['size'] || $fileData['error'] == UPLOAD_ERR_INI_SIZE) {
				
					$this->Session->setFlash(__('The file size is too big'));
					unlink($fileData['tmp_name']);
					
				}
				else if(!in_array($fileData['type'],$this->validateFile['type'])) {
				
					$this->Session->setFlash(__('The file is not of the format .jpg, .jpeg, .png or .gif'));
					unlink($fileData['tmp_name']);
					
				}
				else {

					if($imageRole == 'thumbnail') {
					
						move_uploaded_file($fileData['tmp_name'], WWW_ROOT.'img/'.$folder.'/thumb_'.$fileData['name']);
					}
					
					else {
					
						move_uploaded_file($fileData['tmp_name'], WWW_ROOT.'img/'.$folder.'/'.$fileData['name']);
						
					}
					
					$this->Product->create();
					$this->Product->set(array(
					'category_id' => 1,
					'image_url' => 'product_images/'.$fileData['name'],
					'thumbnail_url' => 'product_images/'.$fileData['name']));
					$this->Product->save($this->request->data);

					$this->Session->setFlash(__('Image uploaded successfully'));
					return true;
					
				}
				
				
			}
			else {
				$this->Session->setFlash(__('Image did not upload successfully'));
				return false;
			}
		}

	
	
	public function process_admin_add() {
		
		if($this->request->is('post')) {
		
			$fileData = $this->request->data['Product_image']['File'];
			
			if(is_uploaded_file($fileData['tmp_name'])) {
			
				if($fileData['size'] > $this->validateFile['size'] || $fileData['error'] == UPLOAD_ERR_INI_SIZE) {
				
					$this->Session->setFlash(__('The file size is too big'));
					unlink($fileData['tmp_name']);
					
				}
				else if(!in_array($fileData['type'],$this->validateFile['type'])) {
				
					$this->Session->setFlash(__('The file is not of the format .jpg, .jpeg, .png or .gif'));
					unlink($fileData['tmp_name']);
					
				}
				else {

					move_uploaded_file($fileData['tmp_name'], WWW_ROOT.'img/product_images/'.$fileData['name']);

					$this->Product->create();
					$this->Product->set(array(
					'category_id' => 1,
					'image_url' => 'product_images/'.$fileData['name'],
					'thumbnail_url' => 'product_images/'.$fileData['name']));
					$this->Product->save($this->request->data);
					$this->Session->setFlash(__('Image uploaded successfully'));
				}
			}
			else {
				$this->Session->setFlash(__('Image did not upload successfully'));
			}
		}
	}
	
	public function index($category_id=null,$page=null) {

		$this->layout = "main";
		
		$this->set('breadcrumb_depth',1);

		//$client = new SoapClient('http://'.env('HTTP_HOST').'/magento/api/v2_soap?wsdl=1');
		$client = new SoapClient('http://www.magpiebox.com/magento/api/v2_soap?wsdl=1');
		//$client = new SoapClient('http://127.0.0.1/magento/api/v2_soap?wsdl=1');
		//api key mm50E7Df44cg746thu8!&*V2cGr9Ca
		$sessionId = $client->login('magpiebox', 'mm50E7Df44cg746thu8!&*V2cGr9Ca');
		//$result = $client->call($session, 'catelog_category.tree');
		$results = $client->catalogProductList($sessionId);
		//$products = get_object_vars($result);
		$item = parent::parseResult($results[1]);
		$inventory = $client->catalogInventoryStockItemList($sessionId, array($item['product_id']));
		//echo parent::parseResult($inventory[0])['qty'];
		
		foreach($results as $result) {
			$item = parent::parseResult($result);
			//echo $item['product_id'];
			//$inventory = $client->catalogInventoryStockItemList($sessionId, $item['product_id']);
			//$inventory = $client->catalogInventoryStockItemList($sessionId , array($item['product_id']));
			//echo $inventory['qty'];
			//var_dump($item);
			echo $item['name'];
			echo "</br>";
		}
		//foreach($result as $item) {
		//	echo $item['name']."</br>";
		//}
		
		/*if($this->Session->check('searches')) {
		
			$this->set("current_query", true);
		
		}
		
		if (isset($category_id)) {
		
			$this->set('breadcrumb_depth',2);
			$products = $this->Product->find('all', array('conditions' => array('Product.category_id' => $category_id)));
			$this->set('products', $products);
			$this->Category->id = $category_id;
			$category = $this->Category->read();
			$this->set('category', $category['Category']);
			
		}
		else {

			$products = $this->Product->find('all', array('order' => array('Product.created DESC')));
			$this->set('products', $products);
			$this->set('category', array("Category"=>array("name"=>"All items")));
		}
		
		$this->set('categories', $this->getCategories());
		*/
		
	}
	
	private function parseCategories($tree) {
	
		$parsedTree = parent::parseResult($tree);
		foreach($parsedTree['children'] as &$node) {
			$node = $this->parseCategories($node);
		}
		return array_diff_key($parsedTree, array('parent_id', 'position', 'is_active'));
		
	}
	
	
	public function getCategories() {
	
		$excludedKeys = array();
	
		$client = new SoapClient('http://www.magpiebox.com/magento/api/v2_soap?wsdl=1');
		$sessionId = $client->login('magpiebox', 'mm50E7Df44cg746thu8!&*V2cGr9Ca');
		$categoryTree = $client->catalogCategoryTree($sessionId);
		$categories = $this->parseCategories($categoryTree);
		var_dump($categories);
		
	}
	
	public function getDailyProduct() {
	
		if(isset($this->params['requested'])) {
			
			$daily_item_data = $this->DailyItem->find('first');
			if(!$daily_item_data) {
				//echo "setting date";
				$selectionTimeStamp = strtotime('2013-1-1 00:00:00'); //i.e. 2013
				$selectionDate = date('Y-d-m', $selectionTimeStamp);
				$selectionDateTime = date('Y-d-m H:i:s', $selectionTimeStamp);
			}
			else {
				$selectionTimeStamp = $daily_item_data['DailyItem']['selection_time'];
				$selectionDate = date('Y-d-m', $selectionTimeStamp);
				$selectionDateTime = date('Y-d-m H:i:s', $selectionTimeStamp);
			}
			
			$currentTimeStamp = time();
			$currentDateTime = date('Y-d-m H:i:s', $currentTimeStamp);
			$currentDate = date('Y-d-m',$currentTimeStamp);
			
			//echo date('Y-d-m H:i:s',$currentTimeStamp);
			////	echo date('Y-d-m H:i:s',$selectionTimeStamp);
			//	echo "</BR>".date('H',($currentTimeStamp - $selectionTimeStamp))."</br>";
			//if((($currentDate) > $selectionDate)) {//need to update
			
			//echo $selectionDateTime;
			//echo $selectionDate;
			//echo $currentTimeStamp;
			//$str = strtotime('2013-06-10 23:59:00');
			//echo "</br></br>";
			//echo date('d',($currentTimeStamp - $str));
			//exit();
			
			if(date('d',($currentTimeStamp - $selectionTimeStamp)) >= 2) {
				
				return $this->generateNewDailyProduct($currentTimeStamp);

			}
			else if($daily_item_data) {
				
				$product = $this->Product->find('first', array('fields'=>array('quantity'), 'conditions'=>array('product_id'=>$daily_item_data['DailyItem']['product_id'])));
				//var_dump($product);
				if($product['Product']['quantity'] > 0) {
					$product = $this->Product->find('first', array('conditions'=>array('product_id'=>$daily_item_data['DailyItem']['product_id'])));
					return $product;
				}
				else {
					return $this->generateNewDailyProduct($currentTimeStamp);
				}
				
			}
		}
	}
	
	private function generateNewDailyProduct($currentTimeStamp) {
	
		srand(time());
		$randomDateTime = date('Y-m-d H:i:s',rand(strtotime('2013/1/1 00:00:00'), $currentTimeStamp));
			
		$product = $this->Product->find('first', array('fields'=>'product_id', 'conditions'=>array('quantity' > 0), 'order'=>array('ABS( DATEDIFF(created, \''.$randomDateTime.'\' )) ASC')));
		//var_dump($product);
		echo $randomDateTime;
		//exit();
		$product_id = $product['Product']['product_id'];
		$daily_item_data = $this->DailyItem->find('first');
		//exit();
		
		if(sizeof($daily_item_data) > 0) {
			echo "setting stuff here";
			$this->DailyItem->id = $daily_item_data['DailyItem']['record_id'];
			$this->DailyItem->set('product_id',$product['Product']['product_id']);
			$this->DailyItem->set('selection_time',time());
			$this->DailyItem->save();
		}
		else {
			echo "setting stuff there";
			$daily_item['DailyItem']['product_id'] = $product['Product']['product_id'];
			$daily_item['DailyItem']['selection_time'] = time();
			$this->DailyItem->save($daily_item);
		}

		$product = $this->Product->find('first', array('conditions'=>array('product_id'=>$product_id)));
		//var_dump($product);
		//exit();
		return $product;
	
	}
	
	public function productsToJSON() {
	
		$search_query = $this->params['url']['search_query'];
		$fields = $this->params['url']['fields'];
		
		//var_dump($this->params['url']);
		//exit();
		$products = $this->performSearch($search_query, $fields); //returns product ids
		//var_dump($products);
		//exit();
		$JSON = "{ \"products\": [";
		//var_dump($products);
		$this->layout='ajax';
		//$this->autoRender = false;
		
		//$products = $this->Product->find('all', array('fields'=>$fields, 'conditions'=>array('product_id'=>$id)));
		$i=0;

		foreach($products as $product) {

			//$JSON .= "\"product\": [ ";
			$JSON .= "{";
			
				foreach(array_keys($product['Product']) as $field) {
					$JSON .= "\"".$field."\":\"".$product['Product'][$field]."\",";
				}
			
			$JSON = substr($JSON, 0, -1);
			$JSON .= "}";
			
			if ($i < sizeof($products)-1) {
				$JSON .= ", ";
			}
			
			$i++;
		}
		
		$JSON .= "]}";
		$this->set('JSON', $JSON);
		//echo $JSON;
	//	exit();
	}
	
	public function processAJAXQuery() {
	
		$this->autoRender = false;
		$this->layout = "ajax";
		//perhaps have a check condition?
		$jsonData = json_decode($this->params['data']['jsonData'], true);
		//		var_dump($jsonData);
		$command = $jsonData['command'];
		switch($command) {
			case "update" :
				$this->Product->save($jsonData['product']);
				break;
			case "delete" :
				$this->Product->delete($jsonData['product']['product_id']);
				break;
			case "insert" :
				$this->Product->create();
				$this->Product->save($jsonData['product']);
				break;
			case "default" :
				break;
		}
	}
	
	public function search() {
	
		//$this->Session->delete('searches');
		//exit();
		
		$this->layout = "shop_main";
		$this->set('page_type','shop');
		$this->set('heading', 'Search');

		if($this->request->is('post') && isset($this->request['data']['query'])) {

			$search_query = $this->request['data']['query'];
			$products = $this->performSearch($search_query,array("tags", "name"));
			
			if(sizeof($products) > 0) {
				$product_ids = array();
				foreach($products as $product) {
					array_push($product_ids, $product['Product']['product_id']);
				}
				
				$this->set('products', $products);
				
				if($this->Session->check('searches')) {
					$searches = $this->Session->read('searches');
					if(sizeof($searches) >= 5) {
						$searches = array_slice($searches, 1, null, true);
					}
				}
				else {
					$searches = array();
				}
				
				$search = array();
				$search['query'] = $search_query;//." ".time();
				$search['results'] = $product_ids;
				$this->set("search_exists", true);
				
				array_push($searches, $search);

				$this->Session->write('searches', $searches); //implicitly creates it if not already created

				$this->set('searches',array_reverse($searches,true));

			}
			else {
				if($this->Session->check('searches')) {
					$searches = $this->Session->read('searches');
				}
				else {
					$searches = array();
				}
				
				$this->Session->write('searches', $searches); //implicitly creates it if not already created
				$this->set('searches',array_reverse($searches,true));
			}
			$this->set("current_query",$search_query);
		}
		else if ($this->request->is('post') && isset($this->request['data']['search_request'])) {
			//var_dump($this->request);
			//exit();
			if($this->Session->check('searches')) {
				
				$this->set("search_exists", true);
				//$search_id = $this->request
				$searches = $this->Session->read("searches");
				$this->set('searches',array_reverse($searches,true));
				
				foreach($searches as $i=>$search) {
					if($i == $this->request['data']['search_request']) {
						$product_ids = $search['results'];
						$product_ids = $search['results'];
						$products = $this->Product->find('all', array('conditions'=>array('product_id'=>$product_ids)));
						$this->set("products", $products);
						$this->set("current_query", $search['query']);
						$this->set("current_index", $i);
					}
				}

			}
			else {
			
				$this->redirect(array("controller"=>"products", "action"=>"index"));
				
			}		
		}
		else if ($this->Session->check("searches")) { //just want to see results
			$searches = $this->Session->read("searches");
			$this->set('searches',array_reverse($searches,true));
			$max_id = max(array_keys($searches));
			foreach($searches as $i=>$search) {
				if($i == $max_id) {
					$product_ids = $search['results'];
					$products = $this->Product->find('all', array('conditions'=>array('product_id'=>$product_ids)));
					$this->set("products", $products);
					$this->set("current_query", $search['query']);
				}
			}
		}
		else {
			
				$this->redirect(array("controller"=>"products", "action"=>"index"));
				
		}		
	}

	private function performSearch($search_query, $fields) {
	
		if($search_query != "") {
			$search_data = explode(" ", $search_query);
			if(sizeof($search_data) > 1) {
				array_push($search_data, $search_query);
			}
		
			//var_dump($search_data);
			//exit();
			$intersection = array_intersect($fields, array("tags", "name", "description"));
			//var_dump(array_diff($intersection, $fields));
			//$products = $this->performFullTextSearch($search_data, $intersection);
			//just use for general search
			$doFullTextSearch = true;
		
			foreach($fields as $field) {
				if(!in_array($field, array("tags", "name", "description"))) {
					$doFullTextSearch = false;
					break;
				}				
			}
		
			$products = $this->performUsualSearch($search_data, $fields);
		
			if($doFullTextSearch == false) {
				$products = $this->performUsualSearch($search_data, $fields);
			}
			else {
				//echo "here";
				//var_dump($search_data);
				//exit();
				$products = $this->performFullTextSearch($search_data, $intersection);
				//var_dump($products);
				//exit();
				if(sizeof($products) == 0) {
					$this->performUsualSearch($search_data, $intersection);
				}
			}
		
			return $products;
		}
		else {
			return array();
		}
	}
	
	private function performUsualSearch($search_data, $fields) {
	
		$sql_query = "SELECT * FROM Products AS Product WHERE ";
				
		foreach($fields as $i=>$field) {
				
			//	$sql_query .= $field." ";
				
			foreach($search_data as $j=>$term) {
				if($term != "") {
					$sql_query .= $field." ";
				
					$sql_query .= "REGEXP '".$term."'";
					if($j != (sizeof($search_data) - 1)) {
						$sql_query .= " OR ";		
					}
				}
			}
				
					/*if(sizeof($search_data) > 1) {
						$sql_query .= " OR REGEXP '".$search_query."'";
					}*/
			if($i != (sizeof($fields)-1)) {
				$sql_query .= " OR ";
			}
		}

		//var_dump($sql_query);
		//exit();
		$products = $this->Product->query($sql_query);
		//var_dump($products);		
		//exit();
		return $products;
	}
	
	private function performFullTextSearch($search_data, $fields) {
	
		$sql_query = "SELECT *,

					MATCH(";
					
		foreach($fields as $i=>$field) {
			$sql_query .= $field;
			if($i != (sizeof($fields)-1)) {
				$sql_query .= ",";
			}
		}
		$sql_query .= ") AGAINST ('";
						
		foreach($search_data as $term) {

			$sql_query .= "+".$term." ";

		}
						
		$sql_query .= "' IN BOOLEAN MODE) AS score
					FROM products AS Product

					WHERE MATCH(name, tags) AGAINST('";
						
		foreach($search_data as $term) {

			$sql_query .= "+".$term." ";

		}			
						
		$sql_query .= "' IN BOOLEAN MODE)
			ORDER BY score DESC";
						
			//echo $sql_query;
			//exit();
		if($search_data != "") {
			$products = $this->Product->query($sql_query);
			return $products;
		}
		else {
			return array();
		}
	}
	
	public function getAvailableTags() {
	
		$availableTags = array();
	
		if(isset($this->params['requested'])) {
			$products = $this->Product->find('all', array('fields'=>'tags'));
			if(sizeof($products) > 0) {
				foreach($products as $product) {
					if($product['Product']['tags'] != "") {
						foreach(explode(",",$product['Product']['tags']) as $tag) {
							if(!in_array($tag, $availableTags)) {
								array_push($availableTags, $tag);
							}
						}
					}					
				}
				//return $availableTags;
				return $availableTags;
			}
			else {
				return array(); //empty array
 			}
		}
		else {
			return array(); //empty array
			//shouldn't happen
		}
	}
	
	public function beforeFilter() {
		parent::beforeFilter();
		//if($this->Session->check('Auth.User')) {
		//	$this->set('user', $this->Session->read('Auth.User'));
		//}
		$this->layout = "main";
	}	
}

?>