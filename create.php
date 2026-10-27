<?php
require_once __DIR__ . '/db.php';

// Fungsi untuk menambah data produk
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $size = $_POST["size"];
    $harga = $_POST["harga"];
    $link = $_POST["link"];
    $kategori = $_POST["kategori"];

    // Handling file upload
    $foto = $_FILES['foto']['name']; // Nama file yang diunggah
    $foto_tmp = $_FILES['foto']['tmp_name']; // Lokasi file sementara di server

    // Folder tempat menyimpan file foto
    $upload_dir = 'uploads/';

    // Pindahkan file dari lokasi sementara ke folder uploads
    move_uploaded_file($foto_tmp, $upload_dir.$foto);

    // Insert data ke database
    $sql = "INSERT INTO produk (nama, foto, size, harga, link, kategori) VALUES ('$nama', '$foto', '$size', '$harga', '$link', '$kategori')";

    if ($conn->query($sql) === TRUE) {
        echo "Data produk berhasil ditambahkan.";
        header("Location: admin.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Styling CSS */
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Tambah Produk</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required><br>

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" required><br> <!-- Input type file untuk upload foto -->

            <label for="size">Size:</label>
            <input type="text" id="size" name="size" required><br>

            <label for="harga">Harga:</label>
            <input type="text" id="harga" name="harga" required><br>

            <label for="link">Link:</label>
            <input type="text" id="link" name="link" required><br>

            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori">
                <option value="arabica">Arabica</option>
                <option value="robusta">Robusta</option>
                <option value="milkshake">Milkshake</option>
                <option value="nonkopi">Non-Kopi</option>
            </select><br>

            <input type="submit" value="Tambah" class="btn btn-primary mt-3">
            <a href="admin.php" class="btn btn-secondary mt-3">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
