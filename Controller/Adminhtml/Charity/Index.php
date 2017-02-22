<?php
namespace Sundial\CommunityCommerce\Controller\Adminhtml\Charity;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;


class Index extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $resultPage;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
		$this->resultPage = $this->resultPageFactory->create();  
		$this->resultPage->setActiveMenu('Sundial_Charity::sundial_charity');
		$this->resultPage->getConfig()->getTitle()->set((__('Community Commerce')));
		return $this->resultPage;
    }
}
