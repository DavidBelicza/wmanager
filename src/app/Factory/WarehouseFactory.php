<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Factory;

use DavidBelicza\WebDream\Collection\WarehouseItemCollection;
use DavidBelicza\WebDream\Entity\Warehouse;

class WarehouseFactory
{
    /**
     * @param string $name
     * @param string $address
     * @param int $qtyCapacity
     * @param WarehouseItemCollection $collection
     *
     * @return Warehouse
     */
    public function create(
        string $name,
        string $address,
        int $qtyCapacity,
        WarehouseItemCollection $collection
    ): Warehouse {

        return new Warehouse(
            $name,
            $address,
            $qtyCapacity,
            $collection
        );
    }
}
