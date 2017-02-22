<?php
namespace Sundial\CommunityCommerce\Block\Adminhtml\Charity;

/**
 * CMS block edit form container
 */
class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected function _construct()
    {
		$this->_objectId = 'id';
        $this->_blockGroup = 'Sundial_CommunityCommerce';
        $this->_controller = 'adminhtml_charity';
		$this->setTitle(__('Community Commerce'));

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Cause'));
        $this->buttonList->update('delete', 'label', __('Delete Cause'));

        $this->buttonList->add(
            'saveandcontinue',
            array(
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => array(
                    'mage-init' => array('button' => array('event' => 'saveAndContinueEdit', 'target' => '#edit_form'))
                )
            ),
            -100
        );

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('block_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'hello_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'hello_content');
                }
            }
        ";
    }

    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('checkmodule_checkmodel')->getId()) {
            return __("Edit Cause '%1'", $this->escapeHtml($this->_coreRegistry->registry('checkmodule_checkmodel')->getTitle()));
        } else {
            return __('New Cause');
        }
    }
}
