<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_CustomPrice
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\CustomPrice\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Zend_Db_Exception;

/**
 * Class InstallSchema
 * @package Mageplaza\CustomPrice\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    const CUSTOMPRICE_RULES = 'mageplaza_customprice_rules';

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();

        if ($installer->tableExists(self::CUSTOMPRICE_RULES)) {
            $connection->dropTable($installer->getTable(self::CUSTOMPRICE_RULES));
        }

        $table = $connection->newTable($installer->getTable(self::CUSTOMPRICE_RULES));
        $columns = $this->getFreeGiftColumns();
        foreach ($columns as $name => $column) {
            $table->addColumn($name, $column['type'], $column['size'], $column['options'], $column['comment']);
        }
        $table->setComment('Custom Price Rules Table');
        $connection->createTable($table);

        $installer->endSetup();
    }

    /**
     * @return array
     */
    public function getFreeGiftColumns()
    {
        return [
            'rule_id' => [
                'type' => Table::TYPE_INTEGER,
                'size' => null,
                'options' => [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true
                ],
                'comment' => 'Rule ID',
            ],
            'custom_price' => [
                'type' => Table::TYPE_DECIMAL,
                'size' => '12,2',
                'options' => ['nullable' => false],
                'comment' => 'Custom Price',
            ],
            'email' => [
                'type' => Table::TYPE_TEXT,
                'size' => 255,
                'options' => ['nullable' => false],
                'comment' => 'Customer Email',
            ],
            'sku' => [
                'type' => Table::TYPE_TEXT,
                'size' => 255,
                'options' => ['nullable' => false],
                'comment' => 'Product SKU',
            ],
            'from_date' => [
                'type' => Table::TYPE_DATE,
                'size' => null,
                'options' => [],
                'comment' => 'Active From',
            ],
            'to_date' => [
                'type' => Table::TYPE_DATE,
                'size' => null,
                'options' => [],
                'comment' => 'Active To',
            ],
            'created_at' => [
                'type' => Table::TYPE_TIMESTAMP,
                'size' => null,
                'options' => ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'comment' => 'Created At',
            ]
        ];
    }
}
