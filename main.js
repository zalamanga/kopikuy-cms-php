// Fungsi untuk mengurutkan berdasarkan harga
function sortByPrice() {
  var selectedSort = document.getElementById("filter_harga").value;
  var currentUrl = window.location.href.split("?")[0]; // Mengambil URL saat ini tanpa parameter query

  if (selectedSort === "paling_mahal") {
    window.location.href = currentUrl + "?sort=paling_mahal"; // Mengarahkan ke URL dengan parameter sort=paling_mahal
  } else if (selectedSort === "paling_murah") {
    window.location.href = currentUrl + "?sort=paling_murah"; // Mengarahkan ke URL dengan parameter sort=paling_murah
  }
}
function addToCart(item) {
  // Memeriksa apakah localStorage tersedia di browser
  if (typeof Storage !== "undefined") {
    let cart = JSON.parse(localStorage.getItem("cart") || "[]");
    cart.push(item);
    localStorage.setItem("cart", JSON.stringify(cart));
    updateCartCount();
    alert("Item berhasil ditambahkan ke keranjang!");
  } else {
    alert("Browser Anda tidak mendukung localStorage.");
  }
}

function updateCartCount() {
  let cart = JSON.parse(localStorage.getItem("cart") || "[]");
  let cartCount = document.getElementById("cart_icon");
  cartCount.textContent = cart.length;
}

