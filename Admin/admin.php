<?php
include '../db.php'; 
// 1. Total Orders
$orderQuery = mysqli_query($conn, "SELECT COUNT(*) as total_order FROM orders");
$orderData = $orderQuery->fetch_assoc();
$total_order = $orderData['total_order'];

// 2. Total Visitors
$visitorQuery = mysqli_query($conn, "SELECT SUM(guest_count) as total_visitors FROM reservations");
$visitorData = $visitorQuery->fetch_assoc();
$total_visitors = $visitorData['total_visitors'];

// 3. Total Sales
$salesQuery = mysqli_query($conn, "SELECT SUM(total) as total_sales FROM pembayaran");
$salesData = $salesQuery->fetch_assoc();
$total_sales = $salesData['total_sales'];

// SQL untuk recent orders
$sql = "
  SELECT r.name AS user_name, r.reservation_date AS date_order, o.status
  FROM orders o
  JOIN reservations r ON o.reservation_id = r.id
  ORDER BY o.id DESC
  LIMIT 10
";

$query = $conn->query($sql);

// Cek jika query gagal
if (!$query) {
    die("Query gagal: " . $koneksi->error);
}

// Fungsi badge status
function statusBadge($status) {
    switch ($status) {
        case 'belum': return '<span style="background-color:#ff9800;color:white;padding:5px 10px;border-radius:20px;">Pending</span>';
        case 'diproses': return '<span style="background-color:#ffeb3b;color:black;padding:5px 10px;border-radius:20px;">Process</span>';
        case 'selesai': return '<span style="background-color:#2196f3;color:white;padding:5px 10px;border-radius:20px;">Completed</span>';
        default: return '<span style="background-color:#9e9e9e;color:white;padding:5px 10px;border-radius:20px;">Unknown</span>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>AdminHub</title>
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
		<ul class="box-info">
			<li>
				<i class='bx bxs-calendar-check' ></i>
				<span class="text">
					<h3><?= $total_order ?></h3>
					<p>New Order</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-group' ></i>
				<span class="text">
					<h3><?= $total_visitors ?></h3>
					<p>Visitors</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-dollar-circle' ></i>
				<span class="text">
					<h3>Rp.<?= $total_sales ?></h3>
					<p>Total Sales</p>
				</span>
			</li>
		</ul>
		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Recent Orders</h3>
					<i class='bx bx-search' ></i>
					<i class='bx bx-filter' ></i>
				</div>
				<table>
					<thead>
						<tr>
							<th>User</th>
							<th>Date Order</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
    <?php while($row = $query->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['user_name']) ?></td>
      <td><?= date('d-m-Y', strtotime($row['date_order'])) ?></td>
      <td><?= statusBadge($row['status']) ?></td>
    </tr>
    <?php endwhile; ?>
  </tbody>
				</table>
			</div>
		</div>
	</main>
	<!-- MAIN -->
</section>
<!-- CONTENT -->
	

	<script src="js/scripts.js"></script>
</body>
</html>