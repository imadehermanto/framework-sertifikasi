<?php
//FUngsi ini berfungsi untuk memberi format rupiah pada angka
function rupiah($angka){
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    echo $hasil_rupiah;
}

//fungsi datetime format ke human readable
function datetimeToHuman($datetime){
    $date = date_create($datetime);
    echo date_format($date, 'd M Y H:i');
}