<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream;

use DavidBelicza\WebDream\Factory\WarehouseItemFactory;
use DavidBelicza\WebDream\Mediator\WarehouseManager;
use DavidBelicza\WebDream\Resource\WarehouseResource;
use DavidBelicza\WebDream\Service\WarehouseService;
use DavidBelicza\WebDream\Validator\AddItemValidator;
use DavidBelicza\WebDream\Validator\ReleaseItemValidator;
use PHPUnit\Framework\TestCase;

class WarehouseManagerTest extends TestCase
{
    /**
     * @dataProvider successInventoryMovingProvider
     *
     * @param array $addToWh
     * @param array $releaseFromWh
     *
     * @throws Exception\AddItemOverflowException
     * @throws Exception\ReleaseItemOverflowException
     */
    public function testAddAndReleaseItemSucceed(array $addToWh, array $releaseFromWh): void
    {
        $warehouseService = new WarehouseService(
            new WarehouseResource(
                $this->createWarehouses()
            )
        );

        $warehouseManager = new WarehouseManager(
            $warehouseService,
            new WarehouseItemFactory(),
            new AddItemValidator(),
            new ReleaseItemValidator()
        );

        foreach ($addToWh as $item) {
            $warehouseManager->addProductToWarehouse(
                $item['product'],
                $item['qty']
            );

            $this->assertEquals(
                $item['expectedQtyInWh'],
                $warehouseService->totalQtyBySku($item['product']->getSku())
            );
        }

        foreach ($releaseFromWh as $item) {
            $releasedQty = $warehouseManager->releaseProductFromWarehouse(
                $item['sku'],
                $item['qty']
            );

            $this->assertEquals($item['expectedReleasedQty'], $releasedQty);
        }
    }

    /**
     * @return array
     */
    public function successInventoryMovingProvider(): array
    {
        $book = FactoryProvider::productFactory()->createBookProduct(
            'book',
            'Lifestyle Book',
            10.0,
            FactoryProvider::brandFactory()->create('amazon', 4),
            'John Doe'
        );

        $tShirt = FactoryProvider::productFactory()->createFashionProduct(
            'shirt',
            'Black T-shirt',
            45.5,
            FactoryProvider::brandFactory()->create('basic', 5),
            'M'
        );

        return [
            [
                'Add to WH' => [
                    'Add product #1' => [
                        'product' => $book,
                        'qty' => 1,
                        'expectedQtyInWh' => 1
                    ],
                    [
                        'product' => $tShirt,
                        'qty' => 2,
                        'expectedQtyInWh' => 2
                    ],
                    [
                        'product' => $book,
                        'qty' => 2,
                        'expectedQtyInWh' => 3
                    ]
                ],
                'Release from WH' => [
                    [
                        'sku' => $book->getSku(),
                        'qty' => 2,
                        'expectedReleasedQty' => 2
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider overflowAddingProvider
     * @expectedException \DavidBelicza\WebDream\Exception\AddItemOverflowException
     *
     * @param array $addToWh
     */
    public function testAddItemFailed(array $addToWh): void
    {
        $warehouseService = new WarehouseService(
            new WarehouseResource(
                $this->createWarehouses()
            )
        );

        $warehouseManager = new WarehouseManager(
            $warehouseService,
            new WarehouseItemFactory(),
            new AddItemValidator(),
            new ReleaseItemValidator()
        );

        foreach ($addToWh as $item) {
            $warehouseManager->addProductToWarehouse(
                $item['product'],
                $item['qty']
            );

            $this->assertEquals(
                $item['expectedQtyInWh'],
                $warehouseService->totalQtyBySku($item['product']->getSku())
            );
        }
    }

    /**
     * @return array
     */
    public function overflowAddingProvider(): array
    {
        $book = FactoryProvider::productFactory()->createBookProduct(
            'book',
            'Lifestyle Book',
            10.0,
            FactoryProvider::brandFactory()->create('amazon', 4),
            'John Doe'
        );

        return [
            [
                'Case 1' => [
                    '6 from 7' => [
                        'product' => $book,
                        'qty' => 6,
                        'expectedQtyInWh' => 6
                    ],
                    '7 from 7' => [
                        'product' => $book,
                        'qty' => 1,
                        'expectedQtyInWh' => 7
                    ],
                    'exception' => [
                        'product' => $book,
                        'qty' => 1,
                        'expectedQtyInWh' => 7
                    ]
                ]
            ],
            [
                'Case 2' => [
                    '6 from 7' => [
                        'product' => $book,
                        'qty' => 6,
                        'expectedQtyInWh' => 6
                    ],
                    'exception' => [
                        'product' => $book,
                        'qty' => 2
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider overflowReleaseProvider
     * @expectedException \DavidBelicza\WebDream\Exception\ReleaseItemOverflowException
     *
     * @param array $addToWh
     * @param array $releaseFromWh
     *
     * @throws Exception\AddItemOverflowException
     */
    public function testReleaseItemFailed(array $addToWh, array $releaseFromWh): void
    {
        $warehouseService = new WarehouseService(
            new WarehouseResource(
                $this->createWarehouses()
            )
        );

        $warehouseManager = new WarehouseManager(
            $warehouseService,
            new WarehouseItemFactory(),
            new AddItemValidator(),
            new ReleaseItemValidator()
        );

        foreach ($addToWh as $item) {
            $warehouseManager->addProductToWarehouse(
                $item['product'],
                $item['qty']
            );
        }

        foreach ($releaseFromWh as $item) {
            $releasedQty = $warehouseManager->releaseProductFromWarehouse(
                $item['sku'],
                $item['qty']
            );

            $this->assertEquals($item['expectedReleasedQty'], $releasedQty);
        }
    }

    /**
     * @return array
     */
    public function overflowReleaseProvider(): array
    {
        $book = FactoryProvider::productFactory()->createBookProduct(
            'book',
            'Lifestyle Book',
            10.0,
            FactoryProvider::brandFactory()->create('amazon', 4),
            'John Doe'
        );

        return [
            [
                'Add to WH' => [
                    [
                        'product' => $book,
                        'qty' => 3
                    ],
                    [
                        'product' => $book,
                        'qty' => 1
                    ]
                ],
                'Release from WH' => [
                    'Ok' => [
                        'sku' => $book->getSku(),
                        'qty' => 3,
                        'expectedReleasedQty' => 3
                    ],
                    'Exception 1' => [
                        'sku' => $book->getSku(),
                        'qty' => 2
                    ]
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    private function createWarehouses(): array
    {
        $warehouse1 = FactoryProvider::warehouseFactory()->create(
            'WH 1',
            'address 1',
            2,
            FactoryProvider::warehouseItemCollectionFactory()->create([])
        );

        $warehouse2 = FactoryProvider::warehouseFactory()->create(
            'WH 2',
            'address 2',
            5,
            FactoryProvider::warehouseItemCollectionFactory()->create([])
        );

        return [
            1 => $warehouse1,
            2 => $warehouse2
        ];
    }
}
