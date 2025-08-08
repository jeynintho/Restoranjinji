<?php
include '../db.php';

$filter = $_GET['filter'] ?? 'hari';
$tanggal = $_GET['tanggal'] ?? date('Y-m-d');
$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');
$nama = mysqli_real_escape_string($conn, $_GET['nama'] ?? '');

$where = "";
$judul = "";

// Logika filter waktu
if ($filter === 'hari') {
    $where = "DATE(p.waktu_bayar) = '$tanggal'";
    $judul = "Riwayat Tanggal " . date('d F Y', strtotime($tanggal));
} elseif ($filter === 'minggu') {
    $start = date('Y-m-d', strtotime('last Monday', strtotime($tanggal)));
    $end = date('Y-m-d', strtotime('next Sunday', strtotime($tanggal)));
    $where = "DATE(p.waktu_bayar) BETWEEN '$start' AND '$end'";
    $judul = "Riwayat Minggu Ini ($start s/d $end)";
} elseif ($filter === 'bulan') {
    $where = "MONTH(p.waktu_bayar) = '$bulan' AND YEAR(p.waktu_bayar) = '$tahun'";
    $judul = "Riwayat Bulan " . date('F', mktime(0, 0, 0, $bulan, 1)) . " $tahun";
} elseif ($filter === 'tahun') {
    $where = "YEAR(p.waktu_bayar) = '$tahun'";
    $judul = "Riwayat Tahun $tahun";
}

// Tambahkan filter nama jika ada
if ($nama !== '') {
    $where .= " AND r.name LIKE '%$nama%'";
    $judul .= " untuk \"$nama\"";
}

$query = "SELECT p.*, r.name, r.table_number
          FROM pembayaran p
          JOIN reservations r ON r.id = p.reservation_id
          WHERE $where
          ORDER BY p.waktu_bayar DESC";

$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            button, form, select, input {
                display: none !important;
            }
        }
    </style>

    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4><?= $judul ?></h4>
        <button><a href="tabel_laporan_penjualan.php" class="btn btn-secondary">Kembali Ke Dashboard</a></button>
        <button onclick="window.print()" class="btn btn-secondary">🖨 Cetak</button>
        
    </div>
    

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-2">
            <select name="filter" class="form-select" onchange="this.form.submit()">
                <option value="hari" <?= $filter === 'hari' ? 'selected' : '' ?>>Harian</option>
                <option value="minggu" <?= $filter === 'minggu' ? 'selected' : '' ?>>Mingguan</option>
                <option value="bulan" <?= $filter === 'bulan' ? 'selected' : '' ?>>Bulanan</option>
                <option value="tahun" <?= $filter === 'tahun' ? 'selected' : '' ?>>Tahunan</option>
            </select>
        </div>

        <div class="col-md-3">
            <input type="text" name="nama" placeholder="Cari nama pelanggan..." class="form-control"
                   value="<?= htmlspecialchars($_GET['nama'] ?? '') ?>">
        </div>

        <?php if ($filter === 'hari' || $filter === 'minggu'): ?>
            <div class="col-md-3">
                <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control">
            </div>
        <?php elseif ($filter === 'bulan'): ?>
            <div class="col-md-2">
                <select name="bulan" class="form-select">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control" min="2000">
            </div>
        <?php elseif ($filter === 'tahun'): ?>
            <div class="col-md-2">
                <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control" min="2000">
            </div>
        <?php endif; ?>

        <div class="col-md-2">
            <button type="submit" class="btn btn-dark">Tampilkan</button>
        </div>
    </form>

    <table class="laporan-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAMA PEMESAN</th>
                <th>MEJA</th>
                <th>METODE</th>
                <th>BAYAR</th>
                <th>KEMBALIAN</th>
				<th>KETERANGAN</th>
                <th>WAKTU BAYAR</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; $grand = 0; while ($row = mysqli_fetch_assoc($data)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['table_number'] ?></td>
                <td><?= htmlspecialchars($row['metode']) ?></td>
                <td>Rp<?= number_format($row['uang_bayar'], 0, ',', '.') ?></td>
                <td>Rp<?= number_format($row['kembalian'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
                <td><?= $row['waktu_bayar'] ?></td>
                <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
            </tr>
        <?php $grand += $row['total']; endwhile; ?>
        </tbody>
        <tfoot>
        <tr class="fw-bold">
            <td colspan="8">Total</td>
            <td colspan="6">Rp<?= number_format($grand, 0, ',', '.') ?></td>
        </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
