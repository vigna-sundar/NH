<?php
namespace Sundial\CommunityCommerce\Observer;

//use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
class Submitorder implements ObserverInterface
{
	protected $logger;
    public function __construct(
		\Psr\Log\LoggerInterface $logger, array $data = []
	) {
		$this->logger = $logger;		
	}

	public function execute(\Magento\Framework\Event\Observer $observer) {		
		$order = $observer->getEvent()->getOrder();
		$order_id = $order->getID();
		$order_number = $order->getIncrementId();
		$quote_id = $order->getQuoteId();		
		if($order_number){
			$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
			$model = $objectManager->create('Sundial\CommunityCommerce\Model\Charityorder');
			$block = $objectManager->create('Sundial\CommunityCommerce\Block\Charity\Charity');			
			$charity = $block->getCharityQuoteCollection($quote_id);
			$model->setOrderId($order_id);	
			$model->setCharityId($block->getCharityId($quote_id));	
			$model->setCharityName($charity->getCharityName());	
			$model->setCharity($charity->getCharity());	
			$model->setCharityTotalAmount($charity->getCharityTotalAmount());	
			$model->setBaseCharity($charity->getBaseCharity());	
			try{		
				$model->save();
			}catch(\Magento\Framework\Exception\LocalizedException $e){
				$this->messageManager->addError($e->getMessage());
			}
		}
		/* $this->logger->addDebug('Order ID: ' . $order_id . ', order_number: ' . $order_number . ', quote_id: '. $quote_id. ', charityAmount: '. $charity->getCharityName());	 */	
	}
}
?>