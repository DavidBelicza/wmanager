<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream;

use DavidBelicza\WebDream\Factory\BrandFactory;
use DavidBelicza\WebDream\Factory\ProductFactory;
use DavidBelicza\WebDream\Factory\WarehouseFactory;
use DavidBelicza\WebDream\Factory\WarehouseItemCollectionFactory;
use DavidBelicza\WebDream\Factory\WarehouseItemFactory;

class FactoryProvider
{
    /**
     * @return BrandFactory
     */
    public static function brandFactory(): BrandFactory
    {
        return new BrandFactory();
    }

    /**
     * @return ProductFactory
     */
    public static function productFactory(): ProductFactory
    {
        return new ProductFactory();
    }

    /**
     * @return WarehouseFactory
     */
    public static function warehouseFactory(): WarehouseFactory
    {
        return new WarehouseFactory();
    }

    /**
     * @return WarehouseItemCollectionFactory
     */
    public static function warehouseItemCollectionFactory(): WarehouseItemCollectionFactory
    {
        return new WarehouseItemCollectionFactory();
    }

    /**
     * @return WarehouseItemFactory
     */
    public static function warehouseItemFactory(): WarehouseItemFactory
    {
        return new WarehouseItemFactory();
    }
}
