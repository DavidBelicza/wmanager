<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Service;

use DavidBelicza\WebDream\Entity\WarehouseItem;
use DavidBelicza\WebDream\Resource\WarehouseResource;

class WarehouseService
{
    /**
     * @var WarehouseResource
     */
    private $warehouseResource;

    /**
     * @param WarehouseResource $warehouseResource
     */
    public function __construct(WarehouseResource $warehouseResource)
    {
        $this->warehouseResource = $warehouseResource;
    }

    /**
     * @param int $warehouseId
     * @param string $sku
     *
     * @return WarehouseItem|null
     */
    public function getItem(int $warehouseId, string $sku): ?WarehouseItem
    {
        return $this->warehouseResource
            ->getWarehouses()[$warehouseId]
            ->getItemCollection()
            ->getItem($sku);
    }

    /**
     * @param int $warehouseId
     * @param WarehouseItem $warehouseItem
     */
    public function addItem(int $warehouseId, WarehouseItem $warehouseItem): void
    {
        $this->warehouseResource
            ->getWarehouses()[$warehouseId]
            ->getItemCollection()
            ->addItem($warehouseItem);
    }

    /**
     * @param int $warehouseId
     * @param string $sku
     *
     * @return bool
     */
    public function removeItem(int $warehouseId, string $sku): bool
    {
        return $this->warehouseResource
            ->getWarehouses()[$warehouseId]
            ->getItemCollection()
            ->removeItem($sku);
    }

    /**
     * @param int $warehouseId
     * @param string $sku
     * @param int $qty
     */
    public function updateItemQty(int $warehouseId, string $sku, int $qty): void
    {
        $loadedWarehouseItem = $this->getItem(
            $warehouseId,
            $sku
        );

        $loadedWarehouseItem->setQty($qty);
    }

    /**
     * @param string $sku
     *
     * @return WarehouseItem[]
     */
    public function getItemsBySku(string $sku): array
    {
        $ids = [];

        foreach ($this->warehouseResource->getWarehouses() as $whId => $warehouse) {
            $item = $this->getItem($whId, $sku);

            if ($item !== null) {
                $ids[$whId] = $item;
            }
        }

        return $ids;
    }

    /**
     * @param string $sku
     *
     * @return int
     */
    public function totalQtyBySku(string $sku): int
    {
        $qty = 0;

        foreach ($this->warehouseResource->getWarehouses() as $whId => $warehouse) {
            $item = $this->getItem($whId, $sku);

            if ($item !== null) {
                $qty += $item->getQty();
            }
        }

        return $qty;
    }

    /**
     * @param int $requiredQty
     *
     * @return int[]
     */
    public function findFreeSlots(int $requiredQty): array
    {
        $slots = [];

        foreach ($this->warehouseResource->getWarehouses() as $whId => $warehouse) {
            $capacity = $warehouse->getQtyCapacity();

            if ($capacity > 0) {
                $reservedSlot = 0;

                foreach ($warehouse->getItemCollection()->getItems() as $item) {
                    $reservedSlot += $item->getQty();
                }

                if ($capacity > $reservedSlot) {
                    $slots[$whId] = $capacity - $reservedSlot;
                    $requiredQty -= $slots[$whId];
                }
            }

            if ($requiredQty <= 0) {
                break;
            }
        }

        return $slots;
    }
}
