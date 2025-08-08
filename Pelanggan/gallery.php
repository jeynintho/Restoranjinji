<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gallery.css">
</head>
<body>
  <?php include 'layouts/app.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <img src="img/gallery.jpg" alt="Kayumanis Dish" class="hero-img">
  </section>

  <!-- Content Section Food -->
  <section class="gallery-section">
    <h2 class="gallery-title"> <span>—</span> FOOD & BEVERAGES <span>—</span> </h2>

    <div class="gallery-grid">
      <img src="img/p1.jpg" alt="Food 1" onclick="openPopup(this)">
      <img src="img/p2.jpg" alt="Food 2" onclick="openPopup(this)">
      <img src="img/p3.jpg" alt="Food 3" onclick="openPopup(this)">
      <img src="img/p4.jpg" alt="Food 4" onclick="openPopup(this)">
      <img src="img/p5.jpg" alt="Food 5" onclick="openPopup(this)">
      <img src="img/p6.jpg" alt="Food 6" onclick="openPopup(this)">
      <img src="img/p7.jpg" alt="Food 7" onclick="openPopup(this)">
      <img src="img/p8.jpg" alt="Food 8" onclick="openPopup(this)">
      <img src="img/p9.jpg" alt="Food 9" onclick="openPopup(this)">
      <img src="img/p10.jpg" alt="Food 10" onclick="openPopup(this)">
      <!-- Tambah sampai 10 -->
    </div>
  </section> 

  <!-- Content Section Drink -->
  <section class="gallery-section">
    <h2 class="gallery-title"> <span>—</span> DRINK & DESSERT <span>—</span> </h2>

    <div class="gallery-grid">
      <img src="img/d1.jpg" alt="Drink 1" onclick="openPopup(this)">
      <img src="img/d2.jpg" alt="Drink 2" onclick="openPopup(this)">
      <img src="img/d3.jpg" alt="Drink 3" onclick="openPopup(this)">
      <img src="img/d4.jpg" alt="Drink 4" onclick="openPopup(this)">
      <img src="img/d5.jpg" alt="Drink 5" onclick="openPopup(this)">
      <img src="img/s1.jpg" alt="Dessert 1" onclick="openPopup(this)">
      <img src="img/s2.jpg" alt="Dessert 2" onclick="openPopup(this)">
      <img src="img/s3.jpg" alt="Dessert 3" onclick="openPopup(this)">
      <img src="img/s4.jpg" alt="Dessert 4" onclick="openPopup(this)">
      <img src="img/s5.jpg" alt="Dessert 5" onclick="openPopup(this)">
      <!-- Tambah sampai 10 -->
    </div>
  </section> 

  <!-- Popup Overlay with Navigation -->
  <div id="popup" class="popup">
    <span class="close" onclick="closePopup()">&times;</span>
    <button class="prev" onclick="prevSlide()">❮</button>
    <img class="popup-content" id="popup-img">
    <button class="next" onclick="nextSlide()">❯</button>
  </div>

  <?php include 'layouts/footer.php'; ?>


  <script>
    let currentIndex = 0;
    let allImages = [];
  
    function openPopup(img) {
      allImages = Array.from(document.querySelectorAll('.gallery-grid img'));
      currentIndex = allImages.indexOf(img);
    
      const popup = document.getElementById("popup");
      const popupImg = document.getElementById("popup-img");
      popup.style.display = "block";
      popupImg.src = img.src;
    }
  
    function closePopup() {
      document.getElementById("popup").style.display = "none";
    }
  
    function showSlide(index) {
      if (index < 0) index = allImages.length - 1;
      if (index >= allImages.length) index = 0;
      currentIndex = index;
      document.getElementById("popup-img").src = allImages[currentIndex].src;
    }
  
    function prevSlide() {
      showSlide(currentIndex - 1);
    }
  
    function nextSlide() {
      showSlide(currentIndex + 1);
    }
  </script>


</body>
</html>
