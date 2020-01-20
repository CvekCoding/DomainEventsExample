<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Contracts\EventDispatcher\Event;

trait RaiseEventsTrait
{
    /**
     * @var Event[]
     */
    private $events = [];

    /**
     * @return Event[]
     */
    public function popEvents(): array
    {
        return $this->events;
    }

    public function clearEvents(): self
    {
        $this->events = [];

        return $this;
    }

    public function raise(Event $event): self
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * @param Event|string $needle
     *
     * @return bool
     */
    public function hasEvent($needle): bool
    {
        foreach ($this->events as $event) {
            if ($event instanceof $needle) {
                return true;
            }
        }

        return false;
    }
}
