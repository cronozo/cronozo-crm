<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

interface ValueObjectInterface
{
    public function value(): mixed;
}
