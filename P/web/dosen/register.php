<?php
session_start();
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_dosen = mysqli_real_escape_string($koneksi, $_POST['id_dosen']);
    $nama_dosen = mysqli_real_escape_string($koneksi, $_POST['nama_dosen']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($koneksi, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Password dan Konfirmasi Password tidak sama!";
    } else {

        $cek = mysqli_query($koneksi, "SELECT * FROM dosen WHERE id_dosen = '$id_dosen'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "ID Dosen sudah terdaftar!";
        } else {

            $query = "INSERT INTO dosen (id_dosen, nama_dosen, password) 
                      VALUES ('$id_dosen', '$nama_dosen', PASSWORD('$password'))";

            if (mysqli_query($koneksi, $query)) {
                $_SESSION['id_dosen'] = $id_dosen;
                $_SESSION['nama_dosen'] = $nama_dosen;
                header("Location: dashboard_dosen.php");
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
    <title>Register Dosen</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #43e97b, #38f9d7);
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
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
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
            border-color: #43e97b;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #43e97b;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #38f9d7;
        }
        .error {
            margin-top: 15px;
            color: red;
            font-size: 14px;
        }
        .login-link {
            margin-top: 15px;
            display: block;
            font-size: 14px;
            color: #333;
        }
        .login-link a {
            color: #43e97b;
            text-decoration: none;
        }
        .login-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
  <div class="register-container">
    <h2>Register Dosen Pembimbing</h2>
    <form method="POST">
      <div class="form-group">
        <label for="id_dosen">ID Dosen</label>
        <input type="text" id="id_dosen" name="id_dosen" required>
      </div>
      <div class="form-group">
        <label for="nama_dosen">Nama Dosen</label>
        <input type="text" id="nama_dosen" name="nama_dosen" required>
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
