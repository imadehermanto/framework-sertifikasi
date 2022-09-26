<?php
require_once '../../Includes.php';

use App\Models\Produk;

Produk::delete($_GET['id']);
header('Location: ../../index.php');