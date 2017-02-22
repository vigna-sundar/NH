<?php
namespace Sundial\CommunityCommerce\Block\Adminhtml;
class Report extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {		
        $this->_controller = 'adminhtml_report';/*block grid.php directory*/
        $this->_blockGroup = 'Sundial_CommunityCommerce';
        $this->_headerText = __('Cause Report');
        parent::_construct();
        $this->removeButton('add');
		
    }
}