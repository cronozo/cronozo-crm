<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Snowflake;

use App\Shared\Domain\Snowflake\SequenceResolver;
use App\Shared\Domain\Snowflake\SnowflakeGeneratorInterface;
use RuntimeException;

final class SnowflakeGenerator implements SnowflakeGeneratorInterface
{
    private int $startTime = 0;
    private int $dataCenter;
    private int $workerId;
    private SequenceResolver|null $sequence = null;
    private SequenceResolver|null $defaultSequenceResolver = null;

    public function __construct(int $dataCenter = null, int $workerId = null)
    {
        $maxDataCenter = -1 ^ (-1 << SnowflakeGeneratorInterface::MAX_DATACENTER_LENGTH);
        $maxWorkerId = -1 ^ (-1 << SnowflakeGeneratorInterface::MAX_WORKER_ID_LENGTH);

        $this->dataCenter = $dataCenter > $maxDataCenter || $dataCenter < 0 ? random_int(0, 31) : (int) $dataCenter;
        $this->workerId = $workerId > $maxWorkerId || $workerId < 0 ? random_int(0, 31) : (int) $workerId;
    }

    public function generate(): string
    {
        $currentTime = $this->getCurrentMicrotime();
        while (($sequence = $this->callResolver($currentTime)) > (-1 ^ (-1 << SnowflakeGeneratorInterface::MAX_SEQUENCE_LENGTH))) {
            usleep(1);
            $currentTime = $this->getCurrentMicrotime();
        }

        $workerLeftMoveLength = SnowflakeGeneratorInterface::MAX_SEQUENCE_LENGTH;
        $datacenterLeftMoveLength = SnowflakeGeneratorInterface::MAX_WORKER_ID_LENGTH + $workerLeftMoveLength;
        $timestampLeftMoveLength = SnowflakeGeneratorInterface::MAX_DATACENTER_LENGTH + $datacenterLeftMoveLength;

        return (string) ((($currentTime - $this->getStartTimeStamp()) << $timestampLeftMoveLength)
            | ($this->dataCenter << $datacenterLeftMoveLength)
            | ($this->workerId << $workerLeftMoveLength)
            | $sequence);
    }

    public function getCurrentMicroTime(): int
    {
        return floor(microtime(true) * 1000) | 0;
    }

    public function setStartTimeStamp(int $startTime): self
    {
        $missTime = $this->getCurrentMicrotime() - $startTime;

        if ($missTime < 0) {
            throw new RuntimeException('The start time cannot be greater than the current time');
        }

        $maxTimeDiff = -1 ^ (-1 << SnowflakeGeneratorInterface::MAX_TIMESTAMP_LENGTH);

        if ($missTime > $maxTimeDiff) {
            throw new RuntimeException(sprintf('The current microtime - starttime is not allowed to exceed -1 ^ (-1 << %d), You can reset the start time to fix this', self::MAX_TIMESTAMP_LENGTH));
        }

        $this->startTime = $startTime;

        return $this;
    }

    public function getStartTimeStamp(): int
    {
        if ($this->startTime > 0) {
            return $this->startTime;
        }

        // We set a default start time if you not set.
        $defaultTime = '2019-08-08 08:08:08';

        return (int) (strtotime($defaultTime) * 1000);
    }

    public function setSequenceResolver(SequenceResolver $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getSequenceResolver(): ?SequenceResolver
    {
        return $this->sequence;
    }

    public function getDefaultSequenceResolver(): SequenceResolver
    {
        return $this->defaultSequenceResolver ?: $this->defaultSequenceResolver = new RandomSequenceResolver();
    }

    private function callResolver(int $currentTime): int
    {
        $resolver = $this->getSequenceResolver();

        if (null !== $resolver && \is_callable($resolver)) {
            return $resolver($currentTime);
        }

        return !($resolver instanceof SequenceResolver)
            ? $this->getDefaultSequenceResolver()->sequence($currentTime)
            : $resolver->sequence($currentTime);
    }
}
