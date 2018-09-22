<?php

declare(strict_types=1);

namespace DavidBelicza\WebDream\Validator;

use DavidBelicza\WebDream\Exception\ReleaseItemOverflowException;

class ReleaseItemValidator
{
    /**
     * @param int $totalQty
     * @param int $requiredQty
     *
     * @throws ReleaseItemOverflowException
     */
    public function validate(int $totalQty, int $requiredQty): void
    {
        if ($totalQty < $requiredQty) {
            throw new ReleaseItemOverflowException(
                sprintf(
                    'Can not release %d items from %d!',
                    $requiredQty,
                    $totalQty
                )
            );
        }
    }
}
