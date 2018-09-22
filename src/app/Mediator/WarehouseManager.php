<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Mediator;

use DavidBelicza\WebDream\Entity\ProductInterface;
use DavidBelicza\WebDream\Exception\AddItemOverflowException;
use DavidBelicza\WebDream\Exception\ReleaseItemOverflowException;
use DavidBelicza\WebDream\Factory\WarehouseItemFactory;
use DavidBelicza\WebDream\Service\WarehouseService;
use DavidBelicza\WebDream\Validator\AddItemValidator;
use DavidBelicza\WebDream\Validator\ReleaseItemValidator;

class WarehouseManager
{
    /**
     * @var WarehouseService
     */
    private $warehouseService;

    /**
     * @var WarehouseItemFactory
     */
    private $warehouseItemFactory;

    /**
     * @var AddItemValidator
     */
    private $addItemValidator;

    /**
     * @var ReleaseItemValidator
     */
    private $releaseItemValidator;

    /**
     * @param WarehouseService $warehouseService
     * @param WarehouseItemFactory $warehouseItemFactory
     * @param AddItemValidator $addItemValidator
     * @param ReleaseItemValidator $releaseItemValidator
     */
    public function __construct(
        WarehouseService $warehouseService,
        WarehouseItemFactory $warehouseItemFactory,
        AddItemValidator $addItemValidator,
        ReleaseItemValidator $releaseItemValidator
    ) {
        $this->warehouseItemFactory = $warehouseItemFactory;
        $this->warehouseService = $warehouseService;
        $this->addItemValidator = $addItemValidator;
        $this->releaseItemValidator = $releaseItemValidator;
    }

    /**
     * @param ProductInterface $product
     * @param int $qty
     *
     * @throws AddItemOverflowException
     */
    public function addProductToWarehouse(
        ProductInterface $product,
        int $qty
    ): void {

        $slots = $this->warehouseService->findFreeSlots($qty);

        $this->addItemValidator->validate($slots, $qty);

        foreach ($slots as $whId => $capacity) {
            if ($capacity >= $qty) {
                $itemQty = $qty;
                $qty = 0;
            } else {
                $itemQty = $capacity;
                $qty -= $capacity;
            }

            $item = $this->warehouseService->getItem(
                $whId,
                $product->getSku()
            );

            if ($item) {
                $this->warehouseService->updateItemQty(
                    $whId,
                    $product->getSku(),
                    $itemQty + $item->getQty()
                );

            } else {
                $whItem = $this->warehouseItemFactory->create(
                    $product,
                    $itemQty
                );

                $this->warehouseService->addItem($whId, $whItem);
            }

            if ($qty === 0) {
                break;
            }
        }
    }

    /**
     * @param string $sku
     * @param int $requiredQty
     *
     * @return int
     *
     * @throws ReleaseItemOverflowException
     */
    public function releaseProductFromWarehouse(
        string $sku,
        int $requiredQty
    ): int {

        $this->releaseItemValidator->validate(
            $this->warehouseService->totalQtyBySku($sku),
            $requiredQty
        );

        $originalQty = $requiredQty;
        $whIds = $this->warehouseService->getItemsBySku($sku);

        foreach ($whIds as $whId => $item) {
            if ($item !== null) {
                if ($requiredQty === $item->getQty()) {
                    $this->warehouseService->removeItem($whId, $sku);
                    $requiredQty = 0;
                    break;

                } else if ($requiredQty < $item->getQty()) {
                    $this->warehouseService->updateItemQty($whId, $sku, $requiredQty);
                    $requiredQty = 0;
                    break;

                } else {
                    $this->warehouseService->removeItem($whId, $sku);

                    $requiredQty -= $item->getQty();
                }
            }
        }

        return $originalQty - $requiredQty;
    }
}
