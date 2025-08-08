<?php include '../db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kasir Page</title>
</head>
<body>

	<?php include 'layouts/navbar.php'; ?>

	<!-- MAIN -->
	<main>
		<div class="head-title">
			<div class="left">
				<h1>Dashboard</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Dashboard</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<!-- <li>
						<a class="active" href="#">Home</a>
					</li> -->
				</ul>
			</div>
		</div>
    </main>
	<div class="container">
	    <h2 class="titles">💵 Tagihan Belum Dibayar</h2>
	    <?php
	    $result = mysqli_query($conn, "SELECT * FROM reservations WHERE status_meja = 'belum selesai'");
	    if (mysqli_num_rows($result) === 0) {
	        echo "<div class='alert alert-info'>Tidak ada reservasi yang perlu dibayar.</div>";
	    }
	    ?>
	    <div class="grid-cards">
	        <?php while ($r = mysqli_fetch_assoc($result)): 
	            $reservation_id = $r['id'];
	            $total = 0;
	            $orders = mysqli_query($conn, "SELECT * FROM orders WHERE reservation_id = $reservation_id");
				
	        ?>
	            <div class="cards">
	                <div class="card-body">
	                    <h5 class="card-title">🪑 Meja #<?= $r['table_number'] ?> - <?= htmlspecialchars($r['name']) ?></h5>
	                    <ul class="list-group">
	                    <?php
	                    while ($item = mysqli_fetch_assoc($orders)):
	                        $food = mysqli_real_escape_string($conn, $item['food']);
	                        $menu = mysqli_query($conn, "SELECT harga FROM menu WHERE name = '$food'");
	                        $harga = mysqli_fetch_assoc($menu)['harga'] ?? 0;
	                        $subtotal = $harga * $item['qty'];
	                        $total += $subtotal;
	                    ?>
	                        <li class="list-group-item d-flex justify-content-between">
	                            <?= htmlspecialchars($item['food']) ?> x <?= $item['qty'] ?>
	                            <span>Rp<?= number_format($subtotal, 0, ',', '.') ?></span>
	                        </li>
	                    <?php endwhile; ?>
	                    </ul>
						
	                    <h6 class="text-end">Total: <strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></h6>
						
	                    <form method="POST" action="printstruk.php">
							<input type="hidden" name="status_meja" value="<?= $r['status'] ?>">
							<input type="hidden" name="reservation_date" value="<?= $r['reservation_date'] ?>">
							<input type="hidden" name="reservation_time" value="<?= $r['reservation_time'] ?>">
							<input type="hidden" name="table_number" value="<?= $r['table_number'] ?>">
							<input type="hidden" name="nama" value="<?= htmlspecialchars($r['name']) ?>">
	                        <input type="hidden" name="reservation_id" value="<?= $reservation_id ?>">
	                        <input type="hidden" name="total" value="<?= $total ?>">
						
	                        <div class="list">
	                            <label class="form-label">Uang Bayar</label>
	                            <input type="number" name="uang_bayar" min="<?= $total ?>" class="form-control" required>
	                        </div>
						
	                        <div class="list">
	                            <label class="form-label">Metode Pembayaran</label>
	                            <select name="metode" class="form-select" required>
									<option value="">-- Pilih Metode Pembayaran --</option>
	                                <option value="Tunai">Tunai</option>
	                                <option value="QRIS">QRIS</option>
	                                <option value="Debit">Debit</option>
	                            </select>
	                        </div>
						
	                        <div class="list">
	                            <label class="form-label">Keterangan Pembayaran (opsional)</label>
	                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: DP 50%, bayar sebagian, pakai promo..."></textarea>
	                        </div>
							 <button type="submit" class="btn btn-cetak">🖨 Cetak Struk</button>

	                    </form>
	                </div>
	            </div>
	        <?php endwhile; ?>
	    </div>
	</div>

	<script src="js/scripts.js"></script>
</body>
</html>        