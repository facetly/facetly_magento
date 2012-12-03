<?php
	require_once '../../app/Mage.php';
	$consumer_key = Mage::getStoreConfig('facetly_consumer_key');
	$api_server = Mage::getStoreConfig('facetly_server');
	$limit = Mage::getStoreConfig('facetly_limit');
	$add_var = Mage::getStoreConfig('facetly_additional_variable');
?>			
var facetly = {
	"key" : "<?php echo $consumer_key ?>",
	"server" : "<?php echo $api_server ?>",
	"file" : "find?<?php echo $add_var ?>",
	"baseurl" : "<?php echo Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) ?>",
	"limit" : <?php echo $limit ?>
}
				
