<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Validator;

use DavidBelicza\WebDream\Exception\AddItemOverflowException;

class AddItemValidator
{
    /**
     * @param array $slots
     * @param int $qty
     *
     * @throws AddItemOverflowException
     */
    public function validate(array $slots, int $qty): void
    {
        $capacity = (int)array_sum($slots);

        if ($capacity < $qty) {
            throw new AddItemOverflowException(
                sprintf(
                    'Maximum free capacity is %d, %d is given!',
                    $capacity,
                    $qty
                )
            );
        }
    }
}
