<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class ValueObject implements ValueObjectInterface
{
    public function __construct(protected mixed $value)
    {
    }

    public function value(): mixed
    {
        return $this->value;
    }
}
