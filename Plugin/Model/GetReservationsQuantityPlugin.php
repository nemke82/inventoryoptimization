<?php
namespace Nemke82\InventoryOptimization\Plugin\Model;

use Magento\Inventory\Model\ResourceModel\GetReservationsQuantity as CoreGetReservationsQuantity;
use Magento\Framework\App\ResourceConnection;

class GetReservationsQuantityPlugin
{
    private $resourceConnection;

    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    public function aroundExecute(
        CoreGetReservationsQuantity $subject,
        callable $proceed,
        string $sku,
        int $stockId
    ): float {
        $connection = $this->resourceConnection->getConnection();
        $aggregatedViewName = $this->resourceConnection->getTableName('inventory_reservation_aggregated');

        $select = $connection->select()
            ->from(
                $aggregatedViewName,
                ['sku', 'quantity']
            )->where(
                'stock_id = ?',
                $stockId
            )->where(
                'sku IN (?)',
                $sku
            );

        $reservationsData = $connection->fetchPairs($select);

        // Handle the case when $reservationsData is empty or doesn't contain the expected sku
        if (empty($reservationsData) || !isset($reservationsData[$sku])) {
            return 0.0;
        }

        return (float) $reservationsData[$sku];
    }
}