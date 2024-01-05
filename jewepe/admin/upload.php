<?php
// Mengimpor file koneksi.php
include 'koneksi.php';

// Memulai sesi PHP untuk pengelolaan sesi
session_start();

// Membuat objek koneksi database menggunakan informasi dari koneksi.php
$conn = new mysqli($host, $username, $password, $database);

// Mengecek koneksi database, jika gagal maka program akan berhenti dan menampilkan pesan kesalahan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$notification = ""; // Inisialisasi variabel notifikasi

// Memeriksa apakah formulir telah disubmit (metode POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $judul = $_POST["judul"];
    $deskripsi = $_POST["deskripsi"];
    $artikel = $_POST["artikel"];
    $tgl_publish = $_POST["tgl_publish"];
    $status = $_POST["status"]; // Menambah baris ini untuk mengambil status

    // Mengatur lokasi folder untuk menyimpan gambar
    $uploadFolder = "uploads/";

    // Membuat folder jika belum ada
    if (!file_exists($uploadFolder)) {
        mkdir($uploadFolder, 0777, true);
    }

    // Mengambil nama file dan path
    $gambar = $uploadFolder . basename($_FILES["gambar"]["name"]);
    $gambarTmp = $_FILES["gambar"]["tmp_name"];

    // Memindahkan file gambar ke folder uploads
    if (move_uploaded_file($gambarTmp, $gambar)) {
        // Query untuk menyimpan artikel ke database
        $insertQuery = "INSERT INTO artikel (judul, deskripsi, artikel, gambar, status, tgl_buat, tgl_publish, id_admin) 
                        VALUES ('$judul', '$deskripsi', '$artikel', '$gambar', $status, NOW(), '$tgl_publish', 1)";

        // Menjalankan query dan menampilkan notifikasi yang sesuai
        if ($conn->query($insertQuery) === TRUE) {
            $notification = "Artikel berhasil diupload!";
        } else {
            $notification = "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        $notification = "Error uploading file.";
    }
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
    <!-- Bagian head HTML dengan tag-tag meta dan styles -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Artikel - E-Mading</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Gaya CSS disini */
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

        .nav-link:hover {
            color: #E26EE5;
            background-color: #86B6F6;
            border-radius: 20px;
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
            margin-bottom: 20px;
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
            color: #7E30E1;
        }

        .card-text {
            color: #555;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .btn-primary {
            background: #176B87;
            border: 1px solid #176B87;
        }

        .btn-primary:hover {
            background-color: #EEF5FF;
            color: #176B87;
            border: 1px solid #176B87;
        }

        .upload-form {
            margin-top: 20px;
        }

        .form-control {
            margin-bottom: 15px;
            border-radius: 10px;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            background-color: #F3F8FF;
        }

        .file-input-wrapper:hover {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            background-color: #F3F8FF;
        }

        .file-input-wrapper>input[type="file"] {
            font-size: 100px;
            position: absolute;
            top: 0;
            right: 0;
            opacity: 0;
            background-color: #F3F8FF;
        }

        .file-input-wrapper .btn {
            margin-top: 5px;
            background-color: #49108B; /* Black color for the button */
            color: #F3F8FF; /* White text color for the button */
        }
    </style>
</head>

<body>
    <!-- Bagian body HTML -->
    <nav class="navbar navbar-expand-lg navbar-dark #E26EE5 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">E-Mading</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-main">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="upload.php" class="list-group-item list-group-item-action active">Upload</a>
                    <a href="publish.php" class="list-group-item list-group-item-action">Publish</a>
                    <a href="draft.php" class="list-group-item list-group-item-action">Draft</a>
                </div>
            </div>
            <div class="col-md-9">
                <h2 class="mb-4">Upload Artikel</h2>

                <!-- Form Upload Artikel -->
                <form action="#" method="post" class="upload-form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Artikel</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="artikel" class="form-label">Isi Artikel</label>
                        <textarea class="form-control" id="artikel" name="artikel" rows="6" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Upload Gambar</label>
                        <div class="input-group">
                            <input type="file" id="gambar" name="gambar" accept="image/*" required
                                class="form-control">
                            <label class="input-group-text" for="gambar">
                                <i class="bi bi-upload"></i> <!-- Bootstrap Icons (Bi) upload icon -->
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_publish" class="form-label">Tanggal Publish</label>
                        <input type="date" class="form-control" id="tgl_publish" name="tgl_publish" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Artikel</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="0">Draft</option>
                            <option value="1">Publish</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Upload Artikel</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bagian JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
