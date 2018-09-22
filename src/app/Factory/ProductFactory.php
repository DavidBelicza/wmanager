<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Factory;

use DavidBelicza\WebDream\Entity\BookProduct;
use DavidBelicza\WebDream\Entity\Brand;
use DavidBelicza\WebDream\Entity\FashionProduct;

class ProductFactory
{
    /**
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param Brand $brand
     * @param string $author
     *
     * @return BookProduct
     */
    public function createBookProduct(
        string $sku,
        string $name,
        float $price,
        Brand $brand,
        string $author
    ): BookProduct {

        return new BookProduct(
            $sku,
            $name,
            $price,
            $brand,
            $author
        );
    }

    /**
     * @param string $sku
     * @param string $name
     * @param float $price
     * @param Brand $brand
     * @param string $size
     *
     * @return FashionProduct
     */
    public function createFashionProduct(
        string $sku,
        string $name,
        float $price,
        Brand $brand,
        string $size
    ): FashionProduct {

        return new FashionProduct(
            $sku,
            $name,
            $price,
            $brand,
            $size
        );
    }
}
