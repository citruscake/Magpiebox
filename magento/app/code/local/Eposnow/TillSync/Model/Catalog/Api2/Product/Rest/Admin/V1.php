<?php
  
/**
 * Override for Magento's Catalog REST API
 */
class Eposnow_TillSync_Model_Catalog_Api2_Product_Rest_Admin_V1 extends Mage_Catalog_Model_Api2_Product_Rest {

    protected function _getObserver() {
        return Mage::getModel('Eposnow_TillSync/Observer');
    }

    protected function _update($product)
    {
    	// Convert the array parameter to an object
    	$product = json_decode(json_encode($product["product"]), FALSE);
    	$this->_getObserver()->save_eposnow_products($product);
    }

    protected function _retrieve()
    {    	

        $eposnowid = $this->getRequest()->getParam('eposnowid');

        if (! $eposnowid) {
            return 0;
        }

        $magentoid = Mage::getResourceModel('catalog/product_collection');
        $magentoid->addAttributeToFilter('epos_now_id',  $eposnowid);
        $magentoid->addAttributeToSelect('entity_id');

        if (! $magentoid || ! $magentoid->getFirstItem() || ! $magentoid->getFirstItem()->getId()) {
            return 0;
        }

    	return $magentoid->getFirstItem()->getId();
    }
}