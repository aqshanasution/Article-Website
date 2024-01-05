<?php
// Sertakan file koneksi.php yang berisi informasi koneksi database
include 'koneksi.php';

// Mulai sesi untuk pengelolaan variabel sesi
session_start();

// Membuat objek koneksi database menggunakan informasi dari file koneksi.php
$conn = new mysqli($host, $username, $password, $database);

// Ambil id artikel dari parameter URL
$id_artikel = $_GET['id'];

// Query untuk mendapatkan detail artikel berdasarkan id
$query_detail = "SELECT * FROM artikel WHERE id = $id_artikel";
$result_detail = $conn->query($query_detail);

// Query untuk mendapatkan artikel terkait
$query_terkait = "SELECT * FROM artikel WHERE id != $id_artikel AND status = 1 ORDER BY tgl_publish DESC LIMIT 3";
$result_terkait = $conn->query($query_terkait);

// Query untuk mendapatkan detail artikel beserta informasi admin yang menulis artikel
$query_detail = "SELECT a.*, u.name_admin FROM artikel a
                 INNER JOIN users u ON a.admin_id = u.id
                 WHERE a.id = $id_artikel";

// Periksa apakah terdapat hasil dari query detail artikel
if ($result_detail->num_rows > 0) {
    // Ambil data detail artikel
    $row_detail = $result_detail->fetch_assoc();
    ?>
    <!-- Mulai dokumen HTML -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Informasi dasar HTML -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Judul halaman berdasarkan judul artikel -->
        <title><?php echo $row_detail['judul']; ?></title>
        <!-- Sertakan Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Gaya tampilan halaman web menggunakan CSS internal -->
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

            h1 {
                color: #176B87;
            }

            h5 {
                margin-bottom: 20px;
                background-color: #f2f2f2; /* Warna abu yang diinginkan */
                padding: 10px; /* Sesuaikan dengan padding yang diinginkan */
                border-radius: 5px; /* Untuk memberikan sudut yang melengkung */
            }

            img {
                max-width: 100%;
                height: auto;
                display: block;
                margin: 0 auto 20px; /* Tengah dan memberikan margin di bawah gambar */
                border-radius: 10px;
            }

            p {
                color: #555;
                line-height: 1.6;
                text-align: justify; /* Rata kiri dan kanan */
            }

            .sidebar {
                background-color: #F3F8FF;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                padding: 20px;
                border-radius: 10px;
                margin-top: 20px;
            }

            .sidebar h3 {
                color: #176B87;
                margin-bottom: 20px;
            }

            .sidebar .card {
                background-color: #FFF;
                color: #000;
                border-radius: 10px;
                margin-bottom: 20px;
            }

            .sidebar .card img {
                max-height: 120px;
                object-fit: cover;
                border: 2px #49108B;
                border-radius: 10px;
                padding: 0 10px 0 10px;
            }

            .login-button { /* Gabungkan gaya tombol pencarian dan tombol login */
                font-family: 'Istok Web', sans-serif;
                opacity: 70%;
                border-radius: 20px; /* Menambahkan border radius pada tombol */
                font-size: 20px;
                margin-right: 20px;
            }

            .login-button:hover { /* Gabungkan gaya hover tombol pencarian dan tombol login */
                opacity: 90%;
            }

        </style>
    </head>

    <body>
        <!-- Navbar untuk navigasi halaman -->
        <nav class="navbar navbar-expand-lg navbar-dark #E26EE5 fixed-top">
            <div class="container">
                <a class="navbar-brand" href="index.php">E-Mading</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav ms-auto">
                    <!-- Menggunakan ms-auto untuk meletakkan elemen ke sebelah kanan -->
                    <li class="nav-item">
                        <!-- Tombol login dengan tautan ke halaman login -->
                        <a class="nav-link" href="login.php">
                            <button class="btn btn-light login-button">Login</button>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Bagian utama konten halaman -->
        <div class="container-main">
            <div class="row">
                <!-- Konten utama dengan detail artikel -->
                <div class="col-md-8">
                    <!-- Menampilkan judul artikel -->
                    <h1><?php echo $row_detail['judul']; ?></h1>
                    <!-- Menampilkan tanggal publish artikel -->
                    <p>Published at: <?php echo $row_detail['tgl_publish']; ?></p>
                    <!-- Menampilkan gambar artikel -->
                    <img src="<?php echo $row_detail['gambar']; ?>" alt="Gambar Artikel">
                    <br>
                    <!-- Menampilkan deskripsi artikel -->
                    <h5><?php echo $row_detail['deskripsi']; ?></h5>
                    <!-- Menampilkan isi artikel -->
                    <p><?php echo $row_detail['artikel']; ?></p>
                </div>
                <!-- Sidebar dengan artikel terkait -->
                <div class="col-md-4">
                    <div class="sidebar">
                        <!-- Judul sidebar -->
                        <h3>Artikel Terkait</h3>
                        <?php
                        // Loop untuk menampilkan artikel terkait
                        while ($row_terkait = $result_terkait->fetch_assoc()) {
                            ?>
                            <!-- Kartu artikel terkait dengan tautan ke detail artikel -->
                            <div class="card">
                                <a href="detail_artikel.php?id=<?php echo $row_terkait['id']; ?>">
                                    <br>
                                    <!-- Menampilkan gambar artikel terkait -->
                                    <img src="<?php echo $row_terkait['gambar']; ?>" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <!-- Menampilkan judul artikel terkait -->
                                        <h5 class="card-title"><?php echo $row_terkait['judul']; ?></h5>
                                    </div>
                                </a>
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
} else {
    // Jika artikel tidak ditemukan, tampilkan pesan
    echo "Artikel tidak ditemukan.";
}
?>
