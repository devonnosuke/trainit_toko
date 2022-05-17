<h2>Ubah Produk</h2>
<?php

$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]' ");
$pecah = $ambil->fetch_assoc();

?>

<pre><?php print_r($pecah) ?></pre>

<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>nama</label>
        <input type="text" class="form-control" name="nama" value="<?php echo $pecah['nama_pelanggan'] ?>">
    </div>
    <div class="form-group">
        <label>email</label>
        <input type="email" class="form-control" name="email" value="<?php echo $pecah['email_pelanggan'] ?>">
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input type="text" class="form-control" name="telepon" value="<?php echo $pecah['telepon_pelanggan'] ?>">
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {

    $koneksi->query("UPDATE pelanggan 
        SET
         nama_pelanggan='$_POST[nama]',
         email_pelanggan='$_POST[email]',
         telepon_pelanggan='$_POST[telepon]',
         WHERE id_pelanggan='$_GET[id]'
        ");

    echo "<script>alert('Data Pelanggan Berhasil Diubah!')</script>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=pelanggan'>";
}
?>