<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .d-flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar {
            background: #ffcc00;
            background: -webkit-linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
            background: linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-nav .nav-link.active {
            color: #fff;
            font-weight: bold;
        }

        .gold {
            color: #FFD700;
        }

        .btn {
            color: #fff;
            background-color: #ffcc00;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            border: 2px solid #fff; 
        }

        .btn:hover {
            color: #ffcc00;
            background-color: #fff;
            border: 2px solid #ffcc00;
        }

        .bg-primary-custom {
            background: #ffcc00;
            background: -webkit-linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
            background: linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
            color: #fff;
        }

        .bg-light-custom {
            background-color: #f8f9fa;
        }

        .bg-dark-custom {
            background-color: #343a40;
            color: #fff;
        }

        .footer-custom {
            background-color: #343a40;
            color: #fff;
        }

        .accordion-header button {
            font-weight: bold;
            color: black;
        }

        .accordion-header button:not(.collapsed) {
            background-color: #ffcc00;
        }

        .btn-gold {
            color: #fff;
            background-color: #ffcc00;
            border: none;
            padding: 10px 20px;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }

        .btn-gold:hover {
            background-color: #ffb347;
            color: #fff;
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .card-img-top {
            border-bottom: 1px solid #f0f0f0;
            border-radius: 0;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .shadow-sm {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .card {
                margin-bottom: 20px;
            }
        }
    
        #home {
            position: relative;
            color: #fff;
        }

        .custom-img-size {
            max-width: 100%; 
        }

        #products {
            background-color: #f0f0f0; /* Light gray background for Products section */
        }

        #about {
            background-color: #fff; /* White background for About section */
        }

        #contact {
            background: #ffcc00;
            background: -webkit-linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
            background: linear-gradient(to right, #ffcc00, #ffb347, #ff8c00, #ff8008);
        }

        #contact .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f0f0f0;
            border-radius: 10px;
            box-shadow: 0 6px 6px rgba(0, 0, 0, 1);
        }

        #faq {
            background-color: #f0f0f0; /* Light gray background for Q&A section */
        }

        #faq .accordion-item {
            margin-bottom: 10px;
        }

        .card:hover {
            transform: scale(1.05);
            transition: transform 0.3s;
        }

        .card img {
            transition: transform 0.3s;
        }

        .card:hover img {
            transform: scale(1.0);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="{{ asset('img/logo_batiks.png') }}" alt="Home" class="img-fluid custom-img-size" style="width: 45px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>   
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#home" onclick="setActive(this)">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about" onclick="setActive(this)">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact" onclick="setActive(this)">Hubungi Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq" onclick="setActive(this)">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-people"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <section id="home" class="d-flex align-items-center" style="min-height: 100vh; background-color: #f8f9fa;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="text-black fw-bold"><span style="color: #FFD700;">SCM</span> Batik</h1>
                    <h2 class="text-black fst-italic">Elegance in Every Thread</h2>
                    <p class="text-black text-justify">Di SCM Batik, kami mengutamakan kualitas dan tradisi. Setiap batik dipilih dengan cermat dan diproduksi dengan bahan-bahan terbaik untuk memberikan kenyamanan dan daya tahan maksimal. Tim kami terdiri dari pengrajin berbakat yang terus berinovasi untuk menghadirkan produk-produk batik terkini yang tidak hanya modis tetapi juga sarat makna budaya.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Mulai Sekarang</a>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('img/batik.png') }}" alt="Home" class="img-fluid custom-img-size" style="width: 80%;">
                </div>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <h2 class="text-center fw-bold" style="margin-top: 20px;">Tentang Kami</h2>
            <div class="row d-flex align-items-center">
                <div class="col-md-6">
                    <img src="img/batik3.png" class="img-fluid rounded mb-4 mb-md-0" alt="Tentang Kami" style="width: 80%;">
                </div>
                <div class="col-md-6">
                    <p class="text-justify">SCM Batik adalah sebuah toko pakaian dan penyedia jasa konveksi batik yang terletak di daerah Tembalang, sebuah kawasan yang dinamis di Kota Semarang. Kami tidak hanya menyediakan berbagai pilihan batik berkualitas tinggi, tetapi juga menawarkan layanan konveksi yang handal dan profesional. Lokasi kami yang strategis memudahkan pelanggan untuk mengakses toko kami, baik dari pusat kota maupun dari daerah sekitarnya.</p>
                    <p class="text-justify">Komitmen kami terhadap kualitas tercermin dalam setiap produk yang kami tawarkan. Kami bekerja sama dengan pengrajin batik lokal yang berpengalaman dan menggunakan bahan-bahan terbaik untuk memastikan setiap pakaian yang kami produksi memenuhi standar tertinggi. Selain itu, kami juga selalu mengikuti perkembangan tren fashion terbaru untuk memberikan pilihan yang modern dan stylish kepada pelanggan kami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold text-black">Hubungi Kami</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark-custom p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-envelope fa-3x mb-3"></i>
                            <h5 class="card-title">Email</h5>
                            <p class="card-text">contact@scmbatik.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark-custom p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-phone fa-3x mb-3"></i>
                            <h5 class="card-title">No. Telepon</h5>
                            <p class="card-text">085799647295</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark-custom p-3 h-100">
                        <div class="card-body">
                            <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                            <h5 class="card-title">Alamat</h5>
                            <p class="card-text">Perumahan Tembalang Pesona Asri Blok A1 No.5 Tembalang, Semarang, Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-5 bg-light-custom">
        <div class="accordion accordion-flush bg-light-custom mx-5" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Dimana letak SCM Batik?
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">SCM Batik terletak di Tembalang.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    Mengapa harus SCM Batik?
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">SCM Batik menawarkan produk dengan kualitas tinggi yang terjamin. Bahan-bahan yang dipilih dengan cermat dan perhatian terhadap detail dalam desain membuat setiap produk menjadi nilai investasi yang baik bagi konsumen.</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    No. Telepon yang bisa dihubungi?
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">Jangan segan menghubungi kami pada +62-888-888-888.</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer-custom py-4">
        <div class="container text-center">
            <p>&copy; 2024 SCM Batik. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function setActive(element) {
            var navLinks = document.querySelectorAll('.navbar-nav .nav-link');
            navLinks.forEach(function(navLink) {
                navLink.classList.remove('active');
            });
            element.classList.add('active');
        }

        var carousel = new bootstrap.Carousel('#home');
    </script>
</body>
</html>
