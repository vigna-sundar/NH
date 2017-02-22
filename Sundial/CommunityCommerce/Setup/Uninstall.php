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

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

/**
 * Uninstall Class
 */
class Uninstall implements \Magento\Framework\Setup\UninstallInterface
{
    /**
     * @var \Magento\Catalog\Setup\CategorySetupFactory
     */
    protected $categorySetupFactory;

    /**
     * @var \ParadoxLabs\Subscriptions\Helper\Data
     */
    protected $logger;

    /**
     * Init
     *
     * @param \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory
     * @param \ParadoxLabs\Subscriptions\Helper\Data $helper
     */
    public function __construct(
        \Magento\Catalog\Setup\CategorySetupFactory $categorySetupFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->categorySetupFactory = $categorySetupFactory;
        $this->logger = $logger;
    }

    /**
     * Invoked when remove-data flag is set during module uninstall.
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var \Magento\Catalog\Setup\CategorySetup $categorySetup */
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);

        /**
         * Remove product attributes
         */
        $attributes    = [
            'charity_available',
            'charity_percentage',
        ];

        foreach ($attributes as $attribute) {
            try {
                $categorySetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, $attribute);
            } catch (\Exception $e) {
                $this->logger->info((string)$e);
            }
        }

       

        /**
         * Remove tables
         */
        try {
            $setup->getConnection()->dropTable(
                $setup->getTable('communitycommerce_charity')
            );
        } catch (\Exception $e) {
            $this->logger->info((string)$e);
        }

        /**
         * Remove sales columns
         */
        try {
            $setup->getConnection()->dropColumn(
                $setup->getTable('quote'),
                'charity_id'
            );
			$setup->getConnection()->dropColumn(
                $setup->getTable('quote'),
                'charity_name'
            );
			$setup->getConnection()->dropColumn(
                $setup->getTable('quote'),
                'charity_total_amount'
            );
			$setup->getConnection()->dropColumn(
                $setup->getTable('quote_address'),
                'charity'
            );
			$setup->getConnection()->dropColumn(
                $setup->getTable('quote_address'),
                'base_charity'
            );
			
			 $setup->getConnection()->dropColumn(
                $setup->getTable('sales_order'),
                'charity_id'
            );
			$setup->getConnection()->dropColumn(
                $setup->getTable('sales_order'),
                'charity_name'
            );
			$setup->getConnection()->dropColumn(
                $setup->getTable('sales_order'),
                'charity_total_amount'
            );
			$setup->getConnection()->dropColumn(
                $setup->getTable('sales_order_address'),
                'charity'
            );
			$setup->getConnection()->dropColumn(
                $setup->getTable('sales_order_address'),
                'base_charity'
            );
        } catch (\Exception $e) {
            $this->logger->info((string)$e);
        }

        $setup->endSetup();
    }
}
