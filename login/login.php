<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel Login</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <div class="login-box">
    <div class="icon">
      🔑
    </div>
    <h2>LOGIN PANEL</h2>
    
    <!-- Tambahkan action dan method agar bisa proses login -->
    <form action="proses_login.php" method="POST">
      <label for="username">USERNAME</label>
      <input type="text" id="username" name="username" required />

      <label for="password">PASSWORD</label>
      <input type="password" id="password" name="password" required />

      <!-- Forgot Password Link -->
      <!--<div class="forgot-password">-->
      <!--  <a href="forgotpassword.php">Forgot Password?</a>-->
      <!--</div>-->

      <div class="button-group">
        <button type="submit" class="login-btn">LOGIN</button>
        <!-- Ganti button nested jadi <a> biasa -->
        <a href="register.php" class="register-btn">REGISTER</a>
      </div>
    </form>
  </div>
</body>
</html>
