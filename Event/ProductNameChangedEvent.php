<?php

declare(strict_types=1);

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

final class ProductNameChangedEvent extends Event
{
    private $product;
    private $oldName;
    private $newName;

    public function __construct(Product $product, string $oldName, string $newName)
    {
        $this->product = $product;
        $this->oldName = $oldName;
        $this->newName = $newName;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return string
     */
    public function getOldName(): string
    {
        return $this->oldName;
    }

    /**
     * @return string
     */
    public function getNewName(): string
    {
        return $this->newName;
    }
}
