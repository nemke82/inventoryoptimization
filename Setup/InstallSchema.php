<?php
namespace Nemke82\InventoryOptimization\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $connection = $setup->getConnection();
        $inventoryReservationTableName = $setup->getTable('inventory_reservation');
        $aggregatedViewName = $setup->getTable('inventory_reservation_aggregated_view');

        // Check if the view exists
        $viewExists = $connection->fetchOne(
            "SELECT COUNT(*) FROM INFORMATION_SCHEMA.VIEWS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?",
            [$aggregatedViewName]
        );

        // If the view doesn't exist, create it
        if (!$viewExists) {
            $connection->query(
                "CREATE VIEW {$aggregatedViewName} AS
                SELECT sku, stock_id, SUM(quantity) AS quantity
                FROM {$inventoryReservationTableName}
                GROUP BY sku, stock_id"
            );
        }

        $setup->endSetup();
    }
}