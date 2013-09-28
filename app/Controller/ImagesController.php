<?php

//App::uses('AppController', 'Controller');
include_once('php/create_thumb.php');



class ImagesController extends AppController {

var $uses = array('Product');
//upload image (ajax)

public function uploadimage($product_id) {

	$this->autoRender = false;
	$total_files = 0;
	$all_ids = array();
	$available_ids = array();
	$used_ids = array();
	$image_id=1;
	
	if(is_dir('img/product_images/'.$product_id)) {
		$folder = opendir('img/product_images/'.$product_id);
		while(($file = readdir($folder)) != false) {
			if($file != '.' && $file != '..') {
				//exit(0);
				list($part1, $part2) = explode('_', $file);
				array_push($used_ids,substr($part2, 0, -4));
				$total_files++;
			}
		}
		/*if($total_files>0){
			for($i=1; $i<=$total_files+1; $i++) {
				array_push($all_ids,$i);
			}
			$available_ids = array_diff($all_ids,$used_ids);
			if(sizeof($available_ids) > 0) {
				$image_id = min($available_ids);
			}
			else {
				$image_id = $total_files+1;
			}
		}
		else {
			$image_id = 1;
		}*/
	}
	else {
		mkdir('img/product_images/'.$product_id, 0700);
		mkdir('img/product_thumbnails/'.$product_id, 0700);
	//	$image_id = 1;
	}
	
	if(is_dir('img/temporary/temp_product_images/'.$product_id)) {
		$folder = opendir('img/temporary/temp_product_images/'.$product_id);
		while(($file = readdir($folder)) != false) {
			if($file != '.' && $file != '..') {
				//exit(0);
				list($part1, $part2) = explode('_', $file);
				array_push($used_ids,substr($part2, 0, -4));
				$total_files++;
			}
		}
		/*if($total_files>0){
			for($i=1; $i<=$total_files+1; $i++) {
				array_push($all_ids,$i);
			}
			$available_ids = array_diff($all_ids,$used_ids);
			if(sizeof($available_ids) > 0) {
				$image_id = min($available_ids);
			}
			else {
				$image_id = $total_files+1;
			}
		}
		else {
			$image_id = 1;
		}*/
	}
	else {
		mkdir('img/temporary/temp_product_images/'.$product_id, 0700);
		mkdir('img/temporary/temp_product_thumbnails/'.$product_id, 0700);
	//	$image_id = 1;
	}
	
	if($total_files>0){
		for($i=1; $i<=$total_files+1; $i++) {
			array_push($all_ids,$i);
		}
		$available_ids = array_diff($all_ids,$used_ids);
		if(sizeof($available_ids) > 0) {
			$image_id = min($available_ids);
		}
		else {
			$image_id = $total_files+1;
		}
	}
	else {
		$image_id = 1;
	}
	
	//error_log(implode(',',$_FILES['qqfile']['name']), 0);
	//error_log($_FILES['qqfile']['size'], 0);
	$filename = $product_id.'_'.$image_id.'.jpg';
	//$main_url = 'img/product_images/'.$product_id.'/'.$filename;
	//$thumbnail_url = 'img/product_thumbnails/'.$product_id.'/'.$filename;
	$main_url = 'img/temporary/temp_product_images/'.$product_id.'/'.$filename;
	$thumbnail_url = 'img/temporary/temp_product_thumbnails/'.$product_id.'/'.$filename;
	//move_uploaded_file($_FILES['qqfile']['tmp_name'], 'img/product_images/'.$product_id.'/'.$filename);
	move_uploaded_file($_FILES['qqfile']['tmp_name'], 'img/temporary/temp_product_images/'.$product_id.'/'.$filename);
	createThumb($main_url, $thumbnail_url, 200);

	/*$this->Image->create();
	$this->Image->set(array(
		'image_id'=>$image_id,
		'product_id'=>$product_id,
		'main_url'=>$main_url,
		'thumbnail_url'=>$thumbnail_url)
		);
	$this->Image->save();
	//$this->loadModel('MainImage');
	$this->MainImage->create();
	$this->MainImage->set(array(
		'product_id'=>$product_id,
		'image_id'=>$image_id)
	);*/
	//$this->MainImage->save();
	//echo "{ \"success\" : true, \"image_id\" : ".$image_id.", \"main_url\" : \"".$main_url."\", \"thumbnail_url\" : \"".$thumbnail_url."\" }";
	echo "{ \"success\" : true, \"image_id\" : ".$image_id."}";
	//echo "{ \"success\" : true, \"main_url\" : \"".$main_url."\", \"thumbnail_url\" : \"".$thumbnail_url."\" }";
	//echo "{ \"success\" : true }";
}

public function confirmEdit() {

	$this->layout = "ajax";
	$this->autoRender = false;
	
	if($this->request->is('post')) {
	
		$jsonData = json_decode($this->request['data']['jsonData'], true);
		$product_id = $jsonData['product_id'];
		$primary_image = $jsonData['primary_image'];
		$secondary_images = $jsonData['secondary_images'];
			
		//var_dump($jsonData);
		//exit();
		//$image_ids = array_merge($primary_image, $secondary_images);
		$image_ids = explode(",", $secondary_images); //includes primary image
		//var_dump($image_ids);
		
		foreach(array("product_images", "product_thumbnails") as $location) {
			if(is_dir('img/temporary/temp_'.$location.'/'.$product_id) && is_dir('img/'.$location.'/'.$product_id)) {

				$folder = opendir('img/temporary/temp_'.$location.'/'.$product_id);
				while(($file = readdir($folder)) != false) {
					//echo "eee";
					if($file != '.' && $file != '..') {

						list($part1, $part2) = explode('_', $file);
						$part2 = substr($part2, 0, -4);
						if(in_array($part2, $image_ids)) {
	
							copy('img/temporary/temp_'.$location.'/'.$product_id.'/'.$file, 'img/'.$location.'/'.$product_id.'/'.$file);
						}
						unlink('img/temporary/temp_'.$location.'/'.$product_id.'/'.$file);

					}
				}
				//exit();
				rmdir('img/temporary/temp_'.$location.'/'.$product_id);
			}
		}
		
		$this->loadModel('Product');
		$this->Product->id = $product_id;
		$this->Product->set('primary_image',$primary_image);
		$this->Product->set('secondary_images',$secondary_images);
		$this->Product->save();
		//var_dump($this->Product);
		echo "{ \"success\" : true }";
		
	}
}

public function cancelEdit() {

	$this->layout = "ajax";
	$this->autoRender = false;
	
	if($this->request->is('post')) {
		$jsonData = json_decode($this->request['data']['jsonData'], true);
		$product_id = $jsonData['product_id'];
		
		foreach(array("temp_product_images", "temp_product_thumbnails") as $location) {
			$dirs = array_filter(glob('img/temporary/'.$location."/*"), 'is_dir'); //from http://stackoverflow.com/questions/2524151/php-get-all-subdirectories-of-a-given-directory
			foreach($dirs as $dir) {
				//$dir = 'img/temporary/'.$location.'/'.$product_id;
				//if(is_dir($dir)) { 
				$folder = opendir($dir);
				while(($file = readdir($folder)) != false) {
					if($file != '.' && $file != '..') {
						//unlink('img/temporary/'.$location.'/'.$product_id.'/'.$file);
						unlink($dir."/".$file);
					}
					//echo "eh";
					//echo "{ \"success\" : true }";
				}
				rmdir($dir);
			}
			//var_dump($dirs);
			//exit();
		}		
		echo "{ \"success\" : true }";
		//echo "{ \"success\" : \"".(int)is_dir('img/temporary/temp_product_images/5/')."\"}";
		//exit();
	}
	else {
		//error of some sort
	}
}

/*public function getImageURLs($product_id) {

	$this->loadModel('MainImage');
	$this->autoRender = false;
	$images = $this->Image->find('all', array('fields'=>array('image_id', 'main_url', 'thumbnail_url'),'conditions'=>array('product_id' => $product_id)));
	$main_image = $this->MainImage->find('all', array('fields'=>array('image_id'), 'conditions'=>array('product_id' => $product_id)));
	
	$JSON = "{ \"Images\" : [";
	
	foreach($images as $image) {
		//echo "moo";
		//$JSON .= "\"Image\" : {";
		$JSON .= "{\"image_id\" : \"".$image['Image']['image_id']."\",";
		$JSON .= "\"main_url\" : \"".$image['Image']['main_url']."\",";
		$JSON .= "\"thumbnail_url\" : \"".$image['Image']['thumbnail_url']."\",";
		//if ($image['Image']['image_id'] == $main_image[0]['MainImage']['image_id']) {
		//	$JSON .= "\"main\" : \"true\"";
		//}
		//else {
			$JSON .= "\"main\" : \"false\"";
		//}
		$JSON .= "},";
	}
	if (sizeof($images) > 0) {
		$JSON = substr($JSON, 0, -1);
	}
	$JSON .= "]}";
	//$JSON = "{ \"Images\" : { \"Image\" : { \"product_id\" : 1, \"image_id\" : 2 } } }";
	echo $JSON;
}*/

//run checks, if false, return problem
//else move into temporary folder:
/*

	Create a folder in the temp location with the product id.
	Add pictures into it (these must be new pictures, give them an id that's not been used) (create an array of available ids, in orders)
	
	if remove, it stores the id in a *execution* list on confirm. if uploaded and then deleted, that's fine (just move pictures first).
	if uploaded and then cancelled, delete contents of folder and execution list. 

*/
//if successful, return url (to temp folder)

//confirm images (move them into folder of product id)
//move the images and create the sql records


//get images (send product id), returns json





}

?>