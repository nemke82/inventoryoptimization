<?php
namespace Nemke82\InventoryOptimization\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $connection = $setup->getConnection();
            $inventoryReservationTableName = $setup->getTable('inventory_reservation');
            $aggregatedViewName = $setup->getTable('inventory_reservation_aggregated_view');

            // Drop the view if it already exists
            $connection->query("DROP VIEW IF EXISTS {$aggregatedViewName}");

            // Create the view
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
