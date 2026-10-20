<?php

namespace App\Livewire\Products;

use App\Concerns\ProductValidationRules;
use App\Models\Product;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Editar produto')]
class Edit extends Component
{
    use ProductValidationRules;

    #[Locked]
    public Product $product;

    /**
     * Mount the component.
     */
    public function mount(Product $product): void
    {
        $this->product = $product;

        $this->fillFromProduct($product);
    }

    /**
     * Update the product.
     */
    public function save(): void
    {
        $this->product->update($this->validatedProductAttributes($this->product->id));

        session()->flash('status', __('Produto atualizado com sucesso.'));

        $this->redirectRoute('products.index', navigate: true);
    }
}
