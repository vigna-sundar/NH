<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sundial\CommunityCommerce\Controller\Adminhtml\Charity;

use Magento\Backend\Block\Widget\Grid\ExportInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;

class exportCsv extends Action
{
	protected $_fileFactory;
    /**
     * Export new accounts report grid to CSV format
     *
     * @return ResponseInterface
     */
	  public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory
    ) {
        $this->_fileFactory = $fileFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $this->_view->loadLayout();
        $fileName = 'charity_report.csv';
        /** @var ExportInterface $exportBlock */
        //$exportBlock = $this->_view->getLayout()->getChildBlock('charity.export', 'grid.export');
        $content = $this->_view->getLayout()->createBlock('Sundial\CommunityCommerce\Block\Adminhtml\Report\Grid');
        return $this->_fileFactory->create(
            $fileName,
            $content->getCsvFile($fileName),
            DirectoryList::VAR_DIR
        );
    }
}
