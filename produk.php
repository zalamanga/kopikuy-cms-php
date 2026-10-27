<?php
require_once __DIR__ . '/db.php';

// Fungsi untuk menambahkan item ke keranjang
function addToCart($item) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    array_push($_SESSION['cart'], $item);
}

// Query untuk mengambil data produk dari database berdasarkan kategori dipilih
function fetchProductsByCategory($category) {
    global $conn;
    $sql = "SELECT * FROM produk WHERE kategori = '$category'";
    $result = $conn->query($sql);
    $products = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

// Query untuk mengambil data produk dari database terurut berdasarkan harga (paling murah atau paling mahal)
function fetchProductsByPrice($sort) {
    global $conn;
    $sql = "SELECT * FROM produk";

    if ($sort === 'paling_murah') {
        $sql .= " ORDER BY harga ASC";
    } elseif ($sort === 'paling_mahal') {
        $sql .= " ORDER BY harga DESC";
    }

    $result = $conn->query($sql);
    $products = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

// Menampilkan data produk sesuai dengan data yang diberikan
function displayData($data_kopi) {
    if (empty($data_kopi)) {
        echo "<p class='text-center'>Produk tidak ditemukan.</p>";
    } else {
        foreach ($data_kopi as $item) {
            ?>
            <div class="col mb-4">
                <div class="card">
                    <img src="<?php echo $item['foto']; ?>" class="card-img-top" alt="<?php echo $item['nama']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['nama']; ?></h5>
                        <div class="row hargasize my-4">
                            <div class="col">
                                <?php echo $item['size']; ?>
                            </div>
                            <div class="col fw-bold text-primary">
                                Rp. <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                            </div>
                        </div>
                        <button onclick='addToCart(<?php echo json_encode([
                            'nama' => $item['nama'],
                            'harga' => $item['harga'],
                            'foto' => $item['foto'],
                            'hargaint' => (int) str_replace('.', '', $item['harga']), // Convert harga to integer without dots
                            'qty' => 1
                        ]); ?>)' href="#" class="addToCart btn btn-success w-100">
                            <i class="bi bi-cart4"></i> Add To Cart
                        </button>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

// Handling request untuk menampilkan produk berdasarkan kategori atau harga
if (isset($_GET['action']) && $_GET['action'] == 'fetchByCategory' && isset($_GET['category'])) {
    $category = $_GET['category'];
    $data_kopi = fetchProductsByCategory($category);
} elseif (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
    $data_kopi = fetchProductsByPrice($sort);
} else {
    // Default query untuk menampilkan semua produk jika tidak ada parameter kategori atau sort
    $sql = "SELECT * FROM produk";
    $result = $conn->query($sql);
    $data_kopi = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data_kopi[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <link rel="shortcut icon" href="images/favicon/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap-icons.css" />
    <style>
      /* Tulis kode CSS internal di bawah sini */
      * {
        scroll-behavior: smooth;
      }
      #produk_not_found {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        height: 330px;
        border: 1px solid #d1d1d1;
        border-radius: 10px;
        margin: 10px 0;
        padding: 30px;
        font-size: 1.2rem;
        font-weight: 400;
      }
      #back-top {
        top: -30px;
        right: 40px;
      }
      @media (max-width: 600px) {
        #back-top {
          width: fit-content;
          top: -50px;
          left: 50%;
          transform: translate(-50%, 50%);
        }
      }
      .bg-nav {
        background-color: #73483f;
      }
      .bg-cok {
        background-color: #f4ede5;
      }

      /* Batas Akhir penulisan kode CSS internal */
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar sticky-top navbar-dark bg-nav navbar-expand-lg bisadicopy">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="images/logo/logo_kuy.png" height="40" alt="image" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav11"
                aria-controls="navbarNav11" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav11">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#best-seller">Best Seller</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#our-team">Our Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#review">Review</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#contact-us">Contact Us</a>
                    </li>
                </ul>
                <a href="cart.html" class="btn btn-outline-light position-relative">
                    <i class="bi bi-cart4"></i>
                    <span id="cart_icon" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
                    </span>
                </a>
                <a target="_blank" class="btn btn-outline-light ms-md-3"
                    href="https://wa.me/62895331996086?text=halo kopi kuy saya mau pesan"><i
                        class="bi bi-whatsapp"></i> Chat</a>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <section class="riki-block produk text-center my-5 py-5">
        <div class="container">
            <h1>Pilih Produk Anda</h1>
            <p class="fs-4">Kualitas biji kopi terbaik, fresh diambil langsung dari petani</p>
            <hr class="border border-danger border-2 opacity-50" />

            <!-- Filters and search inputs -->
            <div class="row gap-2 gap-md-0">
                <div class="col-md-4">
                    <div class="input-group input-group-lg h-100">
                        <button class="btn btn-danger" type="button" id="btn-cari-produk">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <input id="cari-produk" type="search" class="form-control" placeholder="Cari Produk ..."
                            aria-label="Cari produk search">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="select_kopi" onchange="filterByCategory()">
                            <option value="">Pilih Kategori</option>
                            <option value="arabika">Arabika</option>
                            <option value="robusta">Robusta</option>
                            <option value="luwak">Luwak</option>
                            <option value="toraja">Toraja</option>
                            <option value="sidikalang">Sidikalang</option>
                            <option value="sunda">Sunda</option>
                        </select>
                        <label for="select_kopi">Filter Berdasarkan Kategori</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-select" id="filter_harga" onchange="sortByPrice()">
                            <option value="">Urutkan Harga</option>
                            <option value="paling_murah">Harga Termurah</option>
                            <option value="paling_mahal">Harga Termahal</option>
                        </select>
                        <label for="filter_harga">Urutkan Berdasarkan Harga</label>
                    </div>
                </div>
            </div>
            <hr class="border border-danger border-2 opacity-50" />

            <!-- Display products -->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php displayData($data_kopi); ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-lg-start bg-cok text-muted">
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <div class="row mt-3">
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>Kopi Kuy
                        </h6>
                        <p>
                            Kualitas biji kopi terbaik, fresh diambil langsung dari petani
                        </p>
                    </div>
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Produk
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Arabika</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Robusta</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Luwak</a>
                        </p>
                    </div>
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Link
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Beranda</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Kategori</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Keranjang</a>
                        </p>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <h6 class="text-uppercase fw-bold mb-4">
                            Kontak
                        </h6>
                        <p><i class="fas fa-home me-3"></i> Jember, Jawa Timur, Indonesia</p>
                        <p><i class="fas fa-envelope me-3"></i> kopikuy@gmail.com</p>
                        <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                        <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            © 2023 Kopi Kuy:
            <a class="text-reset fw-bold" href="https://mdbootstrap.com/">MDBootstrap.com</a>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="main.js"></script>
    <script>
        // JavaScript untuk menangani perubahan filter kategori
        function filterByCategory() {
            var selectBox = document.getElementById("select_kopi");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;

            if (selectedValue) {
                window.location.href = "produk.php?action=fetchByCategory&category=" + selectedValue;
            } else {
                window.location.href = "produk.php";
            }
        }

        // JavaScript untuk menangani perubahan filter harga
        function sortByPrice() {
            var selectBox = document.getElementById("filter_harga");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;

            if (selectedValue) {
                window.location.href = "produk.php?sort=" + selectedValue;
            } else {
                window.location.href = "produk.php";
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
