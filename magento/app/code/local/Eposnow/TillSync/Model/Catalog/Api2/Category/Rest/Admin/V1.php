<?php
  
/**
 * Override for Magento's Catalog REST API
 */
class Eposnow_TillSync_Model_Catalog_Api2_Category_Rest_Admin_V1 extends Mage_Api2_Model_Resource {
  
    protected function _getObserver() {
        return Mage::getModel('Eposnow_TillSync/Observer');
    }

    protected function _update($category)
    {
    	// Convert the array parameter to an object
    	$category = json_decode(json_encode($category["category"]), FALSE);

        // get the magento ids for the parents
        foreach ($category[0]->parents as $parent) {            
            $magentoid = Mage::getResourceModel('catalog/category_collection');
            $magentoid->addAttributeToFilter('epos_now_id',  $parent->eposnow_id);
            $magentoid->addAttributeToSelect('entity_id');

            if ($magentoid && $magentoid->getFirstItem() && $magentoid->getFirstItem()->getId()) {
                $parent->id = $magentoid->getFirstItem()->getId();
            }
        }

    	$this->_getObserver()->save_eposnow_categories($category, true);
    }

    protected function _delete()
    {
        $id = $this->getRequest()->getParam('id');                 
        $category = Mage::getModel('catalog/category')->load($id);
        $category->delete();
    }

    protected function _retrieve()
    {    	
        $eposnowid = $this->getRequest()->getParam('eposnowid');

        if (! $eposnowid) {
            return 0;
        }

        $magentoid = Mage::getResourceModel('catalog/category_collection');
        $magentoid->addAttributeToFilter('epos_now_id',  $eposnowid);
        $magentoid->addAttributeToSelect('entity_id');

        if (! $magentoid || ! $magentoid->getFirstItem() || ! $magentoid->getFirstItem()->getId()) {
            return 0;
        }

    	return $magentoid->getFirstItem()->getId();
    }
}