<?php

namespace App\Livewire\Products;

use App\Concerns\ProductValidationRules;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Novo produto')]
class Create extends Component
{
    use ProductValidationRules;

    /**
     * Store a new product.
     */
    public function save(): void
    {
        Product::query()->create($this->validatedProductAttributes());

        session()->flash('status', __('Produto cadastrado com sucesso.'));

        $this->redirectRoute('products.index', navigate: true);
    }
}
