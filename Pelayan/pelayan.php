<?php
include '../db.php'; 

$filter_tanggal = isset($_GET['tanggal']) && $_GET['tanggal'] !== '' ? $_GET['tanggal'] : date('Y-m-d');
$filter_nama = $_GET['nama'] ?? '';
$filter_jam = $_GET['jam'] ?? '';

$menu_result = mysqli_query($conn, "SELECT * FROM menu");
$menu_list = [];
while ($row = mysqli_fetch_assoc($menu_result)) {
    $menu_list[] = $row;
}

$meja_result = mysqli_query($conn, "SELECT * FROM tables");

$query_reservasi = "SELECT * FROM reservations WHERE reservation_date = '$filter_tanggal'";
if (!empty($filter_nama)) {
    $query_reservasi .= " AND name LIKE '%$filter_nama%'";
}
if (!empty($filter_jam)) {
    $query_reservasi .= " AND reservation_time = '$filter_jam'";
}
$reservasi_result = mysqli_query($conn, $query_reservasi);

$reservasi_meja = [];
while ($row = mysqli_fetch_assoc($reservasi_result)) {
    $reservasi_meja[$row['table_number']] = $row;
}

$tanggal = $filter_tanggal;
$mejaQuery = mysqli_query($conn, "SELECT * FROM tables ORDER BY id");
$mejaList = [];
while ($row = mysqli_fetch_assoc($mejaQuery)) {
    $mejaList[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <title>Pelayan Page</title>
</head>
<body>

    <?php include 'layouts/navbar.php'; ?>

    <main>
    <div class="head-title">
        <div class="left">
            <h1>Dashboard Pelayan</h1>
            <ul class="breadcrumb">
                <li><a href="#">Dashboard Pelayan</a></li>
                <li><i class='bx bx-chevron-right'></i></li>
            </ul>
        </div>
    </div>
    </main>

    <section class="home">
        <div class="container">
            <div class="row-center">
                <div class="title-box">
                    <h1>Daftar Meja - <?= date('d F Y', strtotime($filter_tanggal)) ?></h1>
                </div>
            </div>
            <div class="table-wrap">
                <form method="GET">
                    <input type="text" name="nama" placeholder="Cari Nama Pelanggan" value="<?= htmlspecialchars($filter_nama) ?>">
                    <input type="time" name="jam" value="<?= htmlspecialchars($filter_jam) ?>">
                    <input type="date" name="tanggal" value="<?= htmlspecialchars($filter_tanggal) ?>">
                    <button type="submit">Filter</button>
                    <a href="pelayan.php">reset</a>
                </form>
                <table class="custom-table">
                    <thead>
                    <tr>
                        <th>NOMOR MEJA</th>
                        <th>MAX ORANG</th>
                        <th>WAKTU</th>
                        <th>NAMA</th>
                        <th>TANGGAL</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $ada_data = false;
                    mysqli_data_seek($meja_result, 0);
                    while ($meja = mysqli_fetch_assoc($meja_result)):
                        $id_meja = $meja['id'];
                        if (!isset($reservasi_meja[$id_meja])) continue;
                        $reservasi = $reservasi_meja[$id_meja];
                        if ($reservasi['status_meja'] !== 'belum selesai') continue;
                        $ada_data = true;
                        ?>
                        <tr>
                            <td>Meja <?= $id_meja ?></td>
                            <td>(Kapasitas: <?= $meja['capacity'] ?>)</td>
                            <td><?= $reservasi['reservation_time'] ?></td>
                            <td><?= htmlspecialchars($reservasi['name']) ?></td>
                            <td><?= date('d-m-Y', strtotime($reservasi['reservation_date'])) ?></td>
                            <td><span class="taken">Dipesan</span></td>
                            <td>
                                <a href="#" class="btn-action pesanan" onclick="openPopup(<?= $id_meja ?>)">Pesanan</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                    <?php if (!$ada_data): ?>
                        <tr><td colspan="7" class="text-center">Tidak ada reservasi aktif.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php
        mysqli_data_seek($meja_result, 0);
        while ($meja = mysqli_fetch_assoc($meja_result)):
            $id_meja = $meja['id'];
            if (!isset($reservasi_meja[$id_meja])) continue;
            $reservasi = $reservasi_meja[$id_meja];
            $rid = $reservasi['id'];
            $result = mysqli_query($conn, "SELECT * FROM orders WHERE reservation_id = $rid");
            $makanan = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $makanan[] = $row;
            }
            ?>
            <div id="popup-<?= $id_meja ?>" class="modal fade" tabindex="-1" style="display: none; background-color: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content shadow rounded">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">Pesanan Meja <?= $id_meja ?></h5>
                            <span class="close" onclick="closePopup(<?= $id_meja ?>)">&times;</span>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group mb-3">
                                <?php if (empty($makanan)): ?>
                                    <li class="list-group-item text-muted"><em>Belum ada pesanan</em></li>
                                <?php else: ?>
                                    <?php foreach ($makanan as $m): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <form onsubmit="updatePesanan(event, this)" class="d-inline-flex align-items-center">
                                                    <input type="hidden" name="order_id" value="<?= $m['id'] ?>">
                                                    <span class="me-2"><?= htmlspecialchars($m['food']) ?> x</span>
                                                    <input type="number" name="qty" value="<?= (int)$m['qty'] ?>" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                                                    <span class="me-2 badge bg-secondary"><?= ucfirst($m['status']) ?></span>
                                                    <?php if ($m['status'] === 'belum'): ?>
                                                        <button type="submit" class="btn btn-sm btn-success" onclick="updatePesanan(<?= $m['id'] ?>, this)">💾</button>
                                                    <?php endif; ?>
                                                </form>

                                                <button type="button" class="btn btn-sm btn-danger ms-2" onclick="hapusPesanan(<?= $m['id'] ?>, this)">❌</button>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>

                            <form id="form-tambah-<?= $id_meja ?>" class="mb-3 d-flex align-items-center gap-2" onsubmit="tambahPesanan(event, <?= $id_meja ?>)">
                                <input type="hidden" name="reservation_id" value="<?= $reservasi['id'] ?>">
                                <select name="food" class="form-select" style="max-width: 200px;" required>
                                    <option value="">-- Pilih Makanan --</option>
                                    <?php foreach ($menu_list as $item): ?>
                                        <option value="<?= htmlspecialchars($item['name']) ?>"><?= htmlspecialchars($item['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="number" name="qty" value="1" min="1" class="form-control" style="width: 80px;" required>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </form>

                            <form method="POST" action="selesai_reservasi.php">
                                <input type="hidden" name="reservation_id" value="<?= $reservasi['id'] ?>">
                                <button type="submit" class="btn btn-success w-100" onclick="return confirm('Tandai reservasi selesai?')">✅ Tandai Reservasi Selesai</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </section>

    <script src="js/scripts.js"></script>

</body>
</html>
