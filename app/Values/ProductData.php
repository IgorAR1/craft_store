<?php


namespace App\Values;

use Illuminate\Http\Request;

final class ProductData
{
    public string $title;
    public ?string $description;
    public float $price;
    public array $images = [];
    public int $quantity;
    public string $color;
    public array $categories;

    public function __construct(
        string  $title,
        ?string $description,
        float   $price,
        array   $images,
        int     $quantity,
        string  $color,
        array   $categories
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->images = $images;
        $this->quantity = $quantity;
        $this->color = $color;
        $this->categories = $categories;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'] ?? '',
            description: $data['description'] ?? null,
            price: $data['price'] ?? 0,
            images: $data['images'] ?? [],
            quantity: $data['quantity'] ?? 1,
            color: $data['color'] ?? '',
            categories: $data['categories'] ?? [],
        );
    }

    public static function fromRequest(Request $request): self
    {
        $data = $request->all();

        return self::fromArray($data);
    }
}
