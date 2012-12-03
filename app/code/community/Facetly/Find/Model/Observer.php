<?php

class Facetly_Find_Model_Observer
{

    public function logUpdate(Varien_Event_Observer $observer){

        $product = $observer->getEvent()->getProduct();
        $status = $product->getStatus();
		
		if($status == 1){
			$data = $product->getData();
			$id = $data['entity_id'];
			$product = Mage::getModel('find/custom');
			$loaded_data = $product->loadProductById($id);
			$message = $product->pushItem($loaded_data);
		}
		else{
			$data = $product->getData();
			$id = $data['entity_id'];
			$product = Mage::getModel('find/custom');
			$message = $product->deleteItem($id);
		}

    }
	
	 public function logDelete(Varien_Event_Observer $observer) {
        $product = $observer->getEvent()->getProduct();

		$data = $product->getData();
		$id = $data['entity_id'];
		$product = Mage::getModel('find/custom');
		$message = $product->deleteItem($id);
    }
}