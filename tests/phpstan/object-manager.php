<?php

declare(strict_types=1);
use App\Kernel;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface;

require dirname(__DIR__) . '/bootstrap.php';
$kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$kernel->boot();
/** @var ContainerInterface $container */
$container = $kernel->getContainer();
/** @var \Doctrine\ORM\EntityManager $objectManager */
$objectManager = $container->get('doctrine')->getManager();

/** @var \Doctrine\ORM\Tools\ResolveTargetEntityListener $entityResolver */
$entityResolver = current(array_filter(
    $objectManager->getEventManager()->getListeners('loadClassMetadata'),
    static function ($listener) {
        return $listener instanceof \Doctrine\ORM\Tools\ResolveTargetEntityListener;
    }
));

$objectManager->getEventManager()->removeEventListener([Events::loadClassMetadata], $entityResolver);

return $objectManager;
