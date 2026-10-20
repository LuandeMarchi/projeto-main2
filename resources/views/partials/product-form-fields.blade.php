<div class="grid gap-6 md:grid-cols-2">
    <flux:input wire:model="name" :label="__('Nome')" type="text" required autofocus />

    <flux:input wire:model="sku" :label="__('Código (SKU)')" type="text" required placeholder="PRD-0001" />

    <flux:input wire:model="category" :label="__('Categoria')" type="text" placeholder="{{ __('Ex.: Eletrônicos') }}" />

    <div class="grid gap-6 sm:grid-cols-2">
        <flux:input wire:model="price" :label="__('Preço (R$)')" type="number" step="0.01" min="0" required />

        <flux:input wire:model="stock" :label="__('Estoque')" type="number" step="1" min="0" required />
    </div>
</div>

<flux:textarea wire:model="description" :label="__('Descrição')" rows="4" />

<flux:checkbox wire:model="isActive" :label="__('Produto ativo (aparece na página inicial)')" />
