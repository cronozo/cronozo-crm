<?php

declare(strict_types=1);

namespace App\Shared\Domain\Snowflake;

interface SnowflakeGeneratorInterface
{
    public const MAX_TIMESTAMP_LENGTH = 41;
    public const MAX_DATACENTER_LENGTH = 5;
    public const MAX_WORKER_ID_LENGTH = 5;
    public const MAX_SEQUENCE_LENGTH = 12;
    public const MAX_FIRST_LENGTH = 1;

    public function generate(): string;
}
