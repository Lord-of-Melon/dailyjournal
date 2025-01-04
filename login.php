<?php
//memulai session atau melanjutkan session yang sudah ada
session_start();

//menyertakan code dari file koneksi
include "koneksi.php";

//check jika sudah ada user yang login arahkan ke halaman admin
if (isset($_SESSION['username'])) { 
	header("location:admin.php"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  
  //menggunakan fungsi enkripsi md5 supaya sama dengan password  yang tersimpan di database
  $password = md5($_POST['password']);

	//prepared statement
  $stmt = $conn->prepare("SELECT username 
                          FROM users 
                          WHERE username=? AND password=?");

	//parameter binding 
  $stmt->bind_param("ss", $username, $password);//username string dan password string
  
  //database executes the statement
  $stmt->execute();
  
  //menampung hasil eksekusi
  $hasil = $stmt->get_result();
  
  //mengambil baris dari hasil sebagai array asosiatif
  $row = $hasil->fetch_array(MYSQLI_ASSOC);

  //check apakah ada baris hasil data user yang cocok
  if (!empty($row)) {
    //jika ada, simpan variable username pada session
    $_SESSION['username'] = $row['username'];

    //mengalihkan ke halaman admin
    header("location:admin.php");
  } else {
	  //jika tidak ada (gagal), alihkan kembali ke halaman login
    header("location:login.php");
  }

	//menutup koneksi database
  $stmt->close();
  $conn->close();
} else {
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login dan Logout</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: Arial, sans-serif;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f5f5f5;
            }
            .container {
                width: 100%;
                max-width: 400px;
                background: #ffffff;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                border-radius: 8px;
            }
            h2 {
                text-align: center;
                margin-bottom: 20px;
            }
            form {
                display: flex;
                flex-direction: column;
            }
            input {
                margin-bottom: 15px;
                padding: 10px;
                font-size: 16px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }
            button {
                padding: 10px;
                font-size: 16px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            button:hover {
                background-color: #0056b3;
            }
            .error {
                color: red;
                margin-bottom: 15px;
                text-align: center;
            }
            .logout {
                text-align: center;
            }
            .logout a {
                color: #007bff;
                text-decoration: none;
            }
            .logout a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <?php if (isset($_SESSION['username'])): ?>
                <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                <div class="logout">
                    <a href="?logout">Logout</a>
                </div>
            <?php else: ?>
                <h2>Login</h2>
                <!-- <?php if ($error_message): ?>
                    <div class="error"><?php echo $error_message; ?></div>
                <?php endif; ?> -->
                <form method="POST">
                    <input type="text" name="username" placeholder="username" required>
                    <input type="password" name="password" placeholder="password" required>
                    <button type="submit" name="login">Login</button>
                </form>
            <?php endif; ?>
        </div>
    </body>
    </html>
<?php
}
?>