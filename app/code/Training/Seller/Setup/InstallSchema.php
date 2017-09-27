<?php

namespace Training\Seller\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Training\Seller\Api\Data\SellerInterface;

class InstallSchema implements InstallSchemaInterface {


    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable(SellerInterface::TABLE_NAME))
            ->addColumn(
                SellerInterface::FIELD_SELLER_ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Seller ID'
            )
            ->addColumn(
                SellerInterface::FIELD_IDENTIFIER,
                Table::TYPE_TEXT,
                64,
                ['nullable' => false],
                'Identifier'
            )
            ->addColumn(
                SellerInterface::FIELD_NAME,
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )
            ->addColumn(
                SellerInterface::FIELD_CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Creation Time'
            )
            ->addColumn(
                SellerInterface::FIELD_UPDATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Update Time'
            )
            ->addIndex(
                $setup->getIdxName(
                    SellerInterface::TABLE_NAME,
                    [SellerInterface::FIELD_IDENTIFIER],
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                [SellerInterface::FIELD_IDENTIFIER],
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->setComment(
                'Training - Seller'
            );

        $setup->startSetup();
        $setup->getConnection()->createTable($table);
        $setup->endSetup();
    }

}