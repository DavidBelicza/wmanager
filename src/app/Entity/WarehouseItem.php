<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Entity;

class WarehouseItem
{
    /**
     * @var ProductInterface
     */
    private $product;

    /**
     * @var int
     */
    private $qty;

    /**
     * @param ProductInterface $product
     * @param int $qty
     */
    public function __construct(ProductInterface $product, int $qty)
    {
        $this->product = $product;
        $this->qty = $qty;
    }

    /**
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     */
    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->product->getSku() . ', ' . $this->qty;
    }
}
