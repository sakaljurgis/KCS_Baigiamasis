<?php

namespace KCS\Dtos;

class ProductDto implements DtoInterface
{
    public string $name;
    public ?string $description = null;
    public ?string $sku = null;
    public float $price = 0;
    public int $quantity = 0;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
            'price' => $this->price,
            'quantity' => $this->quantity
        ];
    }
}