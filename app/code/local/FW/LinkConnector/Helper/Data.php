<?php
/**
 * @category    FW
 * @package     FW_LinkConnector
 * @copyright   Copyright (c) 2011 F+W Media, Inc. (http://www.fwmedia.com)
 */
class FW_LinkConnector_Helper_Data extends Mage_Core_Helper_Abstract 
{
	/**
     * Config path for using throughout the code
	 * @var string $XML_PATH
     */
    const XML_PATH = 'thirdparty/linkconnector/';
	
	/**
	 * Whether Link Connector is enabled
	 *
	 * @param mixed $store
	 * @return bool
	 */
	public function isLinkConnectorEnabled($store = null)
	{
		return Mage::getStoreConfig('thirdparty/linkconnector/active', $store);
	}

	/**
	 * Get the Link Connector Client ID
	 *
	 * @param mixed $store
	 * @return string
	 */
	public function getClientID($store = null)
	{
		return Mage::getStoreConfig('thirdparty/linkconnector/clid', $store);
	}

	/**
	 * Whether Link Connector is ready to use
	 *
	 * @param mixed $store
	 * @return bool
	 */
	public function isLinkConnectorAvailable($store = null)
	{
		$enabled = $this->isLinkConnectorEnabled($store);
		$clientid = $this->getClientID($store);
		
		if($enabled == 1 && $clientid != NULL){
			return true;
		}else{
			return false;
		}
	}
}
