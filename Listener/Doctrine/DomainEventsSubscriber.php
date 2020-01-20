<?php

declare(strict_types=1);

namespace App\Listener\Doctrine;

use App\Entity\Main\BaseEntity\RaiseEventsInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Tightenco\Collect\Support\Collection;

/**
 * To catch all the domain events and raise them.
 */
final class DomainEventsSubscriber
{
    private $eventDispatcher;
    private $entities;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->entities = new Collection();
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::preFlush,
            Events::postFlush,
        ];
    }

    /**
     * @param PreFlushEventArgs $eventArgs
     */
    public function preFlush(PreFlushEventArgs $eventArgs): void
    {
        foreach ($eventArgs->getEntityManager()->getUnitOfWork()->getIdentityMap() as $class => $entities) {
            if (!\in_array(RaiseEventsInterface::class, \class_implements($class), true)) {
                continue;
            }

            $this->entities = $this->entities->merge($entities);
        }

        $eventDispatcher = $this->eventDispatcher;
        $this->entities
            ->flatMap(static function (RaiseEventsInterface $entity) {
                return $entity->popEvents();
            })
            ->each(static function (Event $event) use ($eventDispatcher) {
                $eventDispatcher->dispatch($event);
            });
    }

    public function postFlush(): void
    {
        $this->entities
            ->each(static function (RaiseEventsInterface $entity) {
                $entity->clearEvents();
            });
    }
}
