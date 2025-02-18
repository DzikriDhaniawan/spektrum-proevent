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

const productGrid = document.querySelector('.product-grid');
const pageButtons = document.querySelectorAll('.page-btn');

pageButtons.forEach((btn, index) => {
    btn.addEventListener('click', () => {
        productGrid.style.transform = `translateX(-${index * 100}%)`;
        
        pageButtons.forEach(button => button.classList.remove('active'));
        btn.classList.add('active');
    });
});
