<?php
// Menghubungkan ke file koneksi.php
include 'koneksi.php';

// Memulai sesi
session_start();

// Membuat objek koneksi database
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi database
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengatur kondisi status berdasarkan parameter GET
if (isset($_GET['status']) && ($_GET['status'] == 'draft')) {
    $statusCondition = " AND status = 0";
} else {
    $statusCondition = " AND status = 1";
}

// Membuat query untuk mengambil artikel yang telah dipublish atau draft
$publishQuery = "SELECT * FROM artikel WHERE 1" . $statusCondition;
$publishResult = $conn->query($publishQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Script JavaScript untuk meng-handle penghapusan artikel -->
    <script>
        function deleteArticle(articleId) {
            // Konfirmasi penghapusan
            var confirmation = confirm("Apakah Anda yakin ingin menghapus artikel ini?");
            if (confirmation) {
                // Membuat objek XMLHttpRequest
                var xhr = new XMLHttpRequest();

                // Konfigurasi request AJAX
                xhr.open("POST", "delete_article.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                // Menangani respon dari server
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Menampilkan notifikasi atau melakukan tindakan setelah penghapusan berhasil
                        alert("Artikel berhasil dihapus");
                        // Me-refresh halaman atau melakukan operasi lain sesuai kebutuhan
                        location.reload();
                    }
                };

                // Mengirim data ke server
                xhr.send("id=" + articleId);
            }
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publish Articles</title>
    <!-- Menghubungkan dengan stylesheet Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Gaya kustom untuk halaman -->
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

        .status-publish {
            color: #28a745; 
        }

        .btn-primary {
            background-color: #176B87;
            color: #EEF5FF;
            border: 1px solid #176B87;
        }

        .btn-primary:hover {
            background-color: #EEF5FF;
            color: #176B87;
            border: 1px solid #176B87;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark #E26EE5 fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">E-Mading</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Konten utama -->
    <div class="container-main">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                    <a href="upload.php" class="list-group-item list-group-item-action">Upload</a>
                    <a href="publish.php?status=publish" class="list-group-item list-group-item-action <?php echo (!isset($_GET['status']) || $_GET['status'] == 'publish') ? 'active' : ''; ?>">Publish</a>
                    <a href="draft.php" class="list-group-item list-group-item-action" id="draft-link">Draft</a>
                </div>
            </div>
            <!-- Konten utama -->
            <div class="col-md-9">
                <h2>Daftar <?php echo (isset($_GET['status']) && $_GET['status'] == 'draft') ? 'Draft' : 'Publish'; ?></h2>
                <div class="row article-list">
                    <?php
                    while ($row = $publishResult->fetch_assoc()) {
                        ?>
                        <div class="col-md-4">
                            <div class="card">
                                <img src="<?php echo $row['gambar']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                                    <p class="status-label <?php echo (isset($_GET['status']) && $_GET['status'] == 'draft') ? 'status-draft' : 'status-publish'; ?>">Status: <?php echo (isset($_GET['status']) && $_GET['status'] == 'draft') ? 'Draft' : 'Publish'; ?></p>
                                    <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                                    <!-- Tombol untuk mengedit dan menghapus artikel -->
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteArticle(<?php echo $row['id']; ?>)">Hapus</button>
                                </div>
                                <!-- Modal untuk formulir edit artikel -->
                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Edit Artikel</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Formulir Edit Artikel -->
                                                <form action="edit_article.php" method="post" class="upload-form" enctype="multipart/form-data">
                                                    <!-- Input hidden untuk menyimpan ID artikel -->
                                                    <input type="hidden" name="article_id" value="<?php echo $row['id']; ?>">

                                                    <div class="mb-3">
                                                        <label for="judul" class="form-label">Judul Artikel</label>
                                                        <input type="text" class="form-control" id="judul" name="judul" value="<?php echo $row['judul']; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo $row['deskripsi']; ?></textarea>
                                                    </div>

                                                    <!-- Formulir lainnya sesuai kebutuhan -->

                                                    <div class="mb-3">
                                                        <label for="artikel" class="form-label">Isi Artikel</label>
                                                        <textarea class="form-control" id="artikel" name="artikel" rows="6" required><?php echo $row['artikel']; ?></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="tgl_publish" class="form-label">Tanggal Publish</label>
                                                        <input type="date" class="form-control" id="tgl_publish" name="tgl_publish" value="<?php echo $row['tgl_publish']; ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="status" class="form-label">Status Artikel</label>
                                                        <select class="form-select" id="status" name="status" required>
                                                            <option value="0" <?php echo ($row['status'] == 0) ? 'selected' : ''; ?>>Draft</option>
                                                            <option value="1" <?php echo ($row['status'] == 1) ? 'selected' : ''; ?>>Publish</option>
                                                        </select>
                                                    </div>

                                                    <!-- Tombol untuk menyimpan perubahan -->
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Menghubungkan dengan script JavaScript dan Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>
