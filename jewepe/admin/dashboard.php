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

// Handle logout
if (isset($_POST['logout'])) {
    // Hapus session dan redirect ke halaman login
    session_destroy();
    header("Location: index.php");
    exit;
}

// Query untuk mengambil artikel terbaru
$query = "SELECT * FROM artikel WHERE status = 1 ORDER BY tgl_publish DESC LIMIT 5";
$result = $conn->query($query);

// Query untuk mengambil daftar draft
$queryDraft = "SELECT * FROM artikel WHERE status = 0";
$resultDraft = $conn->query($queryDraft);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Mengimpor file CSS Bootstrap untuk tata letak dan desain -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya-gaya CSS untuk halaman HTML */
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
            color: #fff;
        }

        .nav-link {
            margin-left: 20px;
        }

        .container-main {
            background-color: #F3F8FF;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 0px;
            margin-top: 20px;
        }

        .nav-item {
            margin-right: 20px;
            display: flex;
            align-items: center;
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

        h2 {
            color: #176B87;
        }

        .list-group {
            border-radius: 10px;
        }

        .list-group-item {
            cursor: pointer;
            background-color: #FFF;
            color: #49108B;
            border: 1px solid #F3F8FF;
            padding: 20px;
        }

        .list-group-item.active {
            background-color: #86B6F6;
            border: 1px solid #B4D4FF;
            color: #FFF;
        }

        .list-group-item:hover {
            background-color: #F3F8FF;
            color: #176B87;
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

        .status-label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .status-upload {
            color: #28a745;
        }

        .status-draft {
            color: #BF3131;
        }

        .btn-primary:hover {
            background-color: #F3F8FF;
            color: #7E30E1;
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
                        <a class="nav-link" href="beranda.php">
                            <button type="button" class="btn btn-light login-button">Beranda</button>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="post">
                            <button type="submit" class="btn btn-light login-button" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bagian utama konten halaman -->
    <div class="container-main">
        <div class="row">
            <div class="col-md-3">
                <!-- Daftar menu navigasi (list-group) -->
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        Dashboard
                    </a>
                    <a href="upload.php" class="list-group-item list-group-item-action">Upload</a>
                    <a href="publish.php" class="list-group-item list-group-item-action">Publish</a>
                    <a href="draft.php" class="list-group-item list-group-item-action">Draft</a>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Daftar Artikel Publish -->
                <h2>Daftar Publish</h2>
                <div class="row article-list">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="<?php echo $row['gambar']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                                    <p class="status-label status-upload">Status: Publish</p>
                                    <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Daftar Artikel Draft -->
                <h2>Daftar Draft</h2>
                <div class="row article-list">
                    <?php while ($rowDraft = $resultDraft->fetch_assoc()) { ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="<?php echo $rowDraft['gambar']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $rowDraft['judul']; ?></h5>
                                    <p class="status-label status-draft">Status: Draft</p>
                                    <p class="card-text"><?php echo $rowDraft['deskripsi']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Mengimpor file JavaScript Bootstrap untuk dukungan fungsi interaktif -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
