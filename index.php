<?php
require_once __DIR__ . '/Includes.php';

use App\Models\Produk;

$produk = Produk::all();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikasi</title>
</head>
<body>
    <a href="produk_create.php">Tambah Produk</a>
    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no=1;
            foreach($produk as $row) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['price']; ?></td>
                <td><?= $row['qty']; ?></td>
                <td>
                    <a href="produk_edit.php?id=<?=$row['id']; ?>">Edit</a>
                    <a href="proses/produk/delete.php?id=<?=$row['id']; ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>