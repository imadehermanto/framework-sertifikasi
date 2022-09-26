<?php
require_once '../../Includes.php';

use App\Models\Produk;

if(isset($_POST['submit'])){
    Produk::update([
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'qty' => $_POST['qty']
    ],$_POST['id']);
    header('Location: ../../index.php');
}