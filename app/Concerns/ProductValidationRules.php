<?php

namespace App\Concerns;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rule;

trait ProductValidationRules
{
    public string $name = '';

    public string $sku = '';

    public string $category = '';

    public string $description = '';

    public string $price = '';

    public string $stock = '0';

    public bool $isActive = true;

    /**
     * Get the validation rules used to validate products.
     *
     * @return array<string, array<int, ValidationRule|array<mixed>|string>>
     */
    protected function productRules(?int $productId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'sku' => [
                'required',
                'string',
                'max:50',
                $productId === null
                    ? Rule::unique(Product::class)
                    : Rule::unique(Product::class)->ignore($productId),
            ],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'stock' => ['required', 'integer', 'min:0'],
            'isActive' => ['boolean'],
        ];
    }

    /**
     * Validate the form and map it to the product's database columns.
     *
     * @return array{name: string, sku: string, category: string|null, description: string|null, price: string, stock: int, is_active: bool}
     */
    protected function validatedProductAttributes(?int $productId = null): array
    {
        $validated = $this->validate($this->productRules($productId));

        return [
            'name' => $validated['name'],
            'sku' => $validated['sku'],
            'category' => filled($validated['category']) ? $validated['category'] : null,
            'description' => filled($validated['description']) ? $validated['description'] : null,
            'price' => (string) $validated['price'],
            'stock' => (int) $validated['stock'],
            'is_active' => (bool) $validated['isActive'],
        ];
    }

    /**
     * Fill the form properties from an existing product.
     */
    protected function fillFromProduct(Product $product): void
    {
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->category = $product->category ?? '';
        $this->description = $product->description ?? '';
        $this->price = (string) $product->price;
        $this->stock = (string) $product->stock;
        $this->isActive = $product->is_active;
    }
}
