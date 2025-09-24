<?php
session_start();
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_mitra = mysqli_real_escape_string($koneksi, $_POST['id_mitra']);
    $nama_mitra = mysqli_real_escape_string($koneksi, $_POST['nama_mitra']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

    // Cek password sama
    if ($password !== $confirm_password) {
        $error = "Password dan Konfirmasi Password tidak sama!";
    } else {
        // Cek apakah ID mitra sudah ada
        $cek = mysqli_query($koneksi, "SELECT * FROM mitra WHERE id_mitra = '$id_mitra'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "ID Mitra sudah terdaftar!";
        } else {
            // Simpan ke database (pakai PASSWORD() biar sama dengan login Anda)
            $query = "INSERT INTO mitra (id_mitra, nama_mitra, password) 
                      VALUES ('$id_mitra', '$nama_mitra', PASSWORD('$password'))";

            if (mysqli_query($koneksi, $query)) {
                $_SESSION['id_mitra'] = $id_mitra;
                $_SESSION['nama_mitra'] = $nama_mitra;
                header("Location: dashboard_mitra.php");
                exit();
            } else {
                $error = "Terjadi kesalahan saat registrasi!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Mitra</title>
    <style>
        body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: linear-gradient(135deg, #ff9966, #ff5e62);
          margin: 0;
          padding: 0;
          height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .register-container {
          background: #fff;
          padding: 30px 40px;
          border-radius: 12px;
          box-shadow: 0 8px 20px rgba(0,0,0,0.2);
          width: 380px;
          text-align: center;
        }
        .register-container h2 {
          margin-bottom: 20px;
          color: #333;
        }
        .form-group {
          text-align: left;
          margin-bottom: 15px;
        }
        .form-group label {
          display: block;
          margin-bottom: 5px;
          color: #555;
          font-size: 14px;
        }
        .form-group input {
          width: 100%;
          padding: 10px;
          border-radius: 8px;
          border: 1px solid #ccc;
          outline: none;
          font-size: 14px;
          transition: border 0.3s;
        }
        .form-group input:focus {
          border-color: #ff5e62;
        }
        button {
          width: 100%;
          padding: 10px;
          background: #ff5e62;
          border: none;
          border-radius: 8px;
          color: white;
          font-size: 16px;
          cursor: pointer;
          transition: background 0.3s;
        }
        button:hover {
          background: #ff3b40;
        }
        .error {
          margin-top: 15px;
          color: red;
          font-size: 14px;
        }
        .login-link {
          margin-top: 15px;
          font-size: 14px;
          color: #333;
        }
        .login-link a {
          color: #ff5e62;
          text-decoration: none;
        }
        .login-link a:hover {
          text-decoration: underline;
        }
    </style>
</head>
<body>
  <div class="register-container">
    <h2>Register Mitra</h2>
    <form method="POST">
      <div class="form-group">
        <label for="id_mitra">ID Mitra</label>
        <input type="text" id="id_mitra" name="id_mitra" required>
      </div>
      <div class="form-group">
        <label for="nama_mitra">Nama Mitra</label>
        <input type="text" id="nama_mitra" name="nama_mitra" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirm_password">Konfirmasi Password</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
      </div>
      <button type="submit">Register</button>
    </form>
    <div class="login-link">
        Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
  </div>
</body>
</html>
