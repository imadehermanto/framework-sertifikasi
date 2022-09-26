<?php
require_once __DIR__ . '/Includes.php';

use App\Models\Produk;

?>

<form action="proses/produk/create.php" method="post">
    <label for="name">Nama Produk</label>
    <input type="text" name="name" id="name">
    <label for="price">Harga</label>
    <input type="text" name="price" id="price">
    <label for="qty">Stok</label>
    <input type="text" name="qty" id="qty">
    <button type="submit" name="submit">Submit</button>
</form>