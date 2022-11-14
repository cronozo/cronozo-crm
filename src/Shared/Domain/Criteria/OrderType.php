<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

use App\Shared\Domain\ValueObject\ValueObjectInterface;

enum OrderType: string implements ValueObjectInterface
{
    case ASC = 'asc';
    case DESC = 'desc';
    case NONE = 'none';

    public function isNone(): bool
    {
        // @TODO compare by instanceof
        return $this->value === self::NONE->value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
