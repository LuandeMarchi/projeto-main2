<section class="w-full">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <flux:heading size="xl" level="1">{{ __('Produtos') }}</flux:heading>
            <flux:subheading>{{ __('Cadastre, edite e exclua os produtos do catálogo.') }}</flux:subheading>
        </div>

        <flux:button :href="route('products.create')" variant="primary" icon="plus" wire:navigate>
            {{ __('Novo produto') }}
        </flux:button>
    </div>

    @session('status')
        <flux:callout variant="success" icon="check-circle" :heading="$value" class="mb-6" />
    @endsession

    <div class="mb-4 max-w-sm">
        <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" :placeholder="__('Buscar por nome, SKU ou categoria')" />
    </div>

    @if ($this->products->isEmpty())
        <div class="rounded-xl border border-dashed border-zinc-300 p-10 text-center dark:border-zinc-700">
            <flux:heading>{{ __('Nenhum produto encontrado') }}</flux:heading>
            <flux:text class="mt-1">
                {{ $search !== '' ? __('Tente outro termo de busca.') : __('Comece cadastrando o primeiro produto.') }}
            </flux:text>
        </div>
    @else
        <flux:table :paginate="$this->products">
            <flux:table.columns>
                <flux:table.column>{{ __('Produto') }}</flux:table.column>
                <flux:table.column>{{ __('SKU') }}</flux:table.column>
                <flux:table.column>{{ __('Categoria') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Preço') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Estoque') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Ações') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->products as $product)
                    <flux:table.row :key="$product->id">
                        <flux:table.cell variant="strong">{{ $product->name }}</flux:table.cell>
                        <flux:table.cell>{{ $product->sku }}</flux:table.cell>
                        <flux:table.cell>{{ $product->category ?? '—' }}</flux:table.cell>
                        <flux:table.cell align="end">{{ $product->formatted_price }}</flux:table.cell>
                        <flux:table.cell align="end">{{ $product->stock }}</flux:table.cell>
                        <flux:table.cell>
                            @if ($product->is_active)
                                <flux:badge color="green" size="sm">{{ __('Ativo') }}</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">{{ __('Inativo') }}</flux:badge>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell align="end">
                            <div class="flex justify-end gap-1">
                                <flux:button :href="route('products.edit', $product)" size="sm" variant="ghost" icon="pencil-square" wire:navigate :aria-label="__('Editar')" />
                                <flux:button wire:click="confirmDeletion({{ $product->id }})" size="sm" variant="ghost" icon="trash" :aria-label="__('Excluir')" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @endif

    <flux:modal name="confirm-product-deletion" class="max-w-lg">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Excluir este produto?') }}</flux:heading>
                <flux:subheading>{{ __('Essa ação não pode ser desfeita.') }}</flux:subheading>
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancelar') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" wire:click="deleteProduct">{{ __('Excluir') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</section>
