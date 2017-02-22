<?php
/**
 * Paradox Labs, Inc.
 * http://www.paradoxlabs.com
 * 717-431-3330
 *
 * Need help? Open a ticket in our support system:
 *  http://support.paradoxlabs.com
 *
 * @author      Ryan Hoerr <magento@paradoxlabs.com>
 * @license     http://store.paradoxlabs.com/license.html
 */

namespace Sundial\CommunityCommerce\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Install attributes
 */
class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /**
     * @var \Magento\Catalog\Setup\CategorySetupFactory
     */
    protected $categorySetupFactory;

    /**
     * Init
     *
     * @param \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
        \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory
    ) {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Catalog\Setup\CategorySetup $categorySetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);

        $setup->startSetup();

        /**
         * Attributes:
         * subscription_active
         * subscription_allow_onetime
         * subscription_intervals
         * subscription_unit
         * subscription_length
         * subscription_price
         * subscription_init_adjustment
         */

        // Add new tab
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $categorySetup->getAttributeSetId($entityTypeId, 'Default');

        //$categorySetup->addAttributeGroup($entityTypeId, $attributeSetId, 'General', 65);       

        $categorySetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'charity_available',
            [
                'type'                  => 'int',
                'label'                 => 'Community Commerce',
                'input'                 => 'select',
                'source'                => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
                'sort_order'            => 100,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'apply_to'              => 'simple,virtual,downloadable,configurable',
                'group'                 => 'General',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => true,
                'is_filterable_in_grid' => true,
                'used_for_promo_rules'  => false,
                'required'              => false,
                'default'               => '0',
				'searchable' => true,
				'filterable' => true,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
            ]
        );
		$categorySetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'charity_percentage',
            [
                'type'                  => 'text',
                'label'                 => 'Community Commerce Percentage',
                'input'                 => 'text',
                'sort_order'            => 101,
                'global'                => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'apply_to'              => 'simple,virtual,downloadable,configurable',
                'group'                 => 'General',
                'is_used_in_grid'       => true,
                'is_visible_in_grid'    => true,
                'is_filterable_in_grid' => true,
                'used_for_promo_rules'  => false,
                'required'              => false,
                'default'               => '0',
				'searchable' => true,
				'filterable' => true,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => true,
				'frontend_class'        => 'validate-digits validate-length maximum-length-2',
				'note'                  => 'Valid range 0-99',
				
            ]
        );


        $setup->endSetup();
    }
}
