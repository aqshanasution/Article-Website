<?php
// Sertakan file koneksi.php yang berisi informasi koneksi database
include 'koneksi.php';

// Mulai sesi untuk pengelolaan variabel sesi
session_start();

// Membuat objek koneksi database menggunakan informasi dari file koneksi.php
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa apakah koneksi database berhasil
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan kesalahan
    die("Connection failed: " . $conn->connect_error);
}

// Proses pencarian artikel berdasarkan kata kunci
if (isset($_GET['q'])) {
    $keyword = $_GET['q'];
    // Query untuk mencari artikel yang memiliki judul atau deskripsi mengandung kata kunci
    $query = "SELECT * FROM artikel WHERE status = 1 AND (judul LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%') ORDER BY tgl_publish DESC";
} else {
    // Tampilkan semua artikel jika tidak ada kata kunci pencarian
    $query = "SELECT * FROM artikel WHERE status = 1 ORDER BY tgl_publish DESC";
}

// Eksekusi query dan simpan hasilnya ke dalam variabel $result
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Published Articles</title>

    <!-- Sertakan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Gaya tampilan halaman web */
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
            padding: 10px;
            border-radius: 20px;
            font-size: 20px;
        }

        .nav-item {
            margin-right: 20px;
        }

        .list-group {
            border-radius: 10px;
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

        .form-control-me-2 {
            border-radius: 20px;
            margin-right: 10px; /* Menambahkan jarak ke kanan */
        }

        .search-button,
        .login-button { /* Gabungkan gaya tombol pencarian dan tombol login */
            font-family: 'Istok Web', sans-serif;
            opacity: 70%;
            border-radius: 20px; /* Menambahkan border radius pada tombol */
            font-size: 20px;
        }

        .search-button:hover,
        .login-button:hover { /* Gabungkan gaya hover tombol pencarian dan tombol login */
            opacity: 90%;
        }

        /* Tambahkan gaya untuk navbar di sisi kanan */
        .navbar-nav {
            margin-left: 750px; /* Posisikan navbar di sisi kanan */
        }
    </style>
</head>

<body>
    <!-- Bagian Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark #E26EE5 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">E-Mading</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Tombol Pencarian dan Login -->
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav"> <!-- Menggunakan order-first untuk meletakkan elemen ke sebelah kiri -->
                    <li class="nav-item order-first">
                        <!-- Formulir pencarian dengan input dan tombol pencarian -->
                        <form class="d-flex" action="" method="GET">
                            <input class="form-control me-2 form-control-me-2" type="search" placeholder="Cari artikel" aria-label="Search" name="q">
                            <button class="btn btn-light search-button" type="submit">Cari</button>
                        </form>
                    </li>
                </ul>
                <!-- Tombol Login -->
                <ul class="navbar-nav ms-auto"> <!-- Menggunakan ms-auto untuk meletakkan elemen ke sebelah kanan -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <button class="btn btn-light login-button">Login</button>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bagian Konten Utama -->
    <div class="container-main">
        <div class="row">
            <div class="col-md-12">
                <!-- Judul Halaman -->
                <h2 class="text-center">Artikel Terkini</h2>
                <div class="row article-list">
                    <?php
                    // Menampilkan daftar artikel berdasarkan hasil query
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-4">
                            <div class="card">
                                <!-- Tautan ke halaman detail artikel dengan parameter ID dan judul -->
                                <a href="detail_artikel.php?id=<?php echo $row['id']; ?>&judul=<?php echo urlencode($row['judul']); ?>">
                                    <!-- Gambar artikel -->
                                    <img src="<?php echo $row['gambar']; ?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <!-- Judul artikel -->
                                        <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                                        <!-- Deskripsi artikel -->
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

    <!-- Sertakan script Popper.js dan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Tutup koneksi database setelah selesai menggunakan
$conn->close();
?>
