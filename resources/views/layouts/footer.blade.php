<footer class="footer py-5">
    <div class="container">
        <div class="row align-items-start">
            <!-- Kolom Kiri: Google Maps -->
            <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">Lokasi Klinik Kami</h5>
                <div class="map-container-square rounded shadow">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.4368720994107!2d108.33155197476493!3d-6.337416193652282!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ebfec24d0af95%3A0x692b65c54c4f3a1f!2sKLINIK%20HEWAN%20DV%20PETS%20CLINIC!5e0!3m2!1sid!2sid!4v1774424266483!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                <div class="mt-3">
                    <h6 class="fw-bold">Klinik Hewan DV Pets</h6>
                    <p class="small mb-2">
                        Memberikan perawatan terbaik untuk hewan peliharaan Anda dengan penuh kasih sayang dan profesionalisme.
                    </p>
                    <div class="social-links">
                        <a href="#" class="text-light me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            
            <!-- Kolom Kanan: Informasi Lainnya -->
            <div class="col-lg-7 col-md-6">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h6 class="fw-bold mb-3">Tautan Cepat</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ url('/') }}" class="text-light text-decoration-none">Beranda</a></li>
                            <li class="mb-2"><a href="{{ url('/about') }}" class="text-light text-decoration-none">Tentang Kami</a></li>
                            <li class="mb-2"><a href="{{ url('/services') }}" class="text-light text-decoration-none">Layanan</a></li>
                            <li class="mb-2"><a href="{{ url('/consultations') }}" class="text-light text-decoration-none">Kontak</a></li>
                        </ul>
                    </div>
                    
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h6 class="fw-bold mb-3">Layanan Kami</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">Konsultasi Umum</li>
                            <li class="mb-2">Vaksinasi</li>
                            <li class="mb-2">Perawatan Gigi</li>
                            <li class="mb-2">Operasi</li>
                            <li class="mb-2">Grooming</li>
                            <li class="mb-2">Rawat Inap</li>
                        </ul>
                    </div>
                    
                    <div class="col-md-4">
                        <h6 class="fw-bold mb-3">Kontak</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-map-marker-alt me-2 small"></i>
                                <span class="small">Jl. Tj. Pura No.15, Karanganyar, Indramayu</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-phone me-2 small"></i>
                                <span class="small">+62 817-7002-9905</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-envelope me-2 small"></i>
                                <span class="small">dvpets@gmail.com</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-clock me-2 small"></i>
                                <span class="small">Setiap Hari: 09.00 - 20.00 WIB</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <hr class="my-4 bg-light">
        
        <div class="text-center">
            <p class="mb-0">&copy; 2025 Klinik Hewan DV Pets. Semua Hak Dilindungi.</p>
        </div>
    </div>
</footer>

<style>
    .map-container-square {
        height: 250px;
        overflow: hidden;
        width: 100%;
        max-width: 100%;
    }
    
    /* Untuk desktop */
    @media (min-width: 768px) {
        .map-container-square {
            height: 200px;
            max-width: 300px;
        }
    }
    
    /* Untuk tablet */
    @media (max-width: 991px) and (min-width: 768px) {
        .map-container-square {
            height: 180px;
            max-width: 280px;
        }
    }
    
    /* Untuk mobile */
    @media (max-width: 767px) {
        .map-container-square {
            height: 200px;
            max-width: 100%;
        }
    }
    
    .social-links a {
        display: inline-block;
        width: 35px;
        height: 35px;
        line-height: 35px;
        text-align: center;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .social-links a:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    
    .small {
        font-size: 0.875rem;
    }
</style>

<!-- Font Awesome untuk ikon -->
<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>