<?php
// Menghubungkan ke file koneksi.php
include 'koneksi.php';

// Memulai sesi
session_start();

// Memproses login jika metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Menggunakan prepared statement untuk mencegah SQL injection
    $sql = "SELECT * FROM admin WHERE USERNAME = ? AND PASSWORD = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa hasil query untuk login
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['ID_ADMIN'];
        $_SESSION['username'] = $user['USERNAME'];
        $_SESSION['name'] = $user['NAME'];

        // Regenerasi ID sesi untuk mencegah serangan session fixation
        session_regenerate_id();

        // Mengarahkan pengguna ke dashboard setelah login berhasil
        header("Location: ./dashboard.php");
        exit();
    } else {
        $error = "Username or password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Menyertakan Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Gaya CSS tambahan -->
    <style>
        /* Gaya CSS untuk body */
        body {
            background-color: #f8f9fa;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden; /* Sembunyikan overflow horizontal */
        }

        /* Gaya CSS untuk container */
        .container {
            display: flex;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 100vh; /* Tinggi penuh dari viewport */
            width: 100vw; /* Lebar penuh dari viewport */
            max-width: none; /* Tidak ada lebar maksimum */
        }

        /* Gaya CSS untuk sisi kiri */
        .left-side {
            flex: 1;
            background-color: #176B87;
            background-blend-mode: multiply; /* Sesuaikan mode campuran jika diperlukan */
            display: flex;
            align-items: center;
            justify-content: right; /* Saya asumsikan Anda ingin menggunakan "flex-end" di sini */
            font-family: 'Istok Web', sans-serif;
            text-align: center;
            padding: 20px;
            text-decoration: underline #86B6F6;
            text-underline-offset: 20px;
        }

        /* Gaya CSS untuk elemen H1 di sisi kiri */
        .left-side h1 {
            color: #F3F8FF;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Gaya CSS untuk sisi kanan */
        .right-side {
            flex: 1;
            background-color: #EEF5FF; /* Warna putih */
            padding: 30vh 100px 20px;
        }

        /* Gaya CSS untuk grup formulir */
        .form-group {
            margin-bottom: 20px;
        }

        /* Gaya CSS tambahan untuk tombol */
        .right-side .btn-primary {
            background-color: #176B87; /* Warna hitam untuk tombol */
            color: #EEF5FF; /* Warna teks putih untuk tombol */
            float: right; /* Mengatur tombol ke kanan */
            padding: 10px 30px 10px 30px;
            border-radius: 10px;
            border: 1px solid #176B87;
        }

        /* Gaya CSS untuk elemen H2 di sisi kanan */
        .right-side h2 {
            padding-bottom: 40px;
            font-size: 5vh;
            color: #86B6F6;
        }

        /* Gaya CSS untuk elemen formulir kontrol */
        .right-side .form-control {
            border-radius: 10px;
            padding: 20px;
            padding-left: 40px;
        }

        /* Gaya CSS untuk placeholder */
        .form-control::placeholder {
            color: #6c757d; /* Warna teks placeholder */
            font-style: none;
        }
    </style>
</head>
<body>
    <!-- Container untuk tata letak login -->
    <div class="container">
        <!-- Sisi kiri dengan judul E-MADING -->
        <div class="left-side">
            <h1 class="display-4">E-MADING</h1>
        </div>

        <!-- Sisi kanan dengan formulir login -->
        <div class="right-side">
            <!-- Judul Formulir -->
            <h2 class="mb-4">Login Here</h2>

            <!-- Menampilkan pesan kesalahan jika ada -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <!-- Formulir login -->
            <form method="post" action="./login.php">
                <!-- Grup Formulir untuk Input Username -->
                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                </div>

                <!-- Grup Formulir untuk Input Password -->
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>

                <!-- Tombol untuk Mengirimkan Formulir -->
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <!-- Menyertakan Bootstrap JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
