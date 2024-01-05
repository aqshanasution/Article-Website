<?php
// Informasi koneksi database
$host = "localhost";
$username = "root";
$password = "";
$database = "jewepe";

// Membuat objek koneksi baru
$koneksi = new mysqli($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil
if ($koneksi->connect_error) {
    // Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan kesalahan
    die("Connection failed: " . $conn->connect_error);
}
?>
