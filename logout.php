<?php 
session_start();

// Menghapus semua data session yang telah dibuat
session_destroy();

 // menampilkan Pesan Gagal telah logout dengan Javascript
 echo "<script>alert('anda telah logout')</script>";
 // mengarahkan ke halaman index.php secara otomatis dengan Javascript
 echo "<script>location ='index.php' </script>";
