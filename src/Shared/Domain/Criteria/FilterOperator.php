<?php

declare(strict_types=1);

namespace App\Shared\Domain\Criteria;

use App\Shared\Domain\ValueObject\ValueObjectInterface;

enum FilterOperator: string implements ValueObjectInterface {
    case EQUAL = '=';
    case NOT_EQUAL = '<>';
    case GT = '>';
    case LT = '<';
    case CONTAINS = 'CONTAINS';
    case NOT_CONTAINS = 'NOT_CONTAINS';

    public function value(): string
    {
        return $this->value;
    }

    public function isContaining(): bool
    {
        // @TODO compare by instanceof
        return in_array($this->value, [self::CONTAINS->value, self::NOT_CONTAINS->value], true);
    }
}
