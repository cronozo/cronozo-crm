<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Command;

use App\Shared\Domain\Bus\Command\AsyncCommand;
use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Command\CommandBus;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyCommandBus implements CommandBus
{
    public function __construct(private readonly MessageBusInterface $bus)
    {
    }

    public function dispatch(AsyncCommand|Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new CommandNotRegisteredError($command);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
