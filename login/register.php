<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel Register</title>
  <link rel="stylesheet" href="css/style.css" />
  <style>select {
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      background-image: url("data:image/svg+xml;utf8,<svg fill='%23ffffff' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
      background-repeat: no-repeat;
      background-position: right 10px center;
      background-size: 16px;
      padding-right: 30px;
      border-radius: 0;
    }</style>
</head>
<body>
  <div class="login-box">
    <div class="icon">
      🔑
    </div>
    <h2>REGISTER</h2>
    <form action="proses_register.php" method="post">
      <label for="username">USERNAME</label>
      <input type="text" id="username" name="username" required />

      <label for="email">EMAIL</label>
      <input type="email" id="email" name="email" required />

      <label for="password">PASSWORD</label>
      <input type="password" id="password" name="password" required />

      <label for="confirm-password">CONFIRM PASSWORD</label>
      <input type="password" id="confirm-password" name="confirm-password" required />

      <label for="role">ROLE</label>
      <select id="role" name="role" required>
        <option value="" disabled selected hidden>Pilih Role</option>
        <option value="admin">Admin</option>
        <option value="pelayan">Pelayan</option>
        <option value="kasir">Kasir</option>
        <option value="koki">Koki</option>
      </select>

      <div class="button-group single-button">
        <button type="submit" class="login-btn">REGISTER</button>
      </div>
      <p style="margin-top: 15px; color: #aaa; font-size: 13px;">
          Already have an account?
          <a href="login.php" style="color: #00c3ff;">Login</a>
      </p>
    </form>
  </div>
</body>
</html>
