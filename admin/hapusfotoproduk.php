<?php

$id_foto = $_GET['idfoto'];
$id_produk = $_GET['idproduk'];

$ambilfoto = $koneksi->query("SELECT * FROM produk_foto WHERE id_produk_foto='$id_foto'");
$detailfoto = $ambilfoto->fetch_assoc();

$namafilefoto = $detailfoto['nama_foto_produk'];
unlink('../foto_produk/' . $namafilefoto);

$koneksi->query("DELETE FROM produk_foto WHERE id_produk_foto='$id_foto'");

// menampilkan Pesan Gagal telah logout dengan Javascript
echo "<script>alert('foto produk berhasil dihapus')</script>";
// mengarahkan ke halaman index.php secara otomatis dengan Javascript
echo "<script>location ='index.php?halaman=detailproduk&id=$id_produk' </script>";
