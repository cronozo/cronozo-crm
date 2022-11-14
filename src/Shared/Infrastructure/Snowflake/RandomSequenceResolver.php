<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Snowflake;

use App\Shared\Domain\Snowflake\SequenceResolver;

final class RandomSequenceResolver implements SequenceResolver
{
    private int $lastTimeStamp = -1;
    private int $sequence = 0;

    public function sequence(int $currentTime): int
    {
        if ($this->lastTimeStamp === $currentTime) {
            ++$this->sequence;
            $this->lastTimeStamp = $currentTime;

            return $this->sequence;
        }

        $this->sequence = 0;
        $this->lastTimeStamp = $currentTime;

        return 0;
    }
}
