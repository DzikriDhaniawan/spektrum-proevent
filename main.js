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
