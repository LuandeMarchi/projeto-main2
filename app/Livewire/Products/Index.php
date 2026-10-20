<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Produtos')]
class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    public ?int $productIdBeingDeleted = null;

    /**
     * Reset pagination whenever the search term changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Get the paginated list of products matching the search term.
     *
     * @return LengthAwarePaginator<int, Product>
     */
    #[Computed]
    public function products(): LengthAwarePaginator
    {
        return Product::query()
            ->when($this->search !== '', function ($query): void {
                $query->where(function ($query): void {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('sku', 'like', "%{$this->search}%")
                        ->orWhere('category', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate(10);
    }

    /**
     * Open the confirmation modal for deleting the given product.
     */
    public function confirmDeletion(int $productId): void
    {
        $this->productIdBeingDeleted = $productId;

        Flux::modal('confirm-product-deletion')->show();
    }

    /**
     * Delete the product that is pending confirmation.
     */
    public function deleteProduct(): void
    {
        if ($this->productIdBeingDeleted === null) {
            return;
        }

        Product::query()->findOrFail($this->productIdBeingDeleted)->delete();

        $this->productIdBeingDeleted = null;

        Flux::modal('confirm-product-deletion')->close();

        Flux::toast(variant: 'success', text: __('Produto excluído.'));
    }
}
