<?php
  
/**
 * Override for Magento's Catalog REST API
 */
class Eposnow_TillSync_Model_Catalog_Api2_Stock_Rest_Admin_V1 extends Mage_CatalogInventory_Model_Api2_Stock_Item {
	
    protected function _getObserver() {
        return Mage::getModel('Eposnow_TillSync/Observer');
    }

    protected function _update($stock)
    {
    	// Convert the array parameter to an object
    	$stock = json_decode(json_encode($stock["stock"]), FALSE);
    	$this->_getObserver()->save_eposnow_stock(array($stock));
    }
}