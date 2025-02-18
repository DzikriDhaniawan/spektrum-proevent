// Fungsi untuk membuka modal
function openModal(imageSrc, title, date, description) {
    document.getElementById("modalImage").src = imageSrc;
    document.getElementById("modalTitle").textContent = title;
    document.getElementById("modalMeta").textContent = date;
    document.getElementById("modalDescription").textContent = description;
    document.getElementById("articleModal").style.display = "flex";
}

// Fungsi untuk menutup modal
function closeModal() {
    document.getElementById("articleModal").style.display = "none";
}

document.getElementById("articleModal").addEventListener("click", function (event) {
    if (event.target === this) {
        closeModal();
    }
}); 

function toggleMenu() {
    const navLinks = document.querySelector(".nav-links");
    navLinks.classList.toggle("active");
}

// Filtering Product Logic
const productGrid = document.querySelector('.product-grid');
const pageButtons = document.querySelectorAll('.page-btn');
const filterButtons = document.querySelectorAll('.filter-btn');

function filterProducts(category) {
    const products = document.querySelectorAll(".product-item");

    // Hapus bagian yang menampilkan semua produk
    products.forEach(product => {
        product.classList.remove("show");
        product.style.display = "none"; // Set all products to hidden initially
        if (product.classList.contains(category)) {
            product.classList.add("show");
            product.style.display = "block"; // Show the products of the selected category
        }
    });

    // Update active button
    filterButtons.forEach(btn => btn.classList.remove("active"));
    document.querySelector(`[onclick="filterProducts('${category}')"]`).classList.add("active");

    // Update pagination if present
    if (pageButtons.length > 0) {
        pageButtons[0].click();
    }
}

// Load Display products and set initial pagination
document.addEventListener("DOMContentLoaded", () => {
    filterProducts("display");
    pageButtons[0].click(); // Load halaman pertama
});

// Pagination Logic
pageButtons.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        const allProducts = document.querySelectorAll('.product-item.show');
        const itemsPerPage = 3;
        const start = index * itemsPerPage;
        const end = start + itemsPerPage;

        allProducts.forEach((product, idx) => {
            if (idx >= start && idx < end) {
                product.style.display = "block";
            } else {
                product.style.display = "none";
            }
        });

        // Update active page button
        pageButtons.forEach(button => button.classList.remove('active'));
        btn.classList.add('active');
    });
});
