<?php

declare(strict_types=1);

use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Infrastructure\Bus\Command\SymfonyCommandBus;
use App\Shared\Infrastructure\Bus\Query\SymfonyQueryBus;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\', __DIR__ . '/../src/')
        ->exclude([__DIR__ . '/../src/Kernel.php']);

    $services->set(SymfonyCommandBus::class)
        ->args([
            service('command.bus'),
        ])
        ->alias(CommandBus::class, SymfonyCommandBus::class);

    $services->set(SymfonyQueryBus::class)
        ->args([
            service('query.bus'),
        ])
        ->alias(QueryBus::class, SymfonyQueryBus::class);
};
