<?php
include 'Includes.php';

use App\Models\Buku;

//menampilkan semua data
// dd(Buku::all());

//menampilkan data penerbit tertentu
dd(Buku::like('judul', 'belajar')->limit(1)->orderBy('id', 'DESC')->get());
//chaining method (method berantai)