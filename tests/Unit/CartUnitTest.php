<?php
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

test('path 1: menolak pesanan jika stok habis total', function () {
    $product = Product::create([
        'nama_produk' => 'Produk Tes 1',
        'harga' => 10000,
        'stok' => 0,
        'status' => 'aktif',
        'id_kategori' => 1
    ]);

    $response = $this->withoutMiddleware()->from('/')->post("/add-to-cart/{$product->id_produk}");

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Maaf, stok produk ini sudah habis terjual!');
});

test('path 2: menambah produk baru ke keranjang jika stok tersedia', function () {
    $product = Product::create([
        'nama_produk' => 'Produk Tes 2',
        'harga' => 15000,
        'stok' => 10,
        'status' => 'aktif',
        'id_kategori' => 1
    ]);

    $response = $this->withoutMiddleware()->from('/')->post("/add-to-cart/{$product->id_produk}");

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Menu masuk keranjang!');
});

test('path 3: menolak penambahan qty jika melebihi sisa stok di database', function () {
    $product = Product::create([
        'nama_produk' => 'Produk Tes 3',
        'harga' => 20000,
        'stok' => 5,
        'status' => 'aktif',
        'id_kategori' => 1
    ]);

    $initialCart = [
        $product->id_produk => [
            'quantity' => 5,
            'name' => $product->nama_produk,
            'price' => $product->harga,
            'image' => $product->gambar,
            'id_produk' => $product->id_produk
        ]
    ];

    $response = $this->withoutMiddleware()->withSession(['cart' => $initialCart])
                     ->from('/')->post("/add-to-cart/{$product->id_produk}");

    $response->assertRedirect();
    $response->assertSessionHas('error', 'Stok tidak cukup! Sisa stok hanya: 5');
});

test('path 4: menambah qty produk di keranjang jika stok mencukupi', function () {
    $product = Product::create([
        'nama_produk' => 'Produk Tes 4',
        'harga' => 25000,
        'stok' => 5,
        'status' => 'aktif',
        'id_kategori' => 1
    ]);

    $initialCart = [
        $product->id_produk => [
            'quantity' => 1,
            'name' => $product->nama_produk,
            'price' => $product->harga,
            'image' => $product->gambar,
            'id_produk' => $product->id_produk
        ]
    ];

    $response = $this->withoutMiddleware()->withSession(['cart' => $initialCart])
                     ->from('/')->post("/add-to-cart/{$product->id_produk}");

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Menu masuk keranjang!');
});
