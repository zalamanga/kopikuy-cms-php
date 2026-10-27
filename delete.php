<?php
require_once __DIR__ . '/db.php';

// Mendapatkan id produk yang akan dihapus
$id = $_GET["id"];

// Menghapus data produk
$sql = "DELETE FROM produk WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Data produk berhasil dihapus.";
    header("Location: admin.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
