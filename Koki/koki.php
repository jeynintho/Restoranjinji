<?php
include '../db.php';

$query = "SELECT o.id, o.food, o.qty, o.status, r.table_number, r.name
          FROM orders o
          JOIN reservations r ON o.reservation_id = r.id
          WHERE r.reservation_date = CURDATE()
          ORDER BY r.table_number, o.id";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Koki Page</title>
</head>
<body>

	<?php include 'layouts/navbar.php'; ?>

	<!-- MAIN -->
	<main>
		<div class="head-title">
			<div class="left">
				<h1>Dashboard Koki</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Dashboard Koki</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<!-- <li>
						<a class="active" href="#">Home</a>
					</li> -->
				</ul>
			</div>
		</div>
    </main>
	<h1>Daftar Pesanan Masuk (Hari Ini)</h1>
	<table border="1 " cellpadding="8" cellspacing="0">
	    <tr>
	        <th>Meja</th>
	        <th>Nama</th>
	        <th>Makanan</th>
	        <th>Jumlah</th>
	        <th>Status</th>
	        <th>Aksi</th>
	    </tr>
	    <?php while ($row = mysqli_fetch_assoc($result)): ?>
	        <tr>
	            <td><?= $row['table_number'] ?></td>
	            <td><?= htmlspecialchars($row['name']) ?></td>
	            <td><?= htmlspecialchars($row['food']) ?></td>
	            <td><?= $row['qty'] ?></td>
	            <td><?= ucfirst($row['status']) ?></td>
	            <td>
	                <?php if ($row['status'] === 'belum'): ?>
	                    <form method="POST" action="koki_update.php">
	                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
	                        <input type="hidden" name="status" value="diproses">
	                        <button type="submit">Masak</button>
	                    </form>
	                <?php elseif ($row['status'] === 'diproses'): ?>
	                    <form method="POST" action="koki_update.php">
	                        <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
	                        <input type="hidden" name="status" value="selesai">
	                        <button type="submit">Selesai</button>
	                    </form>
	                <?php else: ?>
	                    ✅
	                <?php endif; ?>
	            </td>
	        </tr>
	    <?php endwhile; ?>
	</table>
	
	<script src="js/scripts.js"></script>
</body>
</html>           