<h3>Data Kategori</h3>
<hr>

<?php
$semuadata = [];
$ambil = $koneksi->query("SELECT * FROM kategori");
while ($tiap = $ambil->fetch_assoc()) {
    $semuadata[] = $tiap;
}

?>
<table class="table table-bordered">
    <thead>
        <tr>
            <td>No</td>
            <td>Kategori</td>
            <td>Aksi</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($semuadata as $key => $value) : ?>
            <tr>
                <td><?php echo $key + 1 ?></td>
                <td><?php echo $value['nama_kategori'] ?></td>
                <td>
                    <a href="" class="btn btn-warning btn-sm">ubah</a>
                    <a href="" class="btn btn-danger btn-sm">hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="" class="btn btn-default">Tambah Data</a>