<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sundial\CommunityCommerce\Model\Total;


class Charity extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
   /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */
    protected $quoteValidator = null;
	protected $charityQuoteFactory;

    public function __construct(
	\Magento\Quote\Model\QuoteValidator $quoteValidator,
	\Magento\Checkout\Model\Cart $cart,
	\Sundial\CommunityCommerce\Model\ResourceModel\Charityquote\CollectionFactory $charityQuoteCollectionFactory)
    {
        $this->quoteValidator = $quoteValidator;
		$this->charityQuoteFactory = $charityQuoteCollectionFactory;
		$this->cart = $cart;
    }
  public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);


        //$exist_amount = 0; //$quote->getFee(); 
       // $charity = 100; //Excellence_Fee_Model_Fee::getFee();		
		$model = $this->getCharityQuote();						  
		$charityId = $model->getCharityId();
        $balance = $this->getCharityAmount();
		if($charityId){
			$total->setTotalAmount('charity', $balance);
			$total->setBaseTotalAmount('charity', $balance);        
			$model->setCharity($balance);
			$model->setBaseCharity($balance);
			$total->setGrandTotal($total->getGrandTotal() + $balance);
			$total->setBaseGrandTotal($total->getBaseGrandTotal() + $balance);
			$model->setCharityTotalAmount($balance);
			try{				
				$model->save();
				}catch (\Magento\Framework\Exception\LocalizedException $e) {
				$this->messageManager->addError($e->getMessage());
			}
			return $this;
		}else{
			$getCharity = $model->getCharity();
			if($getCharity != null){				
				$total->setGrandTotal($total->getGrandTotal() - $getCharity);
				$total->setBaseGrandTotal($total->getBaseGrandTotal() - $getCharity);			
				$model->setCharity(0);
				$model->setBaseCharity(0);
				$model->setCharityTotalAmount(0);
				$model->setQuoteId('');
				try{				
					$model->save();
					}catch (\Magento\Framework\Exception\LocalizedException $e) {
					$this->messageManager->addError($e->getMessage());
				}
			}
			return $this;
		}
    } 

    
    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array|null
     */
    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {		
		$model = $this->getCharityQuote();		
			return [
				'code' => 'charity',
				'title' => 'Charity',
				'value' => $model->getCharity()
			];
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Charity');
    }
	public function getCharityAmount(){
	$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$items = $this->cart->getQuote()->getAllItems();
		$totalAmount = 0;
		foreach($items as $item){
			$_product = $objectManager->get('Magento\Catalog\Model\Product')->load($item->getProductId());
			$charityPercentage = $_product->getResource()->getAttribute('charity_percentage')->getFrontend()->getValue($_product);
			$charityAvailable  = $_product->getResource()->getAttribute('charity_available')->getFrontend()->getValue($_product);
			if($charityAvailable == 'Yes' || $charityAvailable == 'yes'){
				$itemTotal = ($item->getRowTotal() * $charityPercentage)/100;
				$totalAmount += $itemTotal;
			}
		}
		return $totalAmount;
	}	
	public function getCharityQuote(){
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$block = $objectManager->create('Sundial\CommunityCommerce\Block\Charity\Charity');	
		$model = $this->charityQuoteFactory->create()
								  ->addFieldToFilter('quote_id', $block->getQuoteId())->getFirstItem();
		return $model;
	}
}