<?php
namespace Sundial\CommunityCommerce\Block\Adminhtml\Charity\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
		
        parent::_construct();
        $this->setId('checkmodule_charity_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Cause Information'));
    }
}