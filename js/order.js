let selectedItem = {};

function openOrderModal(id, product, variant, price) {
  fetch('check_login.php')
    .then(res => res.json())
    .then(data => {

      if (!data.logged_in) {
        showLoginModal();
        return;
      }

      selectedItem = { id, product, variant, price };

      document.getElementById('modalTitle').innerText =
        product + ' - ' + variant;

      document.getElementById('qty').value = 1;
      document.getElementById('days').value = 1;

      document.getElementById('orderModal').style.display = 'flex';
    });
}

function closeModal() {
  document.getElementById('orderModal').style.display = 'none';
}

function addToCart() {
  const qty  = document.getElementById('qty').value;
  const days = document.getElementById('days').value;

  fetch('cart_add.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      ...selectedItem,
      qty,
      days
    })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert('Berhasil ditambahkan ke keranjang');
      closeModal();
      location.reload();
    }
  });
}
