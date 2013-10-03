<?php 

class Mage_Magpiebox_Product_Model_Api extends Mage_Api_Model_Resource_Abstract
{

    public function create($productData)
    {
	return true;
    }

    public function info($productId)
    {
	//$product = Mage::getModel('catalog/product')->load($productId);
	return true;
    }

    public function items($filters)
    {
	return true;
    }

    public function update($productId, $productData)
    {
	return true;
    }

    public function delete($productId)
    {
	return true;
    }
}

?>