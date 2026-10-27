<?php
require_once __DIR__ . '/db.php';

// Fungsi untuk menampilkan data produk berdasarkan kategori
function showProductsByCategory($conn, $category) {
    $sql = "SELECT * FROM produk WHERE kategori = '$category'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h3>" . ucfirst($category) . " Products</h3>";
        echo "<table class='table table-striped table-bordered'>";
        echo "<tr><th>ID</th><th>Nama</th><th>Foto</th><th>Size</th><th>Harga</th><th>Link</th><th>Aksi</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["nama"] . "</td>";
            echo "<td><img src='" . $row["foto"] . "' width='100' height='100'></td>";
            echo "<td>" . $row["size"] . "</td>";
            echo "<td>" . number_format($row["harga"], 0, ',', '.') . "</td>"; // Format harga menjadi ribuan
            echo "<td>" . $row["link"] . "</td>";
            echo "<td><a href='edit.php?id=" . $row["id"] . "' class='btn btn-primary'>Edit</a> <a href='delete.php?id=" . $row["id"] . "' class='btn btn-danger'>Delete</a></td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Tidak ada produk dalam kategori " . ucfirst($category) . ".</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Styling CSS */
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Admin Panel Produk</h1>

        <?php
        // Menampilkan produk berdasarkan kategori
        $categories = ['arabica', 'robusta', 'milkshake', 'nonkopi'];
        
        foreach ($categories as $category) {
            showProductsByCategory($conn, $category);
            echo "<hr>";
        }
        ?>

        <a href="create.php" class="btn btn-success mt-3">Tambah Produk</a>

        <?php $conn->close(); ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
