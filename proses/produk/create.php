<?php
require_once '../../Includes.php';

use App\Models\Produk;


if(isset($_POST['submit'])){
    Produk::insert([
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'qty' => $_POST['qty']
    ]);
    header('Location: ../../index.php');
}