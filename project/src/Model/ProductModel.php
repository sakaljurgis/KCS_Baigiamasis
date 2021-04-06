<?php

namespace KCS\Model;

class ProductModel extends BaseModel implements ToStringInterface, ToArrayInterface
{

    private string $name;
    private ?string $description;
    private ?string $sku;
    private float $price;
    private int $quantity;
    private string $created_at;
    private string $updated_at;

    public function __set($name, $value)
    {
        //this is needed to avoid automatic properties creation by PDO
    }

    public function __toString(): string
    {
        return $this->id.' '.$this->name.' '.$this->sku;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}