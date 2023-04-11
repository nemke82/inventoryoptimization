<?php
namespace Nemke82\InventoryOptimization\Test\Unit\Plugin\Model;

use Nemke82\InventoryOptimization\Plugin\Model\GetReservationsQuantityPlugin;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use Magento\Inventory\Model\ResourceModel\GetReservationsQuantity as CoreGetReservationsQuantity;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Select;

class GetReservationsQuantityPluginTest extends TestCase
{
    protected $objectManager;
    protected $getReservationsQuantityPlugin;
    protected $getReservationsQuantity;

    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);
        $this->getReservationsQuantity = $this->getMockBuilder(CoreGetReservationsQuantity::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Mock ResourceConnection and Connection objects
        $resourceConnectionMock = $this->getMockBuilder(ResourceConnection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $connectionMock = $this->getMockBuilder(AdapterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $selectMock = $this->getMockBuilder(Select::class)
            ->disableOriginalConstructor()
            ->getMock();

        $resourceConnectionMock->method('getConnection')->willReturn($connectionMock);
        $resourceConnectionMock->method('getTableName')->willReturn('inventory_reservation_aggregated');
        $connectionMock->method('select')->willReturn($selectMock);
        $selectMock->method('from')->willReturnSelf();
        $selectMock->method('where')->willReturnSelf();

        $this->getReservationsQuantityPlugin = $this->objectManager->getObject(
            GetReservationsQuantityPlugin::class,
            ['resourceConnection' => $resourceConnectionMock]
        );
    }

    public function testAroundExecute()
{
    // Replace these variables with appropriate test values
    $testSku = '810020230005';
    $testStockId = 1;
    $expectedResult = 10;

    $proceed = function ($sku, $stockId) use ($expectedResult) {
        return $expectedResult;
    };

    // Call the aroundExecute method and store the result
    $result = $this->getReservationsQuantityPlugin->aroundExecute(
        $this->getReservationsQuantity,
        $proceed,
        $testSku,
        $testStockId
    );

    // Assert that the result is a float
    $this->assertIsFloat($result);
}

}
