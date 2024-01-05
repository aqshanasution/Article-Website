<?php
// Mengimpor file koneksi.php yang berisi informasi koneksi database
include 'koneksi.php';

// Memulai sesi PHP untuk pengelolaan sesi
session_start();

// Membuat objek koneksi database menggunakan informasi dari koneksi.php
$conn = new mysqli($host, $username, $password, $database);

// Mengecek koneksi database, jika gagal maka program akan berhenti dan menampilkan pesan kesalahan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil artikel yang telah dipublikasikan, diurutkan berdasarkan tanggal publish secara descending
$query = "SELECT * FROM artikel WHERE status = 1 ORDER BY tgl_publish DESC";

// Menjalankan query dan menyimpan hasilnya dalam variabel $result
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Published Articles</title>
    <!-- Mengimpor file CSS Bootstrap untuk tata letak dan desain -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #EEF5FF;
            padding-top: 10vh;
        }

        .navbar {
            background-color: #176B87;
            font-family: 'Istok Web', sans-serif;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 5vh;
            color: #000;
        }

        .container-main {
            background-color: #F3F8FF;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 0px;
            margin-top: 20px;
        }

        h2 {
            color: #176B87;
        }

        .nav-link {
            color: #FFF;
            display: inline-block;
            padding: 10px;
            border-radius: 20px;
            font-size: 20px;
        }

        .article-list {
            margin-top: 20px;
        }

        .card {
            margin-bottom: 40px;
            background-color: #FFF;
            color: #000;
            border-radius: 10px;
        }

        .card img {
            max-height: 200px;
            object-fit: cover;
            border: 2px #49108B;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-title {
            color: #176B87;
        }

        .card-text {
            color: #555;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .login-button,
        .nav-link-custom {
            font-family: 'Istok Web', sans-serif;
            opacity: 70%;
            border-radius: 20px;
            font-size: 20px;
        }

        .login-button:hover,
        .nav-link-custom:hover {
            opacity: 90%;
        }        
    </style>
</head>

<body>
    <!-- Bagian navigasi (navbar) halaman -->
    <nav class="navbar navbar-expand-lg navbar-dark #E26EE5 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">E-Mading</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <button type="button" class="btn btn-light login-button">Dashboard</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bagian utama konten halaman -->
    <div class="container-main">
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Artikel Terkini</h2>
                <!-- Menampilkan daftar artikel yang telah dipublikasikan dalam bentuk kartu (card) -->
                <div class="row article-list">
                    <?php
                    // Mengulang selama masih ada baris (artikel) dalam hasil query
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <!-- Bagian untuk setiap artikel dalam bentuk kartu (card) -->
                        <div class="col-md-4">
                            <div class="card">
                                <!-- Tautan (link) untuk menuju halaman detail artikel -->
                                <a href="detail_artikel.php?id=<?php echo $row['id']; ?>">
                                    <!-- Menampilkan gambar artikel sebagai bagian atas kartu -->
                                    <img src="<?php echo $row['gambar']; ?>" class="card-img-top" alt="...">
                                    <!-- Informasi judul dan deskripsi artikel -->
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                                        <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Mengimpor file JavaScript Bootstrap untuk dukungan fungsi interaktif -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
