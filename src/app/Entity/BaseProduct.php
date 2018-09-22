<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Entity;

abstract class BaseProduct
{
    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @var Brand
     */
    private $brand;

    /**
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param Brand $brand
     */
    protected function __construct(
        string $sku,
        string $name,
        float $price,
        Brand $brand
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->brand = $brand;
    }

    /**
     * @inheritdoc
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->sku . ', ' . $this->name . ', ' . $this->price . ', ' . $this->brand->getName();
    }
}
