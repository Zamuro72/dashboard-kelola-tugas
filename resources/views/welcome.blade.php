<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Manajemen Kandel</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{asset('enno/assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('enno/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('enno/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('enno/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('enno/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('enno/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('enno/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('enno/assets/css/main.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: eNno
  * Template URL: https://bootstrapmade.com/enno-free-simple-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="#" class="logo d-flex align-items-center me-auto">
        <img src="{{ asset('enno/assets/img/logo.png') }}">
        <h1 class="sitename">Sistem Manajemen Kandel</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#about">Tentang Kami</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

       @auth
      <a class="btn-getstarted" href="{{ route('dashboard') }}">Dashboard</a>

       @else
      <a class="btn-getstarted" href="{{ route('login') }}">Login</a>
       @endauth


    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
            <h1>Sistem Kandel</h1>
            <p>Aplikasi Untuk Mengelola Kebutuhan Internal</p>
            <div class="d-flex">
              @auth
              <a href="{{ route('dashboard') }}" class="btn-get-started">Dashboard</a>
              @else
              <a href="{{ route('login') }}" class="btn-get-started">Login</a>
              @endauth
              
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="100">
            <img src="{{ asset('enno/assets/img/hero-img.png') }}" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>Tentang Kami<br></span>
        <h2>Tentang Kami</h2>
        <p style= "text-align: justify;">Kami adalah perusahaan yang bergerak dalam pengembangan sumber daya manusia (SDM) melalui pelatihan dan sertifikasi Keselamatan, 
          Kesehatan Kerja, dan Lingkungan (K3L) serta Sistem Manajemen Mutu, 
          yang dirancang untuk menjawab kebutuhan industri masa kini dan masa depan. 
          Dengan semangat untuk berkontribusi terhadap kemajuan dunia usaha dan peningkatan kualitas tenaga kerja, kami berkomitmen untuk mendampingi perusahaan dalam membangun budaya K3L yang kuat, 
          mendukung pertumbuhan SDM yang berkelanjutan, serta mendorong efisiensi melalui sistem manajemen yang terukur dan berstandar. 
          Didukung oleh tenaga ahli profesional, modul pelatihan yang aplikatif, serta pendekatan konsultatif yang disesuaikan dengan kebutuhan klien, 
          kami menawarkan berbagai layanan unggulan mulai dari pelatihan dasar hingga sertifikasi spesialis di berbagai sektor industri.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="100">
          </div>
          <div class="col-xl-12 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Sistem Pengelola</h3>
            <ul>
              <li><i class="bi bi-check2-all"></i> <span>Mengolah Data Karyawan</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Monitor Tugas Karyawan</span></li>
              <li><i class="bi bi-check2-all"></i> <span>Dikelola Oleh Admin</span></li>
            </ul>
            <p>
              Sistem yang simple dan mudah untuk dipakai
            </p>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

      </div>


    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>Kontak</span>
        <h2>Kontak</h2>
        <p>Alamat dan Informasi Kontak Kami</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-xl-12">

            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Alamat</h3>
                  <p>Kawasan Niaga Citra Grand Cibubur, Jl. Alternatif Cibubur No.10 Blok R12, 
                    RT.002/RW.008, Jatisampurna, 
                    Kec. Jatisampurna, Kota Bekasi, Jawa Barat 17435</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Kontak</h3>
                  <p>+62 812-3484-6680</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email</h3>
                  <p>kandelsekeco@gmail.com</p>
                </div>
              </div><!-- End Info Item -->

              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.09822001035!2d106.926903!3d-6.3813222!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c02692084e13%3A0x7019642eb1230aad!2sPT%20Kandel%20Sekeco%20Internasional!5e0!3m2!1sid!2sid!4v1768465338062!5m2!1sid!2sid" frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>


        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">


    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Zamuro</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">Zamuro</a> Distributed by <a href=“https://themewagon.com>Zamuro
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{asset('enno/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('enno/assets/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('enno/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('enno/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('enno/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('enno/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{asset('enno/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('enno/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('enno/assets/js/main.js') }}"></script>

</body>

</html>