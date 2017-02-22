<?php
/**
 * Copyright © 2015 Sundial. All rights reserved.
 */

namespace Sundial\CommunityCommerce\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
	
        $installer = $setup;

        $installer->startSetup();

		/**
         * Create table 'communitycommerce_charity'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('communitycommerce_charity')
        )
		->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'communitycommerce_charity'
        )
		->addColumn(
            'charity_name',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'charity_name'
        )
		->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'description'
        )
		->addColumn(
            'logo',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '64k',
            [],
            'logo'
        )
		->addColumn(
            'sort_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'sort_order'
        )
		->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'status'
        )
		->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'created_at'
        )
		/*{{CedAddTableColumn}}}*/
		
		
        ->setComment(
            'Sundial CommunityCommerce communitycommerce_charity'
        );
		
		$installer->getConnection()->createTable($table);
		/*{{CedAddTable}}*/		
		
        $installer->endSetup();

    }
}
