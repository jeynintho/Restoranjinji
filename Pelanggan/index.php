<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
  <?php include 'layouts/app.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <img src="img/banner4.jpg" alt="Kayumanis Dish" class="hero-img">
  </section>

  <!-- About Section Start -->
  <section class="about-section">
    <div class="about-content">
      <div class="about-text">
        <h2>ABOUT OUR SHOP</h2>
        <p>
          The approach to the menu was easy. We had no interest in trying to reinvent food.
          We went with choices that were popular catering requests — basic, down-home style — just from a wide range of regions.
          We are known for our generous portions of BBQ, Southern, Cajun/Creole meals, plus a touch of Caribbean fun.
          We will tell you now – save room for dessert! 
        </p>
        <a href="about.php" class="read-more">READ MORE</a>
      </div>
      <div class="about-image">
        <img src="img/about.jpg" alt="Woman smiling">
      </div>
    </div>
  </section>
  <!-- About Section End -->

  <!-- Menu Section Start -->
  <section class="menu-section">

      <div class="menu-card">
        <a href="food.php">
          <img src="img/p1.jpg" alt="Wine Selections">
          <h3>FOOD MENU</h3>
          <p>MORE DETAILS</p>
        </a>
      </div>

      <div class="menu-card">
        <a href="drink.php"></a>
          <img src="img/d1.jpg" alt="Beverages">
          <h3>DRINK MENU</h3>
          <p>MORE DETAILS</p>
        </a>
      </div>

      <div class="menu-card">
        <a href="dessert.php">
          <img src="img/s1.jpg" alt="Kids Menu">
          <h3>DESSERT MENU</h3>
          <p>MORE DETAILS</p>
        </a>
      </div>

  </section>
  <!-- Menu Section End -->

  <!-- Gallery Section Start -->
  <div class="grid-container">
    <div class="grid-item"><img src="img/p1.jpg" alt=""></div>
    <div class="grid-item"><img src="img/p2.jpg" alt=""></div>
    <div class="grid-item"><img src="img/p3.jpg" alt=""></div>
    <div class="grid-item"><img src="img/d1.jpg" alt=""></div>
    <div class="grid-item"><img src="img/d2.jpg" alt=""></div>
    <div class="grid-item"><img src="img/d3.jpg" alt=""></div>
    <div class="grid-item"><img src="img/s1.jpg" alt=""></div>
    <div class="grid-item"><img src="img/s2.jpg" alt=""></div>
    <div class="grid-item"><img src="img/s3.jpg" alt=""></div>
  </div> 
  <!-- Gallery Section End -->

  <?php include 'layouts/footer.php'; ?>
</body>
</html>
