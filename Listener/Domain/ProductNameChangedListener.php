<?php

declare(strict_types=1);

namespace App\Listener\Domain;

use App\Event\ProductNameChangedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Example of sync listener on change name event.
 */
final class ProductNameChangedListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ProductNameChangedEvent::class => 'validateName',
        ];
    }

    public function validateName(ProductNameChangedEvent $event): void
    {
        if ((new NameValidator($event->getNewName()))->containsProfanity()) {
            throw new NameContainsProfanityException($event->getProduct());
        };
    }
}
