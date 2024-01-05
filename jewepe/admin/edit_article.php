<?php
// Include your database connection file or code here
include 'koneksi.php';

session_start();

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for editing article
$notification = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['article_id'])) {
    // Ambil data dari form
    $articleId = $_POST['article_id'];
    $judul = $_POST["judul"];
    $deskripsi = $_POST["deskripsi"];
    $artikel = $_POST["artikel"];
    $tgl_publish = $_POST["tgl_publish"];
    $status = $_POST["status"];

    // Query untuk menyimpan perubahan artikel ke database
    $updateQuery = "UPDATE artikel 
                    SET judul='$judul', deskripsi='$deskripsi', artikel='$artikel', 
                        tgl_publish='$tgl_publish', status=$status 
                    WHERE id=$articleId";

    if ($conn->query($updateQuery) === TRUE) {
        $notification = "Perubahan berhasil disimpan!";
    } else {
        $notification = "Error: " . $updateQuery . "<br>" . $conn->error;
    }
}

// Redirect to the original page (publish.php)
header("Location: publish.php");

$conn->close();
?>
