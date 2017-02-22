<?php
namespace Sundial\CommunityCommerce\Controller\Charity;
class Charity extends \Magento\Checkout\Controller\Cart
{ 
	protected $quoteRepository;
	protected $charityCollectionFactory;
	protected $charityQuoteFactory;
	
	 public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
		\Sundial\CommunityCommerce\Model\ResourceModel\Charity\CollectionFactory $charityCollectionFactory,
	\Sundial\CommunityCommerce\Model\ResourceModel\Charityquote\CollectionFactory $charityQuoteCollectionFactory
    ) {
        parent::__construct(
            $context,
            $scopeConfig,
            $checkoutSession,
            $storeManager,
            $formKeyValidator,
            $cart
        );
        $this->quoteRepository = $quoteRepository;
		$this->charityCollectionFactory = $charityCollectionFactory;
		$this->charityQuoteFactory = $charityQuoteCollectionFactory;   
    }
	public function execute()
    {
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();  					
		$block = $objectManager->create('Sundial\CommunityCommerce\Block\Charity\Charity');			
        $charity = $this->getRequest()->getParam('remove') == 1
            ? ''
            : trim($this->getRequest()->getParam('charity_id'));
			//add charity
			$cartQuote = $this->cart->getQuote();			
			if($charity){
				$model = $objectManager->create('Sundial\CommunityCommerce\Model\Charityquote');
				$escaper = $this->_objectManager->get('Magento\Framework\Escaper');
				$charityDesc = $this->_objectManager->get('Sundial\CommunityCommerce\Model\Charity')->load($charity);
				//print_r($charityDesc->getData());
				//exit;
				
				$checkQuoteExists = $this->charityQuoteFactory->create()
								  ->addFieldToFilter('quote_id', $block->getQuoteId())->getFirstItem();		  
				if($checkQuoteExists->getQuoteId() != null){
					$model = $model->load($checkQuoteExists->getId());
					$model->setCharityId($charityDesc->getId());
					$model->setCharityName($charityDesc->getCharityName());
					//echo "quote id exists!!!";
				}else{
					$model->setCharityId($charityDesc->getId());
					$model->setCharityName($charityDesc->getCharityName());
					$model->setQuoteId($block->getQuoteId());
				}					
				$this->messageManager->addSuccess(__('Your charity amount is added to "%1".',
						$escaper->escapeHtml($charityDesc->getCharityName())));				
			}else{
			//remove charity
				$model = $this->charityQuoteFactory->create()
								  ->addFieldToFilter('quote_id', $block->getQuoteId())->getFirstItem();			
				$model->setCharityId('');
				$model->setCharityName('');
				$model->setQuoteId($block->getQuoteId());					
				$this->messageManager->addSuccess(__('You cancelled the charity.'));				
			}
			try{			
				$model->save();
			}catch (\Magento\Framework\Exception\LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
        }
		return $this->_goBack();
    }
}