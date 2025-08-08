<?php include '../db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <link rel="stylesheet" href="css/menu.css">
</head>
<body>
  <?php include 'layouts/app.php'; ?>

  <!-- Hero Section -->
<section class="hero">
  <img src="img/food3.jpg" alt="Kayumanis Dish" class="hero-img">
</section>

<section class="menu-section">
  <h2 class="menu-title">FOOD MENU</h2>
  <h4 class="menu-subtitle">Check Our Tasty Menu</h4>

  <div class="menu-items">
    <?php
    $query = mysqli_query($conn, "SELECT * FROM menu WHERE jenis = 'Makanan Berat' AND tersedia = 1");

    while ($row = mysqli_fetch_assoc($query)) :
    ?>
      <div class="menu-item">
        <img src="img/<?= $row['gambar'] ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <div class="item-text">
          <h4><?= htmlspecialchars($row['name']) ?></h4>
          <p><?= htmlspecialchars($row['jenis']) ?></p>
        </div>
        <div class="price">Rp <?= number_format($row['harga'], 0, ',', '.') ?></div>
      </div>
    <?php endwhile; ?>
  </div>
</section>

<?php include 'layouts/footer.php'; ?>
</body>
</html>
