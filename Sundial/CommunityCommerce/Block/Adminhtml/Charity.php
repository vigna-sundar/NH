<?php
namespace Sundial\CommunityCommerce\Block\Adminhtml;
class Charity extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_charity';/*block grid.php directory*/
        $this->_blockGroup = 'Sundial_CommunityCommerce';
        $this->_headerText = __('Community Commerce');
        $this->_addButtonLabel = __('Add New Cause'); 
        parent::_construct();
		
    }
}