<?php
include "koneksi.php"; // Pastikan koneksi database

$sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
$hasil = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Gallery</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #fdfdfd;
            color: #333;
        }
        /* Navbar */
        .navbar {
            background-color: #6c63ff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
        .nav-link {
            color: #fff !important;
        }
        /* Hero Section */
        header {
            background: linear-gradient(to right, #6c63ff, #b19cd9);
            color: white;
        }
        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }
        .card img {
            width: 100%;
            aspect-ratio: 1 / 1; /* Membuat gambar tetap dalam rasio 1:1 */
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border: 5px solid #ffffff; /* Bingkai putih di sekitar gambar */
            padding: 5px; /* Jarak antara gambar dan bingkai */
            background-color: #eaeaea; /* Warna background bingkai */
        }
        /* Footer */
        .footer {
            background-color: #6c63ff;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">My Gallery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Article</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index_gallery.php">Gallery</a>
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <!-- Hero Section -->
    <header class="text-center py-5">
        <div class="container">
            <h1>Selamat Datang di My Gallery</h1>
            <p class="lead">Kumpulan gambar terbaru dan menarik</p>
        </div>
    </header>

    <!-- Articles Section -->
    <section id="articles" class="container my-5">
        <h2 class="text-center mb-5" style="color: #6c63ff;">Daftar Artikel</h2>
        <div class="row g-4">
            <?php while ($row = $hasil->fetch_assoc()) { ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <?php if (!empty($row["gambar"]) && file_exists('img/' . $row["gambar"])) { ?>
                            <img src="img/<?= $row["gambar"] ?>" class="card-img-top" alt="<?= htmlspecialchars($row["judul"]) ?>">
                        <?php } else { ?>
                            <img src="https://via.placeholder.com/400" class="card-img-top" alt="Placeholder">
                        <?php } ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($row["judul"]) ?></h5>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-3 text-center">
        <div class="container">
            <p class="mb-0">&copy; 2024 My Articles. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
