<?php
require_once __DIR__ . '/db.php';

// Mendapatkan data produk yang akan diedit
$id = $_GET["id"];
$sql = "SELECT * FROM produk WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama = $row["nama"];
    $foto = $row["foto"];
    $size = $row["size"];
    $harga = $row["harga"];
    $link = $row["link"];
    $kategori = $row["kategori"];
} else {
    echo "Data produk tidak ditemukan.";
    exit();
}

// Fungsi untuk memperbarui data produk
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST["nama"];
    $foto = $_POST["foto"];
    $size = $_POST["size"];
    $harga = $_POST["harga"];
    $link = $_POST["link"];
    $kategori = $_POST["kategori"];

    $sql = "UPDATE produk SET nama='$nama', foto='$foto', size='$size', harga='$harga', link='$link', kategori='$kategori' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Data produk berhasil diperbarui.";
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
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Styling CSS */
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Edit Produk</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" enctype="multipart/form-data" class="mt-3">

            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="text" id="foto" name="foto" value="<?php echo $foto; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" id="size" name="size" value="<?php echo $size; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="text" id="harga" name="harga" value="<?php echo $harga; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="link">Link:</label>
                <input type="text" id="link" name="link" value="<?php echo $link; ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <select id="kategori" name="kategori" class="form-control" required>
                    <option value="arabica" <?php if ($kategori == "arabica") echo "selected"; ?>>Arabica</option>
                    <option value="robusta" <?php if ($kategori == "robusta") echo "selected"; ?>>Robusta</option>
                    <option value="milkshake" <?php if ($kategori == "milkshake") echo "selected"; ?>>Milkshake</option>
                    <option value="nonkopi" <?php if ($kategori == "nonkopi") echo "selected"; ?>>Non Kopi</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="admin.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
