<section class="w-full max-w-3xl">
    <div class="mb-6">
        <flux:heading size="xl" level="1">{{ __('Editar produto') }}</flux:heading>
        <flux:subheading>{{ $product->name }}</flux:subheading>
    </div>

    <form wire:submit="save" class="space-y-6">
        @include('partials.product-form-fields')

        <div class="flex items-center gap-3">
            <flux:button variant="primary" type="submit">{{ __('Salvar alterações') }}</flux:button>
            <flux:button :href="route('products.index')" variant="ghost" wire:navigate>{{ __('Cancelar') }}</flux:button>
        </div>
    </form>
</section>
