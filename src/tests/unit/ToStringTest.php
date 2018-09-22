<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream;

use DavidBelicza\WebDream\Entity\Brand;
use DavidBelicza\WebDream\Resource\WarehouseResource;
use PHPUnit\Framework\TestCase;

class ToStringTest extends TestCase
{
    public function testBrand(): void
    {
        $obj = new Brand('a', 1);

        $this->assertEquals('a, 1', (string)$obj);
    }

    public function testWarehouseResource(): void
    {
        $obj = new WarehouseResource(
            [
                'a' => 1,
                'b' => [
                    'c' => [
                        'd' => 2
                    ]
                ]
            ]
        );

        $this->assertEquals('a:2:{s:1:"a";i:1;s:1:"b";a:1:{s:1:"c";a:1:{s:1:"d";i:2;}}}', (string)$obj);
    }
}
