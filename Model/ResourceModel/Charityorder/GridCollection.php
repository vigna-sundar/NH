<?php
namespace Sundial\CommunityCommerce\Model\ResourceModel\Charityorder;

/**
 * GridCollection Class
 */
class GridCollection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    /**
     * Init collection select
     *
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();
		$this->getSelect()
				->columns('SUM(charity_total_amount) as charity_total_amount')
				->group('charity_id');
		return $this;
    }
}
