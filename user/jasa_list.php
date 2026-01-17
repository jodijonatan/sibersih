<?php
$requireAdmin = false;
$pageTitle = "Jelajahi Layanan Terbaik Kami";
include "../includes/config.php";
include "../includes/header.php";

// Tentukan warna utama (sesuai tema cleaning)
$primaryColor = "#3498db"; // Biru Kebersihan
$successColor = "#2ecc71"; // Hijau Kesuksesan

// Catatan: Logika PHP untuk pencarian dihilangkan di sini karena digantikan oleh AJAX.
?>

<style>
  /* ... (Bagian Styling CSS Anda tetap di sini) ... */

  body {
    font-family: 'Poppins', sans-serif;
  }

  .jasa-card {
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    border-radius: 15px;
    overflow: hidden;
    border: none;
    background-color: #ffffff;
  }

  .jasa-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
  }

  .jasa-card .card-img-top {
    height: 250px;
    object-fit: cover;
    border-bottom: 5px solid <?= $primaryColor ?>;
  }

  .jasa-card .card-body {
    padding: 25px;
    display: flex;
    flex-direction: column;
  }

  .jasa-card .card-title {
    font-weight: 700;
    font-size: 1.5rem;
    color: #2c3e50;
    margin-bottom: 10px;
  }

  .jasa-card .card-text {
    font-size: 0.9rem;
    color: #7f8c8d;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 15px;
  }

  .price-tag {
    font-size: 1.8rem;
    font-weight: 800;
    color: <?= $successColor ?>;
    margin-top: auto;
    margin-bottom: 15px;
    border-top: 1px solid #eee;
    padding-top: 10px;
  }

  .btn-order {
    background-color: <?= $successColor ?>;
    border-color: <?= $successColor ?>;
    font-weight: 600;
    transition: background-color 0.3s;
  }

  .btn-order:hover {
    background-color: #27ae60;
    border-color: #27ae60;
  }
</style>

<div class="py-4">
  <div class="row mb-5 align-items-center">
    <div class="col-md-8">
      <h1 class="fw-bolder text-dark mb-1"><i class="fas fa-search me-2 text-primary"></i> Temukan Layanan Terbaik</h1>
      <p class="lead text-muted">Pilih jasa kebersihan yang paling sesuai dengan kebutuhan rumah atau kantor Anda.</p>
    </div>
    <div class="col-md-4">
      <div class="input-group shadow-sm">
        <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Cari jasa spesifik..." aria-label="Cari Jasa">
        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </div>

  <div class="row g-5" id="jasaResults">
  </div>

</div>

<?php
// Tutup layout dari header.php
?>
</div>
</main>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Ambil elemen input dan wadah hasil
  const searchInput = document.getElementById('searchInput');
  const jasaResults = document.getElementById('jasaResults');
  let typingTimer; // Timer untuk menunda pengiriman request
  const doneTypingInterval = 300; // Jeda 300ms setelah mengetik

  /**
   * Fungsi untuk membuat template card jasa
   * @param {Object} jasa - Objek data jasa dari server (JSON)
   */
  function createJasaCard(jasa) {
    const primaryColor = "<?= $primaryColor ?>";
    const successColor = "<?= $successColor ?>";

    // Format harga ke Rupiah
    const formattedHarga = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0
    }).format(jasa.harga).replace('IDR', 'Rp');

    // URL gambar default jika gambar tidak ada
    const imageHtml = jasa.gambar ?
      `<img src="../uploads/${jasa.gambar}" class="card-img-top" alt="${jasa.nama_jasa}">` :
      `<div class="bg-light d-flex justify-content-center align-items-center" style="height:250px;">
                <i class="fas fa-broom fa-5x text-muted opacity-25"></i>
               </div>`;

    return `
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 jasa-card shadow">
                    ${imageHtml}
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${jasa.nama_jasa}</h5>
                        <p class="card-text">${jasa.deskripsi}</p>
                        <div class="price-tag">
                            ${formattedHarga}
                        </div>
                        <a href="jasa_order.php?id=${jasa.id}" class="btn btn-order btn-lg mt-2 shadow-sm">
                            <i class="fas fa-cart-plus me-2"></i> Pesan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        `;
  }

  /**
   * Fungsi utama yang mengirim request AJAX
   */
  function performSearch() {
    const query = searchInput.value;

    // Buat objek FormData
    const formData = new FormData();
    formData.append('search', query);

    // Kirim permintaan AJAX ke fetch_jasa.php
    fetch('fetch_jasa.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Bersihkan hasil lama
        jasaResults.innerHTML = '';

        if (data.length > 0) {
          // Tampilkan hasil baru
          data.forEach(jasa => {
            jasaResults.innerHTML += createJasaCard(jasa);
          });
        } else {
          // Tampilkan pesan "Tidak Ditemukan"
          jasaResults.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-info text-center py-5">
                            <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Mohon Maaf!</h4>
                            <p class="mb-0">Tidak ditemukan layanan yang cocok dengan kata kunci <strong>"${query}"</strong>.</p>
                        </div>
                    </div>
                `;
        }
      })
      .catch(error => {
        console.error('Error fetching data:', error);
        jasaResults.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-danger text-center py-5">
                        <p class="mb-0">Terjadi kesalahan saat mengambil data.</p>
                    </div>
                </div>`;
      });
  }

  // Event Listener untuk Real-Time Search
  searchInput.addEventListener('keyup', () => {
    clearTimeout(typingTimer);
    // Set timer baru. Setelah user berhenti mengetik selama 300ms, panggil performSearch
    typingTimer = setTimeout(performSearch, doneTypingInterval);
  });

  // Panggil sekali saat halaman pertama kali dimuat untuk menampilkan semua jasa
  performSearch();
</script>