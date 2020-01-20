<?php

declare(strict_types=1);

namespace App\Listener\Domain;

use App\Event\ProductCreatedEvent;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Example of async notification on ProductCreated event.
 * This event will be placed into async storage (AMQP) and probably processed later by someone.
 */
final class NotifyThatProductCreatedListener implements EventSubscriberInterface
{
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ProductCreatedEvent::class => 'asyncNotify',
        ];
    }

    public function asyncNotify(ProductCreatedEvent $event): void
    {
        $this->commandBus->dispatch($event);
    }
}
