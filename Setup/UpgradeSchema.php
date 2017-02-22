<?php
namespace Sundial\CommunityCommerce\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
		$installer = $setup;
        $installer->startSetup();
		
        if (version_compare($context->getVersion(), '1.1.0', '<=')) {
			/**
			 * Create table 'communitycommerce_quote_charity'
			*/
			$table = $installer->getConnection()->newTable(
				$installer->getTable('communitycommerce_quote_charity')
			)
			->addColumn(
				'id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
				'id'
			)
			->addColumn(
				'quote_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				['nullable' => true],
				'quote_id'
			)
			->addColumn(
				'charity_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				['nullable' => true],
				'charity_id'
			)
			->addColumn(
				'charity_name',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				'64k',
				['nullable' => true],
				'charity_name'
			)
			->addColumn(
				'charity_total_amount',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				'64k',
				['nullable' => true],
				'charity_total_amount'
			)
			->addColumn(
				'charity',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				'64k',
				['nullable' => true],
				'Charity Amount'
			)
			->addColumn(
				'base_charity',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				null,
				['nullable' => true],
				'Base Charity Amount'
			)				
			->setComment(
				'Sundial CommunityCommerce communitycommerce_quote_charity'
			);
			
			$installer->getConnection()->createTable($table);	

			/**
			 * Create table 'communitycommerce_order_charity'
			*/
			$table = $installer->getConnection()->newTable(
				$installer->getTable('communitycommerce_order_charity')
			)
			->addColumn(
				'id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
				'id'
			)			
			->addColumn(
				'order_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				['nullable' => true],
				'order_id'
			)
			->addColumn(
				'charity_id',
				\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
				null,
				['nullable' => true],
				'charity_id'
			)
			->addColumn(
				'charity_name',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				'64k',
				['nullable' => true],
				'charity_name'
			)
			->addColumn(
				'charity_total_amount',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				'64k',
				['nullable' => true],
				'charity_total_amount'
			)
			->addColumn(
				'charity',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				'64k',
				['nullable' => true],
				'Charity Amount'
			)
			->addColumn(
				'base_charity',
				\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
				null,
				['nullable' => true],
				'Base Charity Amount'
			)			
			->setComment(
				'Sundial CommunityCommerce communitycommerce_order_charity'
			);
			
			$installer->getConnection()->createTable($table);			
        }
	 $installer->endSetup();
    }    
}
?>