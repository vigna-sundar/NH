<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sundial\CommunityCommerce\Model\Total;
class Invoice extends \Magento\Sales\Model\Order\Invoice\Total\AbstractTotal
{
  public function collect(\Magento\Sales\Model\Order\Invoice $invoice) {
		$order = $invoice->getOrder();
		$orderId = 	$order->getId();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();			
		$block = $objectManager->create('Sundial\CommunityCommerce\Block\Charity\Charity');
		$charityOrder = $block->getCharityOrderCollection($orderId);
		$charityAmount = $charityOrder->getCharityTotalAmount();		
		$invoice->setGrandTotal($invoice->getGrandTotal() + $charityAmount);
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $charityAmount);
        return $this;
    } 
}