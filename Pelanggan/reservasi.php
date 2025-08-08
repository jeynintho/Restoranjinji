<?php include '../db.php'; ?>

<?php
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Ambil semua data meja
$mejaQuery = mysqli_query($conn, "SELECT * FROM tables ORDER BY id");
$mejaList = [];
while ($row = mysqli_fetch_assoc($mejaQuery)) {
    $mejaList[] = $row;
}

$jamOperasional = ['17:00', '18:00', '19:00', '20:00', '21:00'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Meja</title>
    <link rel="stylesheet" href="css/reservasi.css">
</head>
<body>

<?php include 'layouts/app.php'; ?>

<section class="hero">
  <img src="img/banner2.jpg" alt="Kayumanis Dish" class="hero-img">
</section>

<div class="header">
    <h1>Reservasi Meja</h1>
</div>

<!-- Form Pilih Tanggal -->
<form method="GET">
    <label>Lihat ketersediaan meja untuk tanggal: </label>
    <input type="date" name="tanggal" value="<?= htmlspecialchars($tanggal) ?>" min="<?= date('Y-m-d') ?>">
    <button type="submit">Lihat</button>
</form>

<!-- Notifikasi -->
<?php if (isset($_GET['error'])): ?>
    <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>
<?php if (isset($_GET['success'])): ?>
    <p style="color:green;">Reservasi berhasil!</p>
<?php endif; ?>

<!-- Tampilan Status Meja -->
<div class="container">
<?php foreach ($mejaList as $meja): ?>
    <div class='meja'>
        <h3>Meja <?= $meja['id'] ?> (max <?= $meja['capacity'] ?> org)</h3>
        <ul>
        <?php foreach ($jamOperasional as $jam): 
            $cek = mysqli_query($conn, "SELECT status_meja FROM reservations 
                WHERE table_number = {$meja['id']} 
                AND reservation_date = '$tanggal' 
                AND reservation_time = '$jam' 
                AND status_meja != 'selesai'
                LIMIT 1");

            $data = mysqli_fetch_assoc($cek);
            $status = ($data) ? 'taken' : 'free';
            $label = ($data) ? '❌ Terisi' : '✅ Kosong';
        ?>
            <li class='<?= $status ?>'><?= $jam ?> - <?= $label ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endforeach; ?>
</div>

<hr>

<h2>Form Pemesanan</h2>
<form action="simpan.php" method="POST" class="pemesanan">
    <div class="form-grid">
        <div class="form-group">
            <input type="text" name="name" placeholder="Nama" required>
        </div>

        <div class="form-group">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="form-group">
            <input type="number" name="guest_count" id="guest_count" placeholder="Jumlah Tamu" required onchange="filterMeja()">
        </div>

        <div class="form-group">
            <select name="table_number" id="table_number" required>
                <option value="">-- Pilih Meja --</option>
                <?php foreach ($mejaList as $meja): ?>
                    <option value="<?= $meja['id'] ?>" data-kapasitas="<?= $meja['capacity'] ?>">
                        Meja <?= $meja['id'] ?> (<?= $meja['capacity'] ?> org)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <input type="date" name="reservation_date" value="<?= htmlspecialchars($tanggal) ?>" min="<?= date('Y-m-d') ?>" required>
        </div>

        <div class="form-group">
            <select name="reservation_time" required>
                <?php foreach ($jamOperasional as $jam): ?>
                    <option value="<?= $jam ?>"><?= $jam ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <button type="submit">Pesan</button>
</form>

<script>
function filterMeja() {
    const jumlahTamu = parseInt(document.getElementById('guest_count').value);
    const mejaOptions = document.querySelectorAll('#table_number option');

    mejaOptions.forEach(opt => {
        const kapasitas = parseInt(opt.getAttribute('data-kapasitas'));
        opt.style.display = (kapasitas >= jumlahTamu) ? 'block' : 'none';
    });
}
</script>

<?php include 'layouts/footer.php'; ?>

</body>
</html>
