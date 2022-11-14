<?php

declare(strict_types=1);

use App\Shared\Domain\Bus\Command\AsyncCommand;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'messenger' => [
            'default_bus' => 'command.bus',
            'buses' => [
                'command.bus' => [
                    'middleware' => [
                        'doctrine_transaction',
                    ],
                ],
                'query.bus' => [],
                'event.bus' => [
                    'default_middleware' => 'allow_no_handlers',
                ],
            ],
            'transports' => [
                'sync' => 'sync://',
                'async' => 'sync://'
            ],
            'routing' => [
                AsyncCommand::class => 'async',
            ],
        ],
    ]);
};
