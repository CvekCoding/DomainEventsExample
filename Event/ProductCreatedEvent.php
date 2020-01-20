<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class ProductCreatedEvent extends Event
{
    private $product;
    private $dateTime;

    public function __construct(Product $product, DateTimeImmutable $dateTime)
    {
        $this->product = $product;
        $this->dateTime = $dateTime;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDateTime(): DateTimeInterface
    {
        return $this->dateTime;
    }
}
