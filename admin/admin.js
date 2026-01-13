function saveProduct(id) {
  const fields = document.querySelectorAll(
    `.editable[data-id='${id}']`
  );

  let data = { id };

  fields.forEach(field => {
    data[field.dataset.field] = field.innerText;
  });

  fetch('update_product.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  })
  .then(res => res.text())
  .then(res => {
    alert('Produk berhasil diupdate');
  });
}

function openImageModal(id) {
  document.getElementById('modalProductId').value = id;
  document.getElementById('imageModal').style.display = 'flex';
}

function closeImageModal() {
  document.getElementById('imageModal').style.display = 'none';
}
