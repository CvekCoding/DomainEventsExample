<?php

declare(strict_types=1);

namespace App\Entity;

use App\Event\ProductCreatedEvent;
use App\Event\ProductNameChangedEvent;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 *
 * @ORM\HasLifecycleCallbacks()
 */
class Product implements RaiseEventsInterface
{
    use RaiseEventsTrait;

    /**
     * @Assert\NotBlank(message="Name field can't be blank.")
     *
     * @ORM\Column(type="text")
     */
    private $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name): self
    {
        $name = \trim($name);
        if ($this->name !== $name) {
            $this->raise(new ProductNameChangedEvent($this, $this->name, $name));
            $this->name = $name;
        }

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist(): void
    {
        $this->raise(new ProductCreatedEvent($this));
    }
}
