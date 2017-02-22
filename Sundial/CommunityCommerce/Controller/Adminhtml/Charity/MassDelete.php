<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sundial\CommunityCommerce\Controller\Adminhtml\Charity;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Sundial\CommunityCommerce\Model\ResourceModel\Charity\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Massactions filter
     *
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param Context $context
     * @param Builder $productBuilder
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $productDeleted = 0;
        foreach ($collection->getItems() as $product) {
            $product->delete();
            $productDeleted++;
        }
        $this->messageManager->addSuccess(
            __('A total of %1 record(s) have been deleted.', $productDeleted)
        );
        $this->_redirect('*/*/');
    }
}
