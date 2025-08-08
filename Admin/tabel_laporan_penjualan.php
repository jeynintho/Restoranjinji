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

$data_array = [];
$grand = 0;
while ($row = mysqli_fetch_assoc($data)) {
    $data_array[] = $row;
    $grand += $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Laporan Penjualan</title>

</head>
<body>
    
	<?php include 'layouts/navbar.php'; ?>

    <main>
		<div class="head-title">
			<div class="left">
				<h1>Laporan Penjualan</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Laporan Penjualan</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<li>
						<a class="active" href="#">Home</a>
					</li>
				</ul>
			</div>
			<a href="cetak_riwayat_Penjualan.php" class="btn-download">
				<i class='bx bxs-cloud-download'></i>
				<span class="text">Cetak laporan Penjualan</span>
			</a>
		</div>
		
        <div class="container-laporan">
            <div class="filter-container">
                <h2>Filter Laporan Penjualan</h2>
				<!-- Filter Tanggal -->
				<form>
					<div class="form-group">
						<div class="input-group">
        					<select name="filter" class="form-select" onchange="this.form.submit()">
     	   					    <option value="hari" <?= $filter === 'hari' ? 'selected' : '' ?>>Harian</option>
     	   					    <option value="minggu" <?= $filter === 'minggu' ? 'selected' : '' ?>>Mingguan</option>
     	   					    <option value="bulan" <?= $filter === 'bulan' ? 'selected' : '' ?>>Bulanan</option>
     	   					    <option value="tahun" <?= $filter === 'tahun' ? 'selected' : '' ?>>Tahunan</option>
     	   					</select>	
    					</div>
						<div class="input-group">
    					    <input type="text" name="nama" placeholder="Cari nama pelanggan..." class="form-control"
    					           value="<?= htmlspecialchars($_GET['nama'] ?? '') ?>">
    					</div>
						<?php if ($filter === 'hari' || $filter === 'minggu'): ?>
        				<div class="input-group">
        				    <input type="date" name="tanggal" value="<?= $tanggal ?>" class="form-control">
        				</div>
						<?php elseif ($filter === 'bulan'): ?>
						<div class="input-group">
        				    <select name="bulan" class="form-select">
        				        <?php for ($i = 1; $i <= 12; $i++): ?>
        				            <option value="<?= $i ?>" <?= $bulan == $i ? 'selected' : '' ?>>
        				                <?= date('F', mktime(0, 0, 0, $i, 10)) ?>
        				            </option>
        				        <?php endfor; ?>
        				    </select>
        				</div>	
						<div class="input-group">
        				    <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control" min="2000">
        				</div>
						<?php elseif ($filter === 'tahun'): ?>
    					    <div class="input-group">
    					        <input type="number" name="tahun" value="<?= $tahun ?>" class="form-control" min="2000">
    					    </div>
    					<?php endif; ?>
    					<button type="submit" class="filter-btn">Tampilkan</button>
					</div>
				</form>	
            </div>
        </div>
        
        <!-- Tabel Start -->
        <div class="laporan-tabel"> 
            <div class="laporan-container">
                <div class="laporan-header">
                    <!-- <h3>Laporan dari 01 Jun 2025 sampai 30 Jun 2025</h3> -->
					<h3><?= $judul ?></h3>
                    <div class="total-pendapatan">
                        <p>Total Pendapatan</p>
						<h2>Rp<?= number_format($grand, 0, ',', '.') ?></h2>
                    </div>
                </div>
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
                        <?php $no = 1; foreach ($data_array as $row): ?>
        					<tr>
        					    <td><?= $no++ ?></td>
        					    <td><?= htmlspecialchars($row['name']) ?></td>
        					    <td>Meja <?= $row['table_number'] ?></td>
								<td><?= htmlspecialchars($row['metode']) ?></td>
        					    <td>Rp<?= number_format($row['uang_bayar'], 0, ',', '.') ?></td>
        					    <td>Rp<?= number_format($row['kembalian'], 0, ',', '.') ?></td>
        					    <td><?= htmlspecialchars($row['keterangan'] ?? '-') ?></td>
        					    <td><?= $row['waktu_bayar'] ?></td>
        					    <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
        					</tr>
    						<?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>    
        <!-- Tabel End -->
    </main>      
	<!-- NAVBAR END -->


    <script src="js/scripts.js"></script>
</body>
</html>