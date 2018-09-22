<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Resource;

use DavidBelicza\WebDream\Entity\Warehouse;

class WarehouseResource
{
    /**
     * @var Warehouse[]
     */
    private $warehouses = [];

    /**
     * @param Warehouse[] $warehouses
     */
    public function __construct(array $warehouses)
    {
        $this->warehouses = $warehouses;
    }

    /**
     * @return Warehouse[]
     */
    public function getWarehouses(): array
    {
        return $this->warehouses;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return serialize($this->warehouses);
    }
}
