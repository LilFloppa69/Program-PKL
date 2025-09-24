
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
          margin: 15px 0 15px 0;
          text-decoration: none;
        }
        button:hover {
          background: #00c6fb;
        }
        a {
          color: white;
          text-decoration: none;
        }
    </style>
</head>
<body>
  <div class="login-container">
    <h2>Masuk Sebagai:</h2>
    <form method="POST">
      <button type="submit"><a href="./dosen/login.php">Dosen</a></button>
      <button type="submit"><a href="./mahasiswa//login.php">Mahasiswa</a></button>
      <button type="submit"><a href="./mitra/login.php">Mitra</a></button>
    </form>
  </div>
</body>
</html>
