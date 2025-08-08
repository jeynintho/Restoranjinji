<?php
include '../db.php';
$query = "SELECT * FROM menu";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kelola Menu Makanan</title>
  <link rel="stylesheet" href="css/style.css"> <!-- Pastikan file CSS tersedia -->
</head>
<body>

<?php include 'layouts/navbar.php'; ?>

<main>
  <div class="head-title">
    <div class="left">
      <h1>Kelola Menu Makanan</h1>
      <ul class="breadcrumb">
        <li><a href="#">Kelola Menu Makanan</a></li>
        <li><i class='bx bx-chevron-right'></i></li>
        <li><a class="active" href="#">Home</a></li>
      </ul>
    </div>
  </div>

  <div class="header-menu">
    <div class="menu-header">
      <h3>Manajemen Menu</h3>
      <button class="btn-tambah" onclick="openModalById('modalTambah')">+ Tambah Menu Makanan</button>
    </div>

    <!-- Modal Tambah -->
    <div id="modalTambah" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModalById('modalTambah')">&times;</span>
        <h3>Tambah Menu Baru</h3><br><br>
        <form action="proses_tambah_menu.php" method="POST" enctype="multipart/form-data">
          <label>Upload Gambar:</label>
          <input type="file" name="gambar" required><br>

          <label>Nama Menu:</label>
          <input type="text" name="nama" required><br>

          <label>Harga:</label>
          <input type="number" name="harga" required><br>

          <label>Jenis:</label>
          <select name="jenis">
            <option value="Makanan Berat">Makanan Berat</option>
            <option value="Makanan Ringan">Makanan Ringan</option>
            <option value="Minuman">Minuman</option>
          </select><br>

          <label>Ketersediaan:</label>
          <select name="tersedia">
            <option value="1">Tersedia</option>
            <option value="0">Tidak Tersedia</option>
          </select><br><br>

          <button type="submit" class="btn-simpan">Simpan Menu</button>
        </form>
      </div>
    </div>
    <!-- END Modal Tambah -->

    <!-- Modal Edit untuk Setiap Item -->
    <?php
    mysqli_data_seek($result, 0);
    while ($row = mysqli_fetch_assoc($result)):
    ?>
      <div id="modalEdit_<?= $row['id'] ?>" class="modal">
        <div class="modal-content">
          <span class="close" onclick="closeModalById('modalEdit_<?= $row['id'] ?>')">&times;</span>
          <h3>Edit Menu Makanan</h3><br><br>
          <form action="proses_edit_menu.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            
            <label>Upload Gambar:</label>
            <input type="file" name="gambar"><br>

            <label>Nama Menu:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($row['name']) ?>" required><br>

            <label>Harga:</label>
            <input type="number" name="harga" value="<?= $row['harga'] ?>" required><br>

            <label>Jenis:</label>
            <select name="jenis">
              <option value="Makanan Berat" <?= $row['jenis'] == 'Makanan Berat' ? 'selected' : '' ?>>Makanan Berat</option>
              <option value="Makanan Ringan" <?= $row['jenis'] == 'Makanan Ringan' ? 'selected' : '' ?>>Makanan Ringan</option>
              <option value="Minuman" <?= $row['jenis'] == 'Minuman' ? 'selected' : '' ?>>Minuman</option>
            </select><br>

            <label>Ketersediaan:</label>
            <select name="tersedia">
              <option value="1" <?= $row['tersedia'] == 1 ? 'selected' : '' ?>>Tersedia</option>
              <option value="0" <?= $row['tersedia'] == 0 ? 'selected' : '' ?>>Tidak Tersedia</option>
            </select><br><br>

            <button type="submit" class="btn-simpan">Update Menu</button>
          </form>
        </div>
      </div>
    <?php endwhile; ?>
    <!-- END Modal Edit -->

    <!-- Tabel Menu -->
    <div class="container-menu-table">
      <div class="menu-table-container">
        <table class="menu-table">
          <thead>
            <tr>
              <th>GAMBAR</th>
              <th>NAMA</th>
              <th>JENIS</th>
              <th>HARGA</th>
              <th>KETERSEDIAAN</th>
              <th>AKSI</th>
            </tr>
          </thead>
          <tbody>
            <?php
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)):
            ?>
              <tr>
                <td><img src="img/<?= $row['gambar'] ?: 'default.jpg' ?>" width="60"></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['jenis'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= $row['tersedia'] ? '<span class="badge">Tersedia</span>' : '<span class="badge badge-danger">Tidak</span>' ?></td>
                <td>
                  <button class="btn-tambah-edit" onclick="openModalById('modalEdit_<?= $row['id'] ?>')">Edit</button>
                  <a href="hapus_menu.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus menu ini?')" class="hapus">Hapus</a>

              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</main>

<script>
function openModalById(id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = 'block';
}
function closeModalById(id) {
  const modal = document.getElementById(id);
  if (modal) modal.style.display = 'none';
}
window.addEventListener('click', function(event) {
  const modals = document.getElementsByClassName('modal');
  for (let i = 0; i < modals.length; i++) {
    if (event.target === modals[i]) {
      modals[i].style.display = 'none';
    }
  }
});
</script>

</body>
</html>
