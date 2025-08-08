<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resto Jinji</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Gabungkan Top Bar dan Navbar dalam 1 wrapper -->
    <div class="header-wrapper">
      <!-- Top Contact Bar -->
      <div class="top-bar">
        <div class="top-left">
          <span><i class="fas fa-phone-alt"></i> +62 361 705 777</span>
          <span><i class="fab fa-whatsapp"></i> +62 817 7570 5777</span>
        </div>
        <div class="top-right">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <!-- Navbar -->
      <header class="navbar">
        <div class="logo">
          <h1><a href="index.php">Restaurant Jinji</a></h1>
        </div>
        <nav class="nav-links">
          <a href="index.php" class="nav-link">HOME</a>
          <a href="about.php" class="nav-link">ABOUT US</a>

          <div class="dropdown">
            <a href="#" class="nav-link">MENU ▾</a>
            <div class="dropdown-content">
              <a href="food.php" class="nav-link">Food</a>
              <a href="drink.php" class="nav-link">Drinks</a>
              <a href="dessert.php" class="nav-link">Dessert</a>
            </div>
          </div>

          <a href="gallery.php" class="nav-link">GALLERY</a>
          <!-- <a href="offers.php" class="nav-link">SPECIAL OFFER & GIFT</a>

          <div class="dropdown">
            <a href="#" class="nav-link">EVENT & ACTIVITIES ▾</a>
            <div class="dropdown-content">
              <a href="wedding.php" class="nav-link">Wedding</a>
              <a href="birthday.php" class="nav-link">Birthday</a>
            </div>
          </div> -->

          <a href="reservasi.php" class="btn-reservation nav-link">RESERVATION</a>
        </nav>
      </header>
    </div>


  <!-- WhatsApp Floating Button -->
  <div class="whatsapp-container">
    <div class="chat-bubble">
      Need Help? <strong>Chat with us</strong>
    </div>
    <a href="#" target="_blank" class="whatsapp-button">
      <i class="fab fa-whatsapp"></i>
    </a>
  </div>
  

  <script>
    const links = document.querySelectorAll('.nav-link');
    const currentPage = window.location.pathname.split('/').pop();

    links.forEach(link => {
      const href = link.getAttribute('href');
      if (href === currentPage) {
        link.classList.add('active');
      }
    });
  </script>
</body>
</html>