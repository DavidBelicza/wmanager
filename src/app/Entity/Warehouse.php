<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Entity;

use DavidBelicza\WebDream\Collection\WarehouseItemCollection;

class Warehouse
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $qtyCapacity;

    /**
     * @var WarehouseItemCollection
     */
    private $collection;

    /**
     * @param string $name
     * @param string $address
     * @param int $qtyCapacity
     * @param WarehouseItemCollection $collection
     */
    public function __construct(
        string $name,
        string $address,
        int $qtyCapacity,
        WarehouseItemCollection $collection
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->qtyCapacity = $qtyCapacity;
        $this->collection = $collection;
    }

    /**
     * @return int
     */
    public function getQtyCapacity(): int
    {
        return $this->qtyCapacity;
    }

    /**
     * @return WarehouseItemCollection
     */
    public function getItemCollection(): WarehouseItemCollection
    {
        return $this->collection;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name . ', ' . $this->address . ', ' . $this->qtyCapacity . ', ' . $this->collection->getSize();
    }
}
