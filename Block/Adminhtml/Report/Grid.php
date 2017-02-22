<?php
namespace Sundial\CommunityCommerce\Block\Adminhtml\Report;


class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory]
     */
    protected $_setsFactory;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Type
     */
    protected $_type;

    /**
     * @var \Magento\Catalog\Model\Product\Attribute\Source\Status
     */
    protected $_status;
	protected $_collectionFactory;
	protected $_charityOrderCollectionFactory;

    /**
     * @var \Magento\Catalog\Model\Product\Visibility
     */
    protected $_visibility;

    /**
     * @var \Magento\Store\Model\WebsiteFactory
     */
    protected $_websiteFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Store\Model\WebsiteFactory $websiteFactory
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $setsFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Catalog\Model\Product\Type $type
     * @param \Magento\Catalog\Model\Product\Attribute\Source\Status $status
     * @param \Magento\Catalog\Model\Product\Visibility $visibility
     * @param \Magento\Framework\Module\Manager $moduleManager
     * @param array $data
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Store\Model\WebsiteFactory $websiteFactory,
		\Magento\Sales\Model\ResourceModel\Order\Collection $orderCollectionFactory,
		\Sundial\CommunityCommerce\Model\ResourceModel\Charityorder\CollectionFactory $charityOrderCollectionFactory,
        \Magento\Framework\Module\Manager $moduleManager,
        array $data = []
    ) {
		
		$this->_collectionFactory = $orderCollectionFactory;
		$this->_charityOrderCollectionFactory = $charityOrderCollectionFactory;
        $this->_websiteFactory = $websiteFactory;
        $this->moduleManager = $moduleManager;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();	
        $this->setId('reportGrid');
        $this->setDefaultSort('charit_name');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(false);       
    }

    /**
     * @return Store
     */
    protected function _getStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }

    /**
     * @return $this
     */
    protected function _prepareCollection()
    {
		try{
		   $collection =$this->_charityOrderCollectionFactory->create();		  
		   $collection->getSelect()
						->columns('SUM(charity_total_amount) as charity_total_amount')
						->group('charity_id');
		   $this->setCollection($collection);
		
		   parent::_prepareCollection();		  
		   return $this;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();die;
		}
    }

    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */

    /**
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
		
		$this->addColumn(
            'charity_name',
            [
                'header' => __('Cause Name'),
                'index' => 'charity_name',
                'class' => 'charity_name'
            ]
        );
		$this->addColumn(
            'charity_total_amount',
            [
                'header' => __('Total Earnings'),
                'index' => 'charity_total_amount',
                'class' => 'charity_total_amount'
            ]
        );
		/* $this->addColumn(
            'created_at',
            [
                'header' => __('Date Range'),
                'index' => 'created_at',
                'class' => 'created_at',
				'type'      => 'datetime'
            ]
        ); */
        $block = $this->getLayout()->getBlock('grid.bottom.links');
        if ($block) {
            $this->setChild('grid.bottom.links', $block);
        }
		$this->addExportType('*/*/exportCsv', __('CSV'));
        return parent::_prepareColumns();
    }

}
