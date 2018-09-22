<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Factory;

use DavidBelicza\WebDream\Collection\WarehouseItemCollection;

class WarehouseItemCollectionFactory
{
    /**
     * @param array $items
     *
     * @return WarehouseItemCollection
     */
    public function create(array $items): WarehouseItemCollection
    {
        return new WarehouseItemCollection($items);
    }
}
