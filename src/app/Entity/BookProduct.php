<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Entity;

class BookProduct extends BaseProduct implements ProductInterface
{
    /**
     * @var string
     */
    private $author;

    /**
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param Brand $brand
     * @param string $author
     */
    public function __construct(
        string $sku,
        string $name,
        float $price,
        Brand $brand,
        string $author
    ) {
        parent::__construct(
            $sku,
            $name,
            $price,
            $brand
        );

        $this->author = $author;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return parent::__toString() . ', ' . $this->size;
    }
}
