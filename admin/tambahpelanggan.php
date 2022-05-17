<h2>Tambah Pelanggan</h2>

<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>nama</label>
        <input type="text" class="form-control" name="nama">
    </div>
    <div class="form-group">
        <label>email</label>
        <input type="email" class="form-control" name="email">
    </div>
    <div class="form-group">
        <label>Telepon</label>
        <input type="text" class="form-control" name="telepon">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save'])) {

    $koneksi->query("INSERT INTO pelanggan
     (email_pelanggan,password_pelanggan,nama_pelanggan,telepon_pelanggan)
    VALUES('$_POST[email]','$_POST[password]','$_POST[nama]','$_POST[telepon]')");

    echo "<script>alert('Data Pelanggan Berhasil Ditambah!')</script>";
    echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=pelanggan'>";
}
?>