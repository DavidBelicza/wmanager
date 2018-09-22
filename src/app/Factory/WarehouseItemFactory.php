<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Factory;

use DavidBelicza\WebDream\Entity\ProductInterface;
use DavidBelicza\WebDream\Entity\WarehouseItem;

class WarehouseItemFactory
{
    /**
     * @param ProductInterface $product
     * @param int $qty
     *
     * @return WarehouseItem
     */
    public function create(
        ProductInterface $product,
        int $qty
    ): WarehouseItem {

        return new WarehouseItem($product, $qty);
    }
}
