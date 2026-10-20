<?php

use App\Livewire\Products\Create;
use App\Livewire\Products\Edit;
use App\Livewire\Products\Index;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected away from the products page', function () {
    $this->get(route('products.index'))->assertRedirect(route('login'));
});

test('products page lists products', function () {
    $this->actingAs(User::factory()->create());

    $product = Product::factory()->create(['name' => 'Teclado Mecânico']);

    $this->get(route('products.index'))
        ->assertOk()
        ->assertSee($product->name);
});

test('products can be searched', function () {
    $this->actingAs(User::factory()->create());

    Product::factory()->create(['name' => 'Teclado Mecânico']);
    Product::factory()->create(['name' => 'Monitor Ultrawide']);

    Livewire::test(Index::class)
        ->set('search', 'Teclado')
        ->assertSee('Teclado Mecânico')
        ->assertDontSee('Monitor Ultrawide');
});

test('a product can be created', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('name', 'Mouse sem fio')
        ->set('sku', 'PRD-0100')
        ->set('category', 'Eletrônicos')
        ->set('price', '119.90')
        ->set('stock', '25')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('products.index'));

    $product = Product::query()->where('sku', 'PRD-0100')->firstOrFail();

    expect($product->name)->toBe('Mouse sem fio');
    expect($product->price)->toBe('119.90');
    expect($product->stock)->toBe(25);
    expect($product->is_active)->toBeTrue();
});

test('a product requires valid data', function () {
    $this->actingAs(User::factory()->create());

    Product::factory()->create(['sku' => 'PRD-DUP']);

    Livewire::test(Create::class)
        ->set('name', '')
        ->set('sku', 'PRD-DUP')
        ->set('price', '-1')
        ->set('stock', 'abc')
        ->call('save')
        ->assertHasErrors(['name', 'sku', 'price', 'stock']);

    expect(Product::query()->count())->toBe(1);
});

test('a product can be updated', function () {
    $this->actingAs(User::factory()->create());

    $product = Product::factory()->create(['sku' => 'PRD-0200']);

    Livewire::test(Edit::class, ['product' => $product])
        ->assertSet('sku', 'PRD-0200')
        ->set('name', 'Nome Atualizado')
        ->set('stock', '7')
        ->set('isActive', false)
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('products.index'));

    $product->refresh();

    expect($product->name)->toBe('Nome Atualizado');
    expect($product->stock)->toBe(7);
    expect($product->is_active)->toBeFalse();
});

test('a product can be deleted', function () {
    $this->actingAs(User::factory()->create());

    $product = Product::factory()->create();

    Livewire::test(Index::class)
        ->call('confirmDeletion', $product->id)
        ->call('deleteProduct');

    expect($product->fresh())->toBeNull();
});

test('home page shows only active products', function () {
    Product::factory()->create(['name' => 'Produto Visível']);
    Product::factory()->inactive()->create(['name' => 'Produto Oculto']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Produto Visível')
        ->assertDontSee('Produto Oculto');
});
