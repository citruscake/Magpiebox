<?php

/**
 *
 *  Copyright 2013 EposNow
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
class Eposnow_TillSync_Model_Observer {

    public function __construct()  {
    }

    protected function _getRequestHelper() {
        return Mage::helper('Eposnow_TillSync/Request');
    }


    // *** Observer Enabler Logic
    // =================================================================================================================
    public static $observersEnabled = true;
    public static function observers_enabled() {
        if ($_SERVER['HTTP_USER_AGENT'] == "EposNow Till API") {
            return false;
        } else {
            return self::$observersEnabled;
        }
    }
    public function disable_observers() {
        self::$observersEnabled = false;
    }
    public function enable_observers() {
        self::$observersEnabled = true;        
    }

    public function check_oauth() {
        if (! self::observers_enabled()) {
            return;
        }
        
        $settings         = Mage::helper('Eposnow_TillSync');
        $accessToken      = $settings->getConfig('oauthAccessToken');
        $accessTokenSecret= $settings->getConfig('oauthAccessTokenSecret');
        $enabled          = $settings->getConfig('enabled');
        $session          = Mage::getSingleton('core/session');
        $admin            = Mage::getSingleton('admin/session')->isLoggedIn();

        /*if (! (bool)$enabled) {
            if ($admin) {
                $session->addNotice('EposNow TillSync Disabled');
            }
            //$this->disable_observers();
        } else*/
		if (! $accessToken || ! $accessTokenSecret) {
            if ($admin) {
                $session->addNotice('EposNow TillSync not authorized. Resync required'); 
            } 
            $this->disable_observers();        
        }
    }



    // *** Set up
    // =================================================================================================================
    public function save_config($observer) {
        $settings   = Mage::helper('Eposnow_TillSync');
        $enabled    = $settings->getConfig('enabled');

        $settings->saveConfig('oauthAccessToken', null);
        $settings->saveConfig('oauthAccessTokenSecret', null);

        //if ($enabled == false) {
        //    return $this;
        //}

        $this->log("=============================================================================");

        $this->log("oAuth Started");
        $this->_getRequestHelper()->request('Auth','POST'); 
        $this->log("oAuth Finished");

        $this->setup();
		
		if ($enabled == true) {
			$this->initial_sync();
		}

        $this->log("=============================================================================");

        return $this;
    }

    private function setup() { 
        $this->log("Setup Started");        
        $eposnowid = array(
            'group'         => 'General',
            'input'         => 'hidden',
            'type'          => 'int',
            'label'         => 'EposNow ID',
            'default'       => 0,
            'visible'       => 0,
            'required'      => 0,
            'filterable'    => 1,
            'user_defined'  => 0,
            'is_required'   => 0,
            'is_comparable' => 0,
            'is_searchable' => 1,
            'is_unique'     => 0,
            'is_configurable'=>0,
            'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        );
		
		$barcode = array(
            'group'         => 'General',
            'input'         => 'text',
            'type'          => 'varchar',
            'label'         => 'Barcode',
            'default'       => 0,
            'visible'       => 1,
            'required'      => 0,
            'filterable'    => 1,
            'user_defined'  => 0,
            'is_required'   => 0,
            'is_comparable' => 0,
            'is_searchable' => 1,
            'is_unique'     => 0,
            'is_configurable'=>0,
            'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        );
 

        $this->disable_observers(); 
        $setup = new Mage_Eav_Model_Entity_Setup('core_setup');  
        $setup->addAttribute('catalog_product',   'epos_now_id', $eposnowid);
		$setup->addAttribute('catalog_product',   'barcode', $barcode);
        $setup->addAttribute('catalog_category',  'epos_now_id', $eposnowid);
        $setup->addAttribute('customer_address',  'epos_now_id', $eposnowid);
        $setup = new Mage_Sales_Model_Mysql4_Setup('core_setup');
        $setup->addAttribute('order',             'epos_now_id', $eposnowid);
        $setup->addAttribute('order_item',        'epos_now_id', $eposnowid);
        $this->enable_observers();

        $this->log("Setup Finished"); 
    }

    private function initial_sync() {
        $this->log("Sync Started");
        $this->sync_categories();
        $this->sync_products();
        $this->sync_stock();
        $this->log("Sync Finished");
    }




    // *** Products
    // =================================================================================================================
    public function save_product($observer) {
        $this->check_oauth();

        if (! self::observers_enabled()) {
            return $this;
        }

        $event      = $observer->getEvent();
        $product    = $event->getProduct(); 

        if (! $product->hasDataChanges()) { 
            return $this; 
        }

        $product = $this->make_product($product);
        if (!$product) {
            return $this;
        }

        $data       = array('product' => $product);
        $request    = $this->_getRequestHelper(); 

        try {
            $result  = $request->request('ProductSave','POST', $data);
            $product = $result->product;

            $model = Mage::getModel('catalog/product')->Load($product->id);
            $model->addData(array('epos_now_id' => $product->eposnow_id));

            $this->disable_observers();
            $result = $model->save();
            $this->enable_observers();
            
        } catch (Exception $e) {
            Mage::throwException($e);      
        }

        return $this;
    }

    public function delete_product($observer) {
        $this->check_oauth();

        if (! self::observers_enabled()) {
            return $this;
        }  

        $event      = $observer->getEvent();
        $product    = $event->getProduct();
        $request    = $this->_getRequestHelper(); 
        $data       = array('product' => array('eposnow_id' => intval($product->getEposNowId())));

        try {
            $result = $request->request('ProductDelete','POST', $data);
        } catch (Exception $e) {
            Mage::throwException($e);  
        }

        return $this;
    }

    public function sync_products() {
        // Get the configurable products first, then add the other types, so that the config products are created first
        $products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')
                        ->addAttributeToFilter('type_id', array('eq' =>  'configurable'))->load();
        $simples  = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect('*')
                        ->addAttributeToFilter('type_id', array('neq' => 'configurable'))->load();

        // Add the normal products on to the product collection
        foreach ($simples as $product) { $products->addItem($product); }
        unset($simples);

        // Make the JSON objects
        $data = array('products' => array());
        foreach ($products as $product) {
            $product = $this->make_product($product);
            if ($product) {
                $data['products'][] = $product;
            }
        }

        // And launch!
        try {
            $result = $this->_getRequestHelper()->request('ProductSync','POST', $data);
            $this->save_eposnow_products($result->products); 
        } catch (Exception $e) {   
            Mage::log($e);        
            Mage::throwException($e);  
        }
    }

    public function save_eposnow_products($products) {
        $website      = Mage::app()->getWebsite(true);
        $store        = $website->getDefaultStore();
        $catIds       = array();
        $custTaxClass = Mage::getModel('tax/class')->load('CUSTOMER', 'class_type');
        $this->taxClasses = array();      

        // Update the existing products and add the new ones                        
        foreach ($products as $product) {
			
			$entityTypeId = Mage::getModel('eav/entity')->setType('catalog_product')->getTypeId();
			$attrSetId    = Mage::getModel('eav/entity_attribute_set')->getCollection()
							->setEntityTypeFilter($entityTypeId)
							->addFieldToFilter('attribute_set_name', $product->attributeset)
							->getFirstItem()->getAttributeSetId();
						
			if ($attrSetId == null){
				$attrSetId    = Mage::getModel('eav/entity_attribute_set')->getCollection()
							->setEntityTypeFilter($entityTypeId)
							->addFieldToFilter('attribute_set_name', 'Default')
							->getFirstItem()->getAttributeSetId();
			}
			
			$newProduct = false;

            if ($product->id != 0) {
                $model = Mage::getModel('catalog/product')->Load($product->id);
            } else {
                $model = new Mage_Catalog_Model_Product();
				$newProduct = true;
            }

            // Tidy up some data
            $product->tax_rate = $this->float_to_string($product->tax_rate);
            $product->price    = $this->float_to_string($product->price);
            if ($product->sku == null) {
                $product->sku = $product->name;
            }

            // Get the Tax class
            if (! array_key_exists($product->tax_class, $this->taxClasses)) {
                $this->get_tax_rate($product, $custTaxClass);
            }

            // Add General Details
			if ($newProduct){
				$model->setTypeId('simple');
				$model->setAttributeSetId($attrSetId);
				$model->setWeight(1);
				$model->setStatus(1);
				$model->setVisibility(Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH); 
				$model->setWebsiteIDs(array($website->getId())); 
				$model->setStoreIDs(array($store->getId())); 
			}
            if (strpos($product->name,'...') === false) {
				$model->setName($product->name);
			}
			
			/*
			if (strpos($product->description,'...') === false) {
				$model->setDescription($product->description);
			}
			*/
			
            $model->setEposNowId($product->eposnow_id);
            $model->setPrice($product->price);
            $model->setTaxClassId($this->taxClasses[$product->tax_class]);
            $model->setSku($product->sku);
			$model->setBarcode($product->barcode);
            

            // Add the category
            if ($product->category->eposnow_id != 0) {
                if (! array_key_exists($product->category->eposnow_id, $catIds)) {
                    $cat = Mage::getResourceModel('catalog/category_collection');
                    $cat->addAttributeToFilter('epos_now_id', $product->category->eposnow_id);
                    $cat->load();
                    if ($cat->getFirstItem()->getId()) {
                        $catIds[$product->category->eposnow_id] = $cat->getFirstItem()->getId();
                    }
                }
                if (array_key_exists($product->category->eposnow_id, $catIds)) {
                    $model->setCategoryIds(array($catIds[$product->category->eposnow_id]));
                }
            }

            // Set the attributes
            foreach ($product->attributes as $attribute) {
                if ($attribute->name == 'color') {
                    $attribute->value = $this->get_color($attribute->value, $model);
                }
                $method = 'set'.uc_words($attribute->name);
                $model->$method($attribute->value);
            }


            // And save
            $this->disable_observers();  
            $model->save(); 
            $this->enable_observers(); 


            // Initilise stock
			if ($newProduct){
				$stockItem = Mage::getModel('cataloginventory/stock_item');
				$stockItem->assignProduct($model);
				$stockItem->setData('stock_id', 1);
				$stockItem->setData('store_id', $store->getId());
				$stockItem->setData('qty', 0);
				$stockItem->setData('is_in_stock', 0);
				$stockItem->setData('manage_stock', 1);
				$stockItem->setData('use_config_manage_stock', 0);  

				$this->disable_observers();   
				$stockItem->save();
				$this->enable_observers(); 

				unset($stockItem); 
			}


            // Do some housework
            unset($model); 
        }
    }

    private function make_product($product) {
        
        // Determine product type
        $productType    = $product->getTypeId();
        $supportedTypes = array('simple', 'configurable', 'grouped', 'virtual', 'bundle');

        if (! in_array($productType, $supportedTypes)) {
            return false;
        }

/*
        if ($productType === 'bundle') {
            d(get_class_methods($product));
            dd($product);
        }
*/

        // Get the configurable product options
        $parents  = array(); 
        $options  = array();
        if ($productType === 'configurable') {
            $attributes = $product->getTypeInstance(true)->getConfigurableAttributesAsArray($product);

            foreach ($attributes as $productAttribute) {
                $attrs = array(
                    'name'   => $productAttribute['store_label'],
                    'values' => array(),
                );
                foreach ($productAttribute['values'] as $attribute) {
                    $attrs['values'][] = $attribute['store_label'];
                }
                $options[] = $attrs;
            }

        // or, see if the product has a configurable parent
        } else {
            $parentIds = Mage::getResourceSingleton('catalog/product_type_configurable')->getParentIdsByChild($product->getId());
            foreach ($parentIds as $id) {
                $parent = Mage::getModel('catalog/product')->load($id);
                $parents[] = array(
                    'id'         => intval($id),
                    'eposnow_id' => intval($parent->getEposNowId()),
                );
            }
        }

        // Get the attributes
        $attributes = array();
        foreach ($product->getAttributes() as $attribute) {    
            if ($attribute->getIsUserDefined()) {
                $label = $attribute->getFrontend()->getLabel($product);  
                $label = strtolower($label); 
                $value = $attribute->getFrontend()->getValue($product); 
                $attributes[] = array(
                    'name'  => $label,
                    'value' => $value,
                );
            }
        }


        // Get the first category
        $category = array();
        foreach ($product->getCategoryIds() as $categoryid) {
            $cat = Mage::getModel('catalog/category')->load($categoryid) ;
            $category['id']         = intval($cat->getId());
            $category['eposnow_id'] = intval($cat->getEposNowId());
            break;
        } 
		
		// populate the tax class with the product taxClassId if it doesnt already exist
        $this->populateTaxClasses($product);
		
		//Get the other product data
		$id = intval($product->getID());
		$eposnow_Id = intval($product->getEposNowId());
		$name = $product->getName();
		$price = floatval($product->getPrice());
		$tax_rate = floatval($this->taxRates[$product->getTaxClassId()]);
		$tax_class = $this->taxClasses[$product->getTaxClassId()];
		$sku = $product->getSku();
		$barcode = $product->getBarcode();
		
		//Get the attribute set name
		$attributeSet = Mage::getModel('eav/entity_attribute_set')->load($product->getAttributeSetId())->getAttributeSetName();

        // And make the product
        $prod = array(
            'id'                => $id,
            'eposnow_id'        => $eposnow_Id,
            'parents'           => $parents,
            'name'              => $name,
            'price'             => $price,
            'category'          => $category,
            'tax_rate'          => $tax_rate,
            'tax_class'         => $tax_class,
			'attributeset'      => $attributeSet,
            'attributes'        => $attributes,
            'options'           => $options,
            'product_type'      => $productType,
            'sku'               => $sku,
			'barcode'           => $barcode,
        );

        return $prod;
    }



    // *** Categories
    // =================================================================================================================
    public function save_category($observer) {
        $this->check_oauth();
        
        if (! self::observers_enabled()) {
            return $this;
        }

        $event      = $observer->getEvent();
        $category   = $event->getCategory(); 

        if (! $category->hasDataChanges()) { 
            return $this; 
        }

        if (! $category->getIsActive()) { 
            return $this;
        };


        $category  = $this->make_category($category); 
		$data       = array('category' => $category);
        $request    = $this->_getRequestHelper(); 

        try {
            $result   = $request->request('CategorySave','POST', $data);
            $category = $result->category;

            $model = Mage::getModel('catalog/category')->Load($category->id);
            $model->addData(array('epos_now_id' => $category->eposnow_id));

            $this->disable_observers();
            $model->save();
            $this->enable_observers();
            
        } catch (Exception $e) {
            Mage::throwException($e);      
        }

        return $this;
    }

    public function delete_category($observer) {
        $this->check_oauth();
        
        if (! self::observers_enabled()) {
            return $this;
        }

        $event      = $observer->getEvent();
        $category   = $event->getCategory();
        $request    = $this->_getRequestHelper(); 
        $data       = array('category' => array('eposnow_id' => intval($category->getEposNowId())));

        try {
            $result = $request->request('CategoryDelete','POST', $data);
        } catch (Exception $e) {
            Mage::throwException($e);  
        }

        return $this;
    }

    public function sync_categories() {
        $this->log("Category Sync Started");

        $request = $this->_getRequestHelper(); 

        $categories = Mage::getModel('catalog/category')->getCollection()->setOrder('parent', 'ASC')->addAttributeToSelect('*'); 
        $data       = array('categories' => array());

        $this->log("Retrieved Categories");

        foreach ($categories as $category) {
            if ($category->getIsActive() == false) continue;
            if ($category->getName()     == null) continue;
            $data['categories'][] = $this->make_category($category);
            $this->log("Made Category ". $category->getId() ." - ". $category->getName()); 
        }

        try {
            $this->log("Send Categories to EposNow");
            $result = $request->request('CategorySync','POST', $data);
            $this->log("Received Categories from EposNow");
            $this->save_eposnow_categories($result->categories);
            $this->log("Saved Categories from EposNow"); 

        } catch (Exception $e) {            
            Mage::throwException($e);  
        }

        $this->log("Category Sync Finished");
    }

    public function save_eposnow_categories($categories, $moveCategories = false) {
        $createdIds     = array(); // Array of eposnowIDs => magentoIDs for finding parent IDs
        $rootCategoryId = Mage::app()->getWebsite(true)->getDefaultStore()->getRootCategoryId();
        $attributeSetId = Mage::getModel('catalog/category')->load($rootCategoryId)->getAttributeSetId();
        
        // Update the existing cats and add the new ones
        foreach ($categories as $category) {


            if ($category->id != 0) {
                $model = Mage::getModel('catalog/category')->Load($category->id);

                if ($moveCategories) { 
                    $parentID = end($category->parents)->id;
                    if ($parentID > 0) {
                        $model->move($parentID, null);
                    }
                }
            } else {
                $model = new Mage_Catalog_Model_Category();

                if (count($category->parents) > 0) {
                    if (count($createdIds) > 0) {
                        $parentID = $createdIds[end($category->parents)->eposnow_id];
                    } else {
                        $parentID = Mage::getModel('catalog/category')->getCollection()
                        ->addAttributeToFilter('epos_now_id', end($category->parents)->eposnow_id)
                        ->getFirstItem()->getId();
                    }
                } else {
                    $parentID = $rootCategoryId;
                }
                $parent = Mage::getModel('catalog/category')->load($parentID);
                $model->setPath($parent->getPath());
            }

            // Add basic details
            $model->setEposNowId($category->eposnow_id);
            $model->setName($category->name);
            $model->setDescription($category->description);
            $model->setDisplayMode('PRODUCTS');
            $model->setIsActive(1);
            $model->setIsAnchor(1);
            $model->setAttributeSetId($attributeSetId);
            
            // And save
            $this->disable_observers();  
            $model->save(); 
            $this->enable_observers();  

            $createdIds[$category->eposnow_id] = $model->getId();
            unset($model);
        }
    }

    private function make_category($category) {
        $cat = array(
            'id'            => intval($category->getID()),
            'eposnow_id'    => intval($category->getEposNowId()),
            'level'         => intval($category->getLevel()),
            'name'          => $category->getName(),
            'description'   => $category->getDescription(),
            'parents'       => $this->get_category_parents($category),
        );
        return $cat;
    }

    private function get_category_parents($category) { 
        $parents = array();

        foreach($category->getParentIds() as $id) {
            $parent = Mage::getModel('catalog/category')->load($id);

            if ($parent->getIsActive() == false) continue;
            if ($id == $category->getId()) continue;
            if ($parent->getName() == null) continue;

            $parents[] = array(
                'id'            => intval($id),
                'eposnow_id'    => intval($parent->getEposNowId()),
                'level'         => intval($parent->getLevel()),
                'name'          => $parent->getName(),
            );
        }

        return $parents;
    }



    // *** Orders 
    // =================================================================================================================
    public function save_order($observer) {
        $this->check_oauth();
        
        if (! self::observers_enabled()) {
            return $this;
        }

        $request    = $this->_getRequestHelper();
        $event      = $observer->getEvent();
        $order      = $event->getOrder();
        $payment    = $order->getPayment();
        $items      = $order->getAllItems();
        $address    = $order->getAddressById($order->getBillingAddressId());
        $street     = $address->getStreet();

        $data = array(
            'id'                => intval($order->getId()),
            'eposnow_id'        => intval($order->getEposNowId()),
            'customer'          => array(
                'id'            => intval($address->getId()),
                'eposnow_id'    => intval($address->getEposNowId()),
                'forename'      => $address->getFirstname(),
                'surname'       => $address->getLastname(),
                'address1'      => $street[0],
                'address2'      => (count($street) > 1 ? $street[1] : ''),
                'town'          => $address->getCity(),
                'county'        => $address->getRegion(),
                'postcode'      => $address->getPostcode(),
                'telephone'     => $address->getTelephone(),
                'email'         => $address->getEmail(),
            ),
            'items'             => array(),
            'status'            => $order->getStatus(),
            'total'             => floatval($order->getGrandTotal()),
            'discount_value'    => floatval($order->getDiscountAmount()),
            'discount_reason'   => $order->getDiscountDescription(),
            'payment_method'    => $payment->getMethod(),
        );

        foreach($items as $item) {
            $product = Mage::getModel('catalog/product')->Load($item->getProductId());

            // populate the tax class with the product taxClassId if it doesnt already exist
            $this->populateTaxClasses($product);

            $data['items'][] = array(
                'id'                => intval($item->getId()),
                'eposnow_id'        => intval($item->getEposNowId()),
                'product'           => array(
                    'id'            => intval($product->getId()),
                    'eposnow_id'    => intval($product->getEposNowId()),
                    'name'          => $product->getName(),
                    'tax_rate'      => floatval($this->taxRates[$product->getTaxClassId()]),
                    'tax_class'     => $this->taxClasses[$product->getTaxClassId()],
					'product_type'	=> $item->getProductType(),
                ),
                'quantity'          => intval($item->getQtyOrdered()),
                'price'             => floatval($item->getPrice()),
                'discount_value'    => floatval($item->getDiscountInvoiced()),
				'parent_item'		=> intval($item->getParentItemId()),
            );
        }

        // Add the shipping amount as an extra transaction item
        $data['items'][] = array(
            'quantity'  => 1,
            'price'     => floatval($order->getShippingAmount()),
            'product'   => array(
                'name'  => 'shipping',
                'type'  => 'shipping'
            )
        );

        try {
            $result = $request->request('TransactionSave','POST', array('transaction' => $data));
        } catch (Exception $e) {
            Mage::throwException($e);  
        }


        if (property_exists($result, 'transaction') && $result->transaction->eposnow_id > 0) {
            $this->disable_observers(); 

            $order->setEposNowId($result->transaction->eposnow_id);
            $order->save(); 

            $address->setEposNowId($result->transaction->customer->eposnow_id);
            $address->save(); 

            foreach($result->transaction->items as $item) {
                if ($item->id > 0) {
                    $order_item = Mage::getModel('sales/order_item')->Load($item->id);
                    $order_item->setEposNowId($item->eposnow_id);
                    $order_item->save();    
                }
            }

            $this->enable_observers();
        }
        return $this;
    }



    // *** Stock 
    // =================================================================================================================
    public function save_stock($observer) {
        $this->check_oauth();
        
        if (! self::observers_enabled()) { 
            return $this;  
        }

		$request = $this->_getRequestHelper();
        $event   = $observer->getEvent();
        $product = $event->getData();
		$product = $product['data_object']->getProduct();

        if ($product === null) {
            // This save call is from an order, not a product edit, so exit
            return $this;
        }

        if (! array_key_exists('original_inventory_qty', $product['stock_data']) || ! array_key_exists('qty', $product['stock_data'])) {
            // Stock levels not enabled
            return $this;
        }
         
        $old   = $product['stock_data']['original_inventory_qty'];
        $new   = $product['stock_data']['qty'];
        $delta = floatval($new) - floatval($old);
    

        if ($delta == 0) {
            // no change
            return $this;
        }

        $data = array(
            'id'         => $product['entity_id'],
            'eposnow_id' => $product['epos_now_id'],
            'delta'      => intval($delta),
        );

        try {
            $result = $request->request('StockSave','POST', array('stock' => $data));
        } catch (Exception $e) {
            Mage::throwException($e);  
        }

        return $this;
    }

    public function sync_stock() {
        $request = $this->_getRequestHelper(); 
        $data    = array('stock' => array());

        // Grab all the product IDs and EposNowIDs
        $products = array();
        foreach (Mage::getResourceModel('catalog/product_collection')->addAttributeToSelect('epos_now_id')->load() as $product) {
            $products[$product->getId()] = $product->getEposNowId();
        }

        foreach (Mage::getModel('cataloginventory/stock_item')->getCollection()->load() as $item) {
            if (! array_key_exists($item->getProductId(), $products) || $products[$item->getProductId()] === null) {
                // product isn't synced so skip the stock
                continue;
            }

            $data['stock'][] = array(
                'id'            => $item->getProductId(),
                'eposnow_id'    => $products[$item->getProductId()],
                'quantity'      => intval($item->getQty()),
            );
        }

        try {
            $result = $request->request('StockSync','POST', $data);
            $this->save_eposnow_stock($result->stock, true);
        } catch (Exception $e) {            
            Mage::throwException($e);  
        }

    }

    public function save_eposnow_stock($stock, $setQty = false) {
            
        foreach ($stock as $item) {
            if ($item->id == 0) {
                $product = Mage::getResourceModel('catalog/product_collection')
                            ->addAttributeToFilter('epos_now_id', $item->eposnow_id)
                            ->getFirstItem();
                $item->id = $product->getId();
            }
            
			$product = Mage::getModel('catalog/product')->Load($item->id);
			if($product->getTypeId() == 'simple') {
            
                $model = Mage::getModel('cataloginventory/stock_item')->loadByProduct($item->id);
    			
    			//if ($model->getEnableQtyIncrements()) {
    				if ($setQty) {
    					$model->setQty(intval($item->quantity));
    				} else {
    					$model->setQty($model->getQty() + intval($item->delta));
    				}

    				if ($model->getQty() > 0) {
    					$model->setIsInStock(1);
    				} else {
    					$model->setIsInStock(0);
    				}     

    				// And save
    				$this->disable_observers();  
    				$model->save(); 
    				$this->enable_observers();
    			//}

                unset($model);
            }
        }
    }



    // *** Color Helper 
    // (can probably be abstracted later if manufacter or other select attribute is needed)
    // =================================================================================================================
    private $colors = array();

    // Checks to see if the color exists for the color name.
    // Creates the color if it does not exist
    // Finally adds the magento color id to the $this->color array
    private function get_color($colorName, $product) {

        // Load all the color options if we haven't already
        if (count($this->colors) == 0) { 
            $colors = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'color');
            if ($colors->usesSource()) {
                foreach($colors->getSource()->getAllOptions(false) as $color) {
                    $this->colors[$color['label']] = $color['value'];
                }
            }
        }

        // if it doesnt already exist, create it
        if (! array_key_exists($colorName, $this->colors)) {
            $attributes = Mage::getResourceModel('eav/entity_attribute_collection') 
            ->setEntityTypeFilter($product->getResource()->getTypeId()) 
            ->addFieldToFilter('attribute_code', 'color')
            ->load(false); 
            $attribute  = $attributes->getFirstItem()->setEntity($product->getResource());
            $attributes = array ('value' => array('optionone' => array($colorName)));
            $attribute->setData('option', $attributes); 
            $attribute->save();

            // Store the new color
            $this->colors[$colorName] = $attribute->getAttributeId();
        }

        return $this->colors[$colorName];
    }



    // *** Tax Helper
    // =================================================================================================================
    private $taxClasses = array();
    private $taxRates   = array();

    private function populateTaxClasses($product) {        
        $taxClassId = $product->getTaxClassId();

        // Get the tax rate
        if (! array_key_exists($taxClassId, $this->taxRates)) {
            $this->taxRates[$taxClassId] = 0;

            $taxCalc = Mage::getResourceModel('tax/calculation_collection');
            $taxCalc->addFieldToSelect('tax_calculation_rate_id');
            $taxCalc->addFieldToFilter('product_tax_class_id',  $taxClassId);
            $taxCalc->load();

            if ($taxCalc->getFirstItem()->getTaxCalculationRateId()) {
                $taxRates = Mage::getResourceModel('tax/calculation_rate_collection');
                $taxRates->addFieldToSelect('rate');
                $taxRates->addFieldToFilter('tax_calculation_rate_id', $taxCalc->getFirstItem()->getTaxCalculationRateId());
                $taxRates->load(); 

                if ($taxRates->getFirstItem()->getRate()) {
                    $this->taxRates[$taxClassId] = $taxRates->getFirstItem()->getRate();
                }
            }
        }

        // Set the tax class
        if (! array_key_exists($taxClassId, $this->taxClasses)) {
            $this->taxClasses[$taxClassId] = Mage::getModel('tax/class')->load($taxClassId)->getClassName();
        }
    }

    // Checks to see if the tax class exists for the product class and rate.
    // Creates the class and rate if it does not exist
    // Finally adds the magento tax class id to the $this->taxClasses array
    private function get_tax_rate($product, $custTaxClass) {
        $prodTaxClassId = 0;
        
        // See if we can find a matching tax rate and class
        $prodTaxClass = Mage::getResourceModel('tax/class_collection');
        $prodTaxClass->addFieldToSelect('class_id');
        $prodTaxClass->addFieldToFilter('class_type', 'PRODUCT');
        $prodTaxClass->addFieldToFilter('class_name', $product->tax_class);
        $prodTaxClass->load();

        if ($prodTaxClass->getFirstItem()->getId()) {
            $prodTaxClass = $prodTaxClass->getFirstItem();

            $taxCalcs = Mage::getResourceModel('tax/calculation_collection');
            $taxCalcs->addFieldToSelect('tax_calculation_rate_id');
            $taxCalcs->addFieldToFilter('customer_tax_class_id', $custTaxClass->getId());
            $taxCalcs->addFieldToFilter('product_tax_class_id',  $prodTaxClass->getId());
            $taxCalcs->load();

            foreach($taxCalcs as $taxCalc) {
                $taxRates = Mage::getResourceModel('tax/calculation_rate_collection');
                $taxRates->addFieldToSelect('tax_calculation_rate_id');
                $taxRates->addFieldToFilter('tax_calculation_rate_id', $taxCalc->getTaxCalculationRateId());
                $taxRates->addFieldToFilter('rate', $product->tax_rate);
                $taxRates->load();

                if ($taxRates->getFirstItem()->getId()) {
                    $prodTaxClassId = $prodTaxClass->getId();
                    break;
                }
            }
        }
 

        // We didnt find a class with the correct rate, so create it
        if ($prodTaxClassId == 0) {

            // Make the class if we don't have one already
            if ($prodTaxClass->getFirstItem()->getClassId()) {
                $prodTaxClass = $prodTaxClass->getFirstItem();

            } else {
                $taxClassI    = 1;
                $taxClassName = $product->tax_class;
                $tmpName      = $taxClassName;
                while(Mage::getModel('tax/class')->load($tmpName, 'class_name')->getId() > 0) {
                    $taxClassI++;
                    $tmpName = $taxClassName." ".$taxClassI;
                }
                $taxClassName = $tmpName;
                $prodTaxClass = new Mage_Tax_Model_Class();
                $prodTaxClass->setClassName($taxClassName);
                $prodTaxClass->setClassType('PRODUCT');
                $prodTaxClass->save();
            }

            // Make the rate
            $taxRateI    = 1;
            $taxRateCode = 'EPOS-*-Rate';
            while(Mage::getModel('tax/calculation_rate')->load($taxRateCode." ".$taxRateI, 'code')->getId() > 0) {
                $taxRateI++;
            }
            $taxRate = new Mage_Tax_Model_Calculation_Rate();
            $taxRate->setCode($taxRateCode." ".$taxRateI);
            $taxRate->setRate($product->tax_rate);
            $taxRate->setTaxPostcode("*");
            $taxRate->save();

            // make the rule, which creates the calculation for us
            $taxRule = new Mage_Tax_Model_Calculation_Rule();
            $taxRule->setCode($custTaxClass->getClassName()."-".$product->tax_class."-"."Rate ".$taxRateI);
            $taxRule->setPriority('1');
            $taxRule->setPosition('1');
            $taxRule->setTaxCustomerClass(array($custTaxClass->getId()));
            $taxRule->setTaxProductClass(array($prodTaxClass->getId()));
            $taxRule->setTaxRate(array($taxRate->getId()));
            $taxRule->save();

            $prodTaxClassId = $prodTaxClass->getId();
        } 

        // Finally store the tax class id so we don't have to go through that again.
        $this->taxClasses[$product->tax_class] = $prodTaxClassId;
    }



    // *** General Helpers
    // =================================================================================================================
    private function sanitize_html($string) {
        $string = preg_replace('#<br\s*/?>#i', "\n", $string);
        $string = strip_tags($string);
        $string = htmlspecialchars($string);
        $string = htmlentities($string);
        return $string;
    }

    /// Converts a float to a string, padded with zeros for use in magento
    private function float_to_string($val, $length = 7) {
        if (strpos($val, ".") === false) {
            $val = $val.".0";
        }
        $val = str_pad($val, $length, "0");

        return $val;
    }

    private $lasttime  = null; 
    public function log($message) {
        if ($this->lasttime == null) {
            $this->lasttime  = $this->microtime_float();
        }
        $time           = round($this->microtime_float() - $this->lasttime, 4);
        $time           = $this->float_to_string($time, 6);
        $this->lasttime = $this->microtime_float();
        $bt             = debug_backtrace();
        $caller         = array_shift($bt);
        $line           = str_pad($caller['line'], 4, " ", STR_PAD_LEFT);

        Mage::log("(line: ".$line.") (time: " . $time .") " . $message, null, 'tillsync.log');
    }

    private function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

}