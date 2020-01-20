<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Contracts\EventDispatcher\Event;

interface RaiseEventsInterface
{
    /**
     * @return Event[]
     */
    public function popEvents(): array;

    public function raise(Event $event);

    public function clearEvents();

    public function hasEvent(Event $event): bool;
}
