<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Entity;

interface ProductInterface
{
    /**
     * @return string
     */
    public function getSku(): string;
}
