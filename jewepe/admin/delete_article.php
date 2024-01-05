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

// Check if the article ID is provided
if (isset($_POST['id'])) {
    $articleId = $_POST['id'];

    // Perform delete query
    $deleteQuery = "DELETE FROM artikel WHERE id=$articleId";
    
    // Menjalankan query penghapusan dan mengecek keberhasilannya
    if ($conn->query($deleteQuery) === TRUE) {
        echo "Artikel berhasil dihapus";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // Jika ID artikel tidak diberikan
    echo "Article ID not provided";
}

// Menutup koneksi database setelah selesai digunakan
$conn->close();
?>
