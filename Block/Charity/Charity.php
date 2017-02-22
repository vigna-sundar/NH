<?php
namespace Sundial\CommunityCommerce\Block\Charity;
class Charity extends \Magento\Framework\View\Element\Template
{
	 protected $charityFactory;
	 protected $charityQuoteFactory;
	 protected $charityOrderFactory;
	 protected $cart;
	 
	 public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Sundial\CommunityCommerce\Model\ResourceModel\Charity\CollectionFactory $charityCollectionFactory,
		\Sundial\CommunityCommerce\Model\ResourceModel\Charityquote\CollectionFactory $charityQuoteCollectionFactory,
		\Sundial\CommunityCommerce\Model\ResourceModel\Charityorder\CollectionFactory $charityOrderCollectionFactory,
		\Magento\Catalog\Model\Product\Attribute\Repository $productAttributeRepository,
		\Magento\Checkout\Model\Cart $cart
    ) {
		
        parent::__construct($context);
        $this->charityFactory = $charityCollectionFactory;       
        $this->charityQuoteFactory = $charityQuoteCollectionFactory;       
        $this->charityOrderFactory = $charityOrderCollectionFactory;       
        $this->cart = $cart;
    }
	//load quote id and get that charity id  
	public function getCharityId($quoteId){		
		$charityDataCollection = $this->charityQuoteFactory->create()
								  ->addFieldToFilter('quote_id', $quoteId)->getFirstItem();	
		$charityId = $charityDataCollection->getCharityId();		
		return $charityId;
	}	
	public function getQuoteId(){
		$items = $this->cart->getQuote()->getAllItems();
		foreach($items as $item):
			return $item->getQuoteId();
		endforeach;
	}
	public function getProductCharityOptions(){
		$items = $this->cart->getQuote()->getAllItems();
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		foreach($items as $item):			
			$_product = $objectManager->get('Magento\Catalog\Model\Product')->load($item->getProductId());
			$charityPercentage = $_product->getResource()->getAttribute('charity_percentage')->getFrontend()->getValue($_product);
			$charityAvailable  = $_product->getResource()->getAttribute('charity_available')->getFrontend()->getValue($_product);
			if($charityAvailable == 'Yes' || $charityAvailable == 'yes'){
				return 1;				
			}
		endforeach;
	}
	public function getAllCharity(){
		$charityCollection = $this->charityFactory->create()
								  ->addFieldToFilter('status', 1);
		$charityCollection->setOrder('sort_order','ASC');
		return $charityCollection;
	}
	//load quote id and get that charity id 
	public function getCharityDetails($charityId){
		/* $charityId = $this->cart->getQuote()->getCharityId(); */
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();			
		$charityDetails = $objectManager->get('Sundial\CommunityCommerce\Model\Charity')->load($charityId);
		return $charityDetails;
	}
	//charity quote collection for observer:
	public function getCharityQuoteCollection($quoteId){
		$charityDataCollection = $this->charityQuoteFactory->create()
								  ->addFieldToFilter('quote_id', $quoteId)->getFirstItem();			
		return $charityDataCollection;
	}
	//charity order collection:
	public function getCharityOrderCollection($orderId){
		$charityOrderData = $this->charityOrderFactory->create()
									->addFieldToFilter('order_id', $orderId)->getFirstItem();
		return $charityOrderData;
	}
}
