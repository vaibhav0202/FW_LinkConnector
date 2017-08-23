<?php
/**
 * @category    FW
 * @package     FW_LinkConnector
 * @copyright   Copyright (c) 2011 F+W Media, Inc. (http://www.fwmedia.com)
 * @author		J.P. Daniel (jp.daniel@fwmedia.com)
 */
class FW_LinkConnector_Block_Linkconnector extends Mage_Core_Block_Text
{	
	/**
	 * Render the Link Connector tracking scripts
	 * @return string
	 */
	protected function _toHtml()
	{
		$return = '';
		
		// Load Link Connector Helper
		$helper = Mage::helper('fw_linkconnector');	
		$storeid = Mage::app()->getStore()->getStoreId();
		
		// Make sure Link Connector is enabled and all required data is configured
		if ($helper->isLinkConnectorAvailable($storeid))
		{			
			// Check if there is OrderIds set
			if (($orderIds = $this->getOrderIds()) && is_array($orderIds))
			{			
				// Generate URL for Link Connector conversion
				$CAURL = 'http'.(Mage::app()->getStore()->isCurrentlySecure() ? 's' : '').'://www.linkconnector.com';
				
				// Get a collection of the orders from the DB
				$collection = Mage::getResourceModel('sales/order_collection')
					->addFieldToFilter('entity_id', array('in' => $orderIds));					
				
				foreach ($collection as $order) // Output for each order
				{
					$return .= sprintf('
<script src="%1$s/tmjs.php?lc=%2$s&oid=%3$s&amt=%4$s"></script>
<noscript><img border="0" src="%1$s/tm.php?lc=%2$s&oid=%3$s&amt=%4$s"></noscript>',
						$this->escapeUrl($CAURL),						// Link Connector URL
						$this->escapeUrl($helper->getClientID()),		// Client ID from config
						$this->escapeUrl($order->getIncrementId()),		// Order ID
						$this->escapeUrl(number_format($order->getBaseGrandTotal(), 2, '.', ''))	// Order Total
					);
		        }
			}
		}
		return $return;
	}
}