<?php
session_start();
// mendapatkan id_produk dari url
$id_produk = $_GET['id'];

// jk sudah ada produk itu dikeranjang, maka produk ditambah +1
if (isset($_SESSION['keranjang'][$id_produk])) {
    $_SESSION['keranjang'][$id_produk] += 1;
}
// Selain itu (blm ada di keranjang) maka produk itu dianggap dibeli 1
else {
    $_SESSION['keranjang'][$id_produk] = 1;
}

// Larikan ke halaman pertama

?>
<script>
    alert('produk telah masuk ke keranjang belanja')
</script>
<script>
    location = 'keranjang.php'
</script>