<?php
session_start();
require '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $password = $_POST['password'];

    // cek mahasiswa
    $query = "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa' AND password_mahasiswa = PASSWORD('$password')";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        $mahasiswa = mysqli_fetch_assoc($result);
        $_SESSION['id_mahasiswa'] = $mahasiswa['id_mahasiswa'];
        $_SESSION['nama_mahasiswa'] = $mahasiswa['nama_mahasiswa'];
        header('Location: mahasiswa.php');
        exit;
    } else {
        $error = "ID atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Mahasiswa</title>
    <style>
        body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: linear-gradient(135deg, #4facfe, #00f2fe);
          margin: 0;
          padding: 0;
          height: 100vh;
          display: flex;
          justify-content: center;
          align-items: center;
        }
        .login-container {
          background: #fff;
          padding: 30px 40px;
          border-radius: 12px;
          box-shadow: 0 8px 20px rgba(0,0,0,0.2);
          width: 350px;
          text-align: center;
        }
        .login-container h2 {
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
          border-color: #4facfe;
        }
        button {
          width: 100%;
          padding: 10px;
          background: #4facfe;
          border: none;
          border-radius: 8px;
          color: white;
          font-size: 16px;
          cursor: pointer;
          transition: background 0.3s;
        }
        button:hover {
          background: #00c6fb;
        }
        .error {
          margin-top: 15px;
          color: red;
          font-size: 14px;
        }
    </style>
</head>
<body>
  <div class="login-container">
    <h2>Login Mahasiswa</h2>
    <form method="POST">
      <div class="form-group">
        <label for="id_mahasiswa">ID Mahasiswa</label>
        <input type="text" id="id_mahasiswa" name="id_mahasiswa" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
  </div>
</body>
</html>
