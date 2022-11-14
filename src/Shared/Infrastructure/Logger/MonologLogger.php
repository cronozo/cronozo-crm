<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Logger;


use App\Shared\Domain\Logger;

final class MonologLogger implements Logger
{
    public function __construct(private readonly \Monolog\Logger $logger)
    {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function info(string $message, array $context = []): void
    {
        $this->logger->info($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function warning(string $message, array $context = []): void
    {
        $this->logger->warning($message, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function critical(string $message, array $context = []): void
    {
        $this->logger->critical($message, $context);
    }
}
