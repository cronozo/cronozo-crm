<?php

declare(strict_types=1);

namespace App\Shared\Domain\Snowflake;

interface SequenceResolver
{
    public function sequence(int $currentTime): int;
}
