<?php
// Pastikan sesi dimulai untuk penanganan autentikasi
session_start();
// Cek jika pengguna sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sibersih - Jasa Cleaning Services Profesional | Rumah, Kantor & Apartemen</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome untuk Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- Google Font: Inter (Modern & Clean) -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* Mengatur font global */
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8fafc;
    }

    /* Warna Kustom Berdasarkan Tema Bersih */
    .color-primary {
      background-color: #0F766E;
    }

    .text-primary {
      color: #0F766E;
    }

    .border-primary {
      border-color: #0F766E;
    }

    .color-secondary {
      background-color: #34D399;
    }

    .text-secondary {
      color: #34D399;
    }

    .btn-cta {
      @apply px-8 py-3 text-lg font-bold rounded-xl transition duration-300 transform hover:scale-[1.02] shadow-xl;
    }

    /* Styling tambahan untuk Hero Section */
    .hero-bg {
      background-image: url('assets/hero-bg.jpg');
      background-size: cover;
      background-position: center;
      /* Lapisan gelap untuk kontras teks */
      background-blend-mode: multiply;
      background-color: rgba(15, 118, 110, 0.8);
      /* Dark teal overlay */
    }
  </style>
</head>

<body>

  <!-- NAV BAR (Fixed & Responsive) -->
  <nav class="sticky top-0 z-50 bg-white shadow-md">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <a class="flex items-center text-2xl font-extrabold text-primary" href="#">
          <i class="fas fa-soap mr-2 text-secondary"></i> Sibersih
        </a>

        <!-- Nav Links (Desktop) -->
        <div class="hidden md:flex space-x-6 items-center">
          <a href="#services" class="text-gray-600 hover:text-primary font-medium">Layanan</a>
          <a href="#why-us" class="text-gray-600 hover:text-primary font-medium">Keunggulan</a>
          <a href="#testimonials" class="text-gray-600 hover:text-primary font-medium">Testimoni</a>

          <a href="login.php" class="text-primary hover:text-white hover:color-primary border border-primary px-4 py-2 rounded-lg font-semibold transition duration-300">
            <i class="fas fa-sign-in-alt mr-1"></i> Login
          </a>
          <a href="register.php" class="bg-primary text-white color-primary px-4 py-2 rounded-lg font-semibold hover:bg-opacity-90 transition duration-300 shadow-md">
            <i class="fas fa-clipboard-list mr-1"></i> Pesan Sekarang
          </a>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-gray-600 hover:text-primary focus:outline-none">
            <i class="fas fa-bars text-xl"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="hidden md:hidden">
      <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-gray-100">
        <a href="#services" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Layanan</a>
        <a href="#why-us" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Keunggulan</a>
        <a href="#testimonials" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-gray-50">Testimoni</a>
        <a href="login.php" class="block w-full text-center mt-2 px-3 py-2 rounded-md text-base font-medium text-primary bg-primary bg-opacity-10 hover:bg-opacity-20">Login</a>
        <a href="register.php" class="block w-full text-center mt-2 px-3 py-2 rounded-md text-base font-medium text-white color-primary">Pesan Sekarang</a>
      </div>
    </div>
  </nav>

  <!-- 1. HERO SECTION -->
  <section class="hero-bg flex items-center min-h-[90vh] text-white py-20">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-5xl md:text-6xl font-extrabold mb-4 animate-fadeInDown">
        Bersih Maksimal, Hidup Optimal.
      </h1>
      <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto opacity-90 animate-fadeInUp delay-300">
        Layanan **Cleaning Services Profesional** untuk Rumah, Apartemen, dan Kantor Anda.
        Dipesan cepat, dibersihkan tuntas.
      </p>
      <div class="space-x-4 flex justify-center animate-fadeInUp delay-600">
        <a href="register.php" class="btn-cta bg-secondary text-gray-800 hover:bg-emerald-300">
          <i class="fas fa-calendar-alt mr-2"></i> Jadwalkan Pembersihan
        </a>
        <a href="#services" class="btn-cta bg-white text-primary border-2 border-primary hover:bg-gray-100">
          <i class="fas fa-info-circle mr-2"></i> Lihat Layanan Kami
        </a>
      </div>
    </div>
  </section>

  <!-- 2. SERVICES SECTION -->
  <section id="services" class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl md:text-5xl font-extrabold text-center mb-4 text-gray-800">
        Pilihan Layanan Sibersih
      </h2>
      <p class="text-xl text-center text-gray-500 mb-12 max-w-2xl mx-auto">
        Kami menyediakan berbagai paket kebersihan yang dapat disesuaikan dengan kebutuhan spesifik Anda.
      </p>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Layanan 1: General Cleaning -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-500 border-t-4 border-primary">
          <div class="text-5xl text-primary mb-4">
            <i class="fas fa-home"></i>
          </div>
          <h3 class="text-2xl font-bold mb-3 text-gray-800">Pembersihan Rumah Harian</h3>
          <p class="text-gray-600 mb-4">
            Membersihkan area umum, kamar tidur, kamar mandi, dan dapur. Ideal untuk pemeliharaan rutin.
          </p>
          <ul class="text-sm text-gray-700 space-y-2">
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Sapu & Pel lantai</li>
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Membersihkan debu permukaan</li>
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Pembuangan sampah</li>
          </ul>
          <a href="register.php" class="mt-5 inline-block text-primary font-semibold hover:underline">
            Pesan Mulai dari Rp50k <i class="fas fa-arrow-right ml-1 text-sm"></i>
          </a>
        </div>

        <!-- Layanan 2: Deep Cleaning -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-500 border-t-4 border-secondary">
          <div class="text-5xl text-secondary mb-4">
            <i class="fas fa-bath"></i>
          </div>
          <h3 class="text-2xl font-bold mb-3 text-gray-800">Deep Cleaning (Menyeluruh)</h3>
          <p class="text-gray-600 mb-4">
            Pembersihan intensif, termasuk area tersembunyi, noda membandel, dan sanitasi. Sempurna untuk pindahan.
          </p>
          <ul class="text-sm text-gray-700 space-y-2">
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Pembersihan Keramik & Nat</li>
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Pembersihan Kaca Jendela</li>
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Pembersihan Lemari bagian dalam</li>
          </ul>
          <a href="register.php" class="mt-5 inline-block text-secondary font-semibold hover:underline">
            Pesan Mulai dari Rp150k <i class="fas fa-arrow-right ml-1 text-sm"></i>
          </a>
        </div>

        <!-- Layanan 3: Office Cleaning -->
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-500 border-t-4 border-gray-400">
          <div class="text-5xl text-gray-600 mb-4">
            <i class="fas fa-building"></i>
          </div>
          <h3 class="text-2xl font-bold mb-3 text-gray-800">Pembersihan Kantor & Komersial</h3>
          <p class="text-gray-600 mb-4">
            Layanan yang disesuaikan untuk menjaga kebersihan dan sanitasi ruang kerja Anda.
          </p>
          <ul class="text-sm text-gray-700 space-y-2">
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Pembersihan Meja & Peralatan</li>
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Sanitasi Area Pantry</li>
            <li><i class="fas fa-check-circle text-secondary mr-2"></i> Jadwal fleksibel</li>
          </ul>
          <a href="register.php" class="mt-5 inline-block text-gray-600 font-semibold hover:underline">
            Pesan Untuk Penawaran <i class="fas fa-arrow-right ml-1 text-sm"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. WHY CHOOSE US / KEUNGGULAN SECTION -->
  <section id="why-us" class="py-16 md:py-24 color-primary text-white">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl md:text-5xl font-extrabold text-center mb-4">
        Mengapa Sibersih adalah Pilihan Terbaik?
      </h2>
      <p class="text-xl text-center opacity-80 mb-12 max-w-3xl mx-auto">
        Komitmen kami terhadap kebersihan yang tulus, keamanan yang terjamin, dan kemudahan pemesanan.
      </p>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
        <!-- Keunggulan 1 -->
        <div class="p-6 rounded-xl bg-white bg-opacity-10 hover:bg-opacity-20 transition duration-300 shadow-lg">
          <i class="fas fa-award text-4xl mb-4 text-secondary"></i>
          <h4 class="text-xl font-bold mb-2">Tenaga Kerja Terseleksi</h4>
          <p class="text-sm opacity-90">
            Setiap *cleaner* telah melewati pelatihan intensif dan *background check* ketat.
          </p>
        </div>

        <!-- Keunggulan 2 -->
        <div class="p-6 rounded-xl bg-white bg-opacity-10 hover:bg-opacity-20 transition duration-300 shadow-lg">
          <i class="fas fa-flask text-4xl mb-4 text-secondary"></i>
          <h4 class="text-xl font-bold mb-2">Perlengkapan Higienis</h4>
          <p class="text-sm opacity-90">
            Kami hanya menggunakan cairan pembersih ramah lingkungan dan alat sanitasi berstandar tinggi.
          </p>
        </div>

        <!-- Keunggulan 3 -->
        <div class="p-6 rounded-xl bg-white bg-opacity-10 hover:bg-opacity-20 transition duration-300 shadow-lg">
          <i class="fas fa-clock text-4xl mb-4 text-secondary"></i>
          <h4 class="text-xl font-bold mb-2">Jadwal Fleksibel</h4>
          <p class="text-sm opacity-90">
            Pesan layanan untuk hari ini, besok, atau atur jadwal rutin mingguan/bulanan.
          </p>
        </div>

        <!-- Keunggulan 4 -->
        <div class="p-6 rounded-xl bg-white bg-opacity-10 hover:bg-opacity-20 transition duration-300 shadow-lg">
          <i class="fas fa-shield-alt text-4xl mb-4 text-secondary"></i>
          <h4 class="text-xl font-bold mb-2">Garansi Kepuasan</h4>
          <p class="text-sm opacity-90">
            Jika hasil kurang memuaskan, kami siap kembali dan memperbaikinya, gratis! (S&K berlaku).
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. CALL TO ACTION & STATS (Penyekat) -->
  <section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
      <h3 class="text-3xl font-bold text-gray-700 mb-8">
        Sudah lebih dari <span class="text-primary">15,000</span> area yang kami bersihkan.
      </h3>
      <a href="register.php" class="btn-cta bg-primary text-white hover:bg-opacity-90">
        <i class="fas fa-bolt mr-2"></i> Mulai Pesan Sekarang!
      </a>
    </div>
  </section>


  <!-- 5. TESTIMONIALS SECTION -->
  <section id="testimonials" class="py-16 md:py-24 bg-white">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl md:text-5xl font-extrabold text-center mb-4 text-gray-800">
        Apa Kata Pelanggan Kami?
      </h2>
      <p class="text-xl text-center text-gray-500 mb-12 max-w-2xl mx-auto">
        Kepuasan Anda adalah prioritas kami.
      </p>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Testimoni 1 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow-md border-l-4 border-secondary">
          <div class="flex items-center mb-4">
            <img class="w-12 h-12 rounded-full mr-4" src="https://placehold.co/100x100/34D399/ffffff?text=JN" alt="User Avatar">
            <div>
              <p class="font-bold text-gray-800">Joko N.</p>
              <div class="text-sm text-yellow-500">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
              </div>
            </div>
          </div>
          <p class="italic text-gray-600">
            "Pembersihannya sangat detail! Kamar mandi saya bersih seperti baru lagi. Proses pemesanan lewat website juga sangat mudah."
          </p>
        </div>

        <!-- Testimoni 2 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow-md border-l-4 border-primary">
          <div class="flex items-center mb-4">
            <img class="w-12 h-12 rounded-full mr-4" src="https://placehold.co/100x100/0F766E/ffffff?text=SA" alt="User Avatar">
            <div>
              <p class="font-bold text-gray-800">Siti A.</p>
              <div class="text-sm text-yellow-500">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
            </div>
          </div>
          <p class="italic text-gray-600">
            "Saya menggunakan layanan kantor mingguan. Selalu tepat waktu dan hasilnya konsisten. Sangat direkomendasikan untuk pebisnis!"
          </p>
        </div>

        <!-- Testimoni 3 -->
        <div class="bg-gray-50 p-6 rounded-xl shadow-md border-l-4 border-gray-400">
          <div class="flex items-center mb-4">
            <img class="w-12 h-12 rounded-full mr-4" src="https://placehold.co/100x100/6B7280/ffffff?text=RT" alt="User Avatar">
            <div>
              <p class="font-bold text-gray-800">Rizky T.</p>
              <div class="text-sm text-yellow-500">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
              </div>
            </div>
          </div>
          <p class="italic text-gray-600">
            "Harga yang sangat kompetitif dengan kualitas kerja yang sangat baik. Terima kasih Sibersih, rumah saya nyaman lagi."
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- 6. FOOTER -->
  <footer class="color-primary py-10">
    <div class="container mx-auto px-4 text-white text-center">
      <div class="flex flex-col md:flex-row justify-around items-center md:items-start mb-8 space-y-4 md:space-y-0">
        <!-- Kolom 1: Logo & Deskripsi -->
        <div class="max-w-xs text-center md:text-left">
          <a class="flex justify-center md:justify-start items-center text-2xl font-extrabold text-white mb-2" href="#">
            <i class="fas fa-soap mr-2 text-secondary"></i> Sibersih
          </a>
          <p class="text-sm opacity-80">
            Layanan kebersihan digital terkemuka di Indonesia. Kami menciptakan lingkungan bersih, satu rumah pada satu waktu.
          </p>
        </div>

        <!-- Kolom 2: Tautan Cepat -->
        <div>
          <h5 class="text-lg font-bold mb-3 border-b-2 border-secondary inline-block">Menu</h5>
          <ul class="space-y-2 text-sm">
            <li><a href="#" class="opacity-80 hover:opacity-100 transition">Beranda</a></li>
            <li><a href="#services" class="opacity-80 hover:opacity-100 transition">Layanan Kami</a></li>
            <li><a href="#why-us" class="opacity-80 hover:opacity-100 transition">Keunggulan</a></li>
            <li><a href="login.php" class="opacity-80 hover:opacity-100 transition">Login</a></li>
          </ul>
        </div>

        <!-- Kolom 3: Kontak -->
        <div>
          <h5 class="text-lg font-bold mb-3 border-b-2 border-secondary inline-block">Hubungi Kami</h5>
          <ul class="space-y-2 text-sm">
            <li class="opacity-80"><i class="fas fa-phone mr-2"></i> +62 812-3456-7890</li>
            <li class="opacity-80"><i class="fas fa-envelope mr-2"></i> halo@sibersih.id</li>
            <li class="opacity-80"><i class="fas fa-map-marker-alt mr-2"></i> Jakarta, Indonesia</li>
          </ul>
        </div>
      </div>

      <div class="pt-6 border-t border-white border-opacity-20">
        <p class="text-sm opacity-60">
          &copy; 2024 Sibersih. Hak Cipta Dilindungi.
        </p>
      </div>
    </div>
  </footer>

  <!-- JavaScript untuk Mobile Menu -->
  <script>
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    });

    // Menutup menu mobile saat link di-klik
    document.querySelectorAll('#mobile-menu a').forEach(link => {
      link.addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.add('hidden');
      });
    });

    // Intersection Observer (Opsional: untuk animasi scroll)
    const faders = document.querySelectorAll('.animate-fadeInDown, .animate-fadeInUp, .delay-300, .delay-600');

    const appearOptions = {
      threshold: 0,
      rootMargin: "0px 0px -100px 0px" // Mulai animasi sedikit sebelum elemen masuk viewport
    };

    const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
      entries.forEach(entry => {
        if (!entry.isIntersecting) {
          return;
        } else {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
          appearOnScroll.unobserve(entry.target);
        }
      });
    }, appearOptions);

    faders.forEach(fader => {
      // Set initial state for scroll animations
      fader.style.opacity = '0';
      if (fader.classList.contains('animate-fadeInDown')) {
        fader.style.transform = 'translateY(-20px)';
      } else if (fader.classList.contains('animate-fadeInUp')) {
        fader.style.transform = 'translateY(20px)';
      }
      // Observe element
      appearOnScroll.observe(fader);
    });
  </script>
</body>

</html>