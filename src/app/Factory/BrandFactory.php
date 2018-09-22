<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Factory;

use DavidBelicza\WebDream\Entity\Brand;

class BrandFactory
{
    /**
     * @param string $name
     * @param int $quality
     *
     * @return Brand
     */
    public function create(string $name, int $quality): Brand
    {
        return new Brand($name, $quality);
    }
}
