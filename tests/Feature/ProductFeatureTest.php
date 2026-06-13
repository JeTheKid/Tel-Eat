<?php
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

uses(DatabaseTransactions::class);

function getAdminUser() {
    return User::create([
        'nama' => 'Admin Testing',
        'email' => 'admin_test_' . uniqid() . '@gmail.com',
        'no_hp' => '08123456789',
        'password' => bcrypt('password123'),
        'role' => 'admin'
    ]);
}

test('berhasil menyimpan menu baru dengan harga dan stok valid', function () {
    $admin = getAdminUser();

    $response = $this->actingAs($admin)->post('/products', [
        'name' => 'Nasi Goreng',
        'category_id' => 1,
        'price' => 15000,
        'stock' => 50,
        'description' => 'Enak banget'
    ]);

    $response->assertRedirect('/products');
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('products', ['nama_produk' => 'Nasi Goreng']);
});

test('gagal menyimpan menu jika harga dan stok berupa teks', function () {
    $admin = getAdminUser();

    $response = $this->actingAs($admin)->post('/products', [
        'name' => 'Mie Goreng',
        'category_id' => 1,
        'price' => 'lima ribu',
        'stock' => 'sepuluh',
    ]);

    $response->assertSessionHasErrors(['price', 'stock']);
    $this->assertDatabaseMissing('products', ['nama_produk' => 'Mie Goreng']);
});

test('gagal menyimpan menu jika harga bernilai negatif', function () {
    $admin = getAdminUser();

    $response = $this->actingAs($admin)->post('/products', [
        'name' => 'Es Teh',
        'category_id' => 1,
        'price' => -5000,
        'stock' => 10,
        'description' => 'Deskripsi minuman'
    ]);

    $response->assertSessionHasErrors(['price']);
});

test('gagal menyimpan menu jika stok bernilai negatif', function () {
    $admin = getAdminUser();

    $response = $this->actingAs($admin)->post('/products', [
        'name' => 'Kopi',
        'category_id' => 1,
        'price' => 5000,
        'stock' => -5,
        'description' => 'Deskripsi minuman'
    ]);

    $response->assertSessionHasErrors(['stock']);
});
