<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Entity;

class Brand
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $quality;

    /**
     * @param string $name
     * @param int $quality
     */
    public function __construct(string $name, int $quality)
    {
        $this->name = $name;
        $this->quality = $quality;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name . ', ' . $this->quality;
    }
}
