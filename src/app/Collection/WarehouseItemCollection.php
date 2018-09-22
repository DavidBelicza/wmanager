<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Collection;

use DavidBelicza\WebDream\Entity\WarehouseItem;

class WarehouseItemCollection
{
    /**
     * @var WarehouseItem[]
     */
    private $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return count($this->items);
    }

    /**
     * @return WarehouseItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param string $sku
     *
     * @return WarehouseItem|null
     */
    public function getItem(string $sku): ?WarehouseItem
    {
        if (isset($this->items[$sku])) {
            return $this->items[$sku];
        }

        return null;
    }

    /**
     * @param WarehouseItem $warehouseItem
     */
    public function addItem(WarehouseItem $warehouseItem): void
    {
        $this->items[$warehouseItem->getProduct()->getSku()] = $warehouseItem;
    }

    /**
     * @param string $sku
     *
     * @return bool
     */
    public function removeItem(string $sku): bool
    {
        $status = $this->getItem($sku) !== null;

        unset($this->items[$sku]);

        return $status;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->getSize();
    }
}
