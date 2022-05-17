<?php
session_start();

// ambil id produk dari URL
$id_produk = $_GET['id'];
// menghapus data produk dari SESSION berdasarkan id di atas
unset($_SESSION['keranjang'][$id_produk]);

// menampilkan Pesan hapus dari keranjang dengan Javascript
echo "<script>alert('Produk telah dihapus dari keranjang.')</script>";
// mengarahkan ke halaman keranjang.php secara otomatis dengan Javascript
echo "<script>location ='keranjang.php' </script>";
