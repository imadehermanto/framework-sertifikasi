<?php
require_once __DIR__ . '/Includes.php';

use App\Models\Produk;

$produk = Produk::where('id','=',$_GET['id'])->get();
?>

<form action="proses/produk/update.php" method="post">
    <input type="hidden" name="id" value="<?=$produk[0]['id']?>">
    <label for="name">Nama Produk</label>
    <input type="text" name="name" id="name" value="<?= $produk[0]['name'] ?>">
    <label for="price">Harga</label>
    <input type="text" name="price" id="price" value="<?= $produk[0]['price'] ?>">
    <label for="qty">Stok</label>
    <input type="text" name="qty" id="qty" value="<?= $produk[0]['qty'] ?>">
    <button type="submit" name="submit">Submit</button>
</form>