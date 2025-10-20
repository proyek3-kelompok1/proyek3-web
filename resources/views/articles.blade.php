@extends('layouts.app')

@section('title', 'Artikel & Edukasi - DV Pets Klinik')

@section('content')
<div class="articles-education-page">
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold text-purple mb-3">
                    <i class="fas fa-newspaper me-2"></i>Artikel & Edukasi
                </h1>
                <p class="lead text-muted">
                    Informasi, tips, dan panduan lengkap untuk perawatan hewan peliharaan
                </p>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="row mb-5">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles" type="button" role="tab" aria-controls="articles" aria-selected="true">
                            <i class="fas fa-newspaper me-2"></i>Artikel
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab" aria-controls="education" aria-selected="false">
                            <i class="fas fa-graduation-cap me-2"></i>Edukasi
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            <!-- Articles Tab -->
            <div class="tab-pane fade show active" id="articles" role="tabpanel" aria-labelledby="articles-tab">
                <!-- Featured Article -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="featured-article card border-0 shadow-lg overflow-hidden">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                                         class="img-fluid h-100 w-100" style="object-fit: cover;" alt="Featured Article">
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body p-4 d-flex flex-column h-100">
                                        <span class="badge bg-purple mb-3 align-self-start">Featured</span>
                                        <h2 class="card-title h3 fw-bold text-dark mb-3">
                                            Cara Merawat Kucing dengan Baik dan Benar
                                        </h2>
                                        <p class="card-text text-muted mb-4 flex-grow-1">
                                            Panduan lengkap untuk merawat kucing kesayangan Anda, mulai dari pemilihan makanan, 
                                            perawatan kesehatan, hingga tips membuat kucing bahagia di rumah.
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Dr+Wahyudi&background=6a3093&color=fff" 
                                                     class="rounded-circle me-2" width="40" height="40" alt="Author">
                                                <div>
                                                    <small class="fw-bold text-dark">Dr. Wahyudi</small>
                                                    <br>
                                                    <small class="text-muted">2 hari lalu</small>
                                                </div>
                                            </div>
                                            <a href="#" class="btn btn-purple">
                                                Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles Grid -->
                <div class="row">
                    @foreach([
                        [
                            'title' => 'Vaksinasi Hewan: Pentingnya dan Jadwal yang Tepat',
                            'excerpt' => 'Ketahui jadwal vaksinasi yang tepat untuk anjing dan kucing Anda...',
                            'image' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                            'author' => 'Dr. Sari',
                            'date' => '1 minggu lalu'
                        ],
                        [
                            'title' => 'Mengenal Penyakit Umum pada Anjing',
                            'excerpt' => 'Kenali gejala dan cara pencegahan penyakit umum yang sering menyerang anjing...',
                            'image' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                            'author' => 'Dr. Budi',
                            'date' => '3 hari lalu'
                        ],
                        [
                            'title' => 'Tips Grooming untuk Kucing Persia',
                            'excerpt' => 'Cara merawat bulu kucing persia agar tetap indah dan sehat...',
                            'image' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                            'author' => 'Dr. Maya',
                            'date' => '5 hari lalu'
                        ],
                        [
                            'title' => 'Pentingnya Sterilisasi untuk Hewan Peliharaan',
                            'excerpt' => 'Manfaat sterilisasi dan kapan waktu yang tepat untuk melakukannya...',
                            'image' => 'https://images.unsplash.com/photo-1543852786-1cf6624b9987?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                            'author' => 'Dr. Andi',
                            'date' => '1 minggu lalu'
                        ],
                        [
                            'title' => 'Memilih Makanan Terbaik untuk Anjing',
                            'excerpt' => 'Panduan memilih makanan yang sesuai dengan usia dan breed anjing...',
                            'image' => 'https://images.unsplash.com/photo-1503256207526-0d5d80fa2f47?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                            'author' => 'Dr. Rina',
                            'date' => '2 hari lalu'
                        ],
                        [
                            'title' => 'Perawatan Gigi untuk Kucing dan Anjing',
                            'excerpt' => 'Cara menjaga kesehatan gigi dan mulut hewan peliharaan Anda...',
                            'image' => 'https://images.unsplash.com/photo-1517423738875-5ce310acd3da?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                            'author' => 'Dr. Fitri',
                            'date' => '4 hari lalu'
                        ]
                    ] as $article)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="article-card card h-100 border-0 shadow-sm">
                            <img src="{{ $article['image'] }}" class="card-img-top" alt="{{ $article['title'] }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark">{{ $article['title'] }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ $article['excerpt'] }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($article['author']) }}&background=6a3093&color=fff" 
                                             class="rounded-circle me-2" width="30" height="30" alt="Author">
                                        <small class="text-muted">{{ $article['author'] }}</small>
                                    </div>
                                    <small class="text-muted">{{ $article['date'] }}</small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="#" class="btn btn-outline-purple btn-sm w-100">
                                    Baca Artikel <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Education Tab -->
            <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                <!-- Video Tutorials -->
                <div class="row mb-5">
                    <div class="col-12">
                        <h2 class="h3 fw-bold text-dark mb-4">
                            <i class="fas fa-play-circle me-2 text-purple"></i>Video Tutorial
                        </h2>
                        <div class="row">
                            @foreach([
                                [
                                    'title' => 'Cara Memandikan Kucing yang Benar',
                                    'duration' => '8:30',
                                    'views' => '15.2K',
                                    'thumbnail' => 'https://images.unsplash.com/photo-1511044568932-338cba0ad803?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                                    'date' => '2 minggu lalu'
                                ],
                                [
                                    'title' => 'Teknik Dasar Training Anjing',
                                    'duration' => '12:15',
                                    'views' => '23.7K',
                                    'thumbnail' => 'https://images.unsplash.com/photo-1587300003388-59208cc962cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                                    'date' => '3 minggu lalu'
                                ],
                                [
                                    'title' => 'Pertolongan Pertama pada Hewan',
                                    'duration' => '15:42',
                                    'views' => '18.9K',
                                    'thumbnail' => 'https://images.unsplash.com/photo-1559715541-5daf8a0296d0?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
                                    'date' => '1 minggu lalu'
                                ]
                            ] as $video)
                            <div class="col-md-4 mb-4">
                                <div class="video-card card border-0 shadow-sm">
                                    <div class="position-relative">
                                        <img src="{{ $video['thumbnail'] }}" class="card-img-top" alt="{{ $video['title'] }}" style="height: 200px; object-fit: cover;">
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <div class="play-btn btn btn-purple rounded-circle p-3">
                                                <i class="fas fa-play"></i>
                                            </div>
                                        </div>
                                        <div class="position-absolute bottom-0 end-0 m-2">
                                            <span class="badge bg-dark bg-opacity-75">{{ $video['duration'] }}</span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold text-dark">{{ $video['title'] }}</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-eye me-1"></i>{{ $video['views'] }} views
                                            </small>
                                            <small class="text-muted">{{ $video['date'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Educational Guides -->
                <div class="row">
                    <div class="col-12">
                        <h2 class="h3 fw-bold text-dark mb-4">
                            <i class="fas fa-book me-2 text-purple"></i>Panduan Lengkap
                        </h2>
                        <div class="row">
                            @foreach([
                                [
                                    'title' => 'Panduan Lengkap Vaksinasi Hewan',
                                    'category' => 'kesehatan',
                                    'level' => 'Pemula',
                                    'time' => '10 min read',
                                    'icon' => 'fas fa-syringe',
                                    'description' => 'Panduan lengkap untuk memahami dan menerapkan vaksinasi pada hewan peliharaan Anda.'
                                ],
                                [
                                    'title' => 'Memahami Perilaku Kucing',
                                    'category' => 'perilaku', 
                                    'level' => 'Menengah',
                                    'time' => '15 min read',
                                    'icon' => 'fas fa-cat',
                                    'description' => 'Pelajari cara memahami bahasa tubuh dan perilaku kucing untuk hubungan yang lebih baik.'
                                ],
                                [
                                    'title' => 'Formula Makanan Sehat untuk Anjing',
                                    'category' => 'nutrisi',
                                    'level' => 'Lanjutan', 
                                    'time' => '20 min read',
                                    'icon' => 'fas fa-bone',
                                    'description' => 'Formula dan resep makanan sehat yang dapat Anda buat sendiri untuk anjing kesayangan.'
                                ],
                                [
                                    'title' => 'Teknik Grooming Professional',
                                    'category' => 'grooming',
                                    'level' => 'Menengah',
                                    'time' => '12 min read', 
                                    'icon' => 'fas fa-cut',
                                    'description' => 'Teknik grooming profesional yang dapat Anda praktikkan di rumah untuk hewan peliharaan.'
                                ],
                                [
                                    'title' => 'Basic Obedience Training',
                                    'category' => 'training',
                                    'level' => 'Pemula',
                                    'time' => '8 min read',
                                    'icon' => 'fas fa-dog',
                                    'description' => 'Pelatihan dasar untuk anjing Anda mulai dari sit, stay, hingga come command.'
                                ],
                                [
                                    'title' => 'Deteksi Dini Penyakit Hewan',
                                    'category' => 'kesehatan',
                                    'level' => 'Menengah',
                                    'time' => '18 min read',
                                    'icon' => 'fas fa-stethoscope',
                                    'description' => 'Belajar mengenali tanda-tanda awal penyakit pada hewan peliharaan Anda.'
                                ]
                            ] as $guide)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="guide-card card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="guide-icon bg-purple text-white rounded-circle p-3 me-3">
                                                <i class="{{ $guide['icon'] }}"></i>
                                            </div>
                                            <div>
                                                <span class="badge bg-light text-purple mb-1">{{ $guide['level'] }}</span>
                                                <br>
                                                <small class="text-muted">{{ $guide['time'] }}</small>
                                            </div>
                                        </div>
                                        <h5 class="card-title fw-bold text-dark">{{ $guide['title'] }}</h5>
                                        <p class="card-text text-muted small">
                                            {{ $guide['description'] }}
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <a href="#" class="btn btn-outline-purple btn-sm w-100">
                                            Pelajari Sekarang <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .articles-education-page {
        background: linear-gradient(135deg, #f8f5ff 0%, #f0e6ff 100%);
        min-height: 100vh;
    }
    
    .text-purple {
        color: #6a3093 !important;
    }
    
    .btn-purple {
        background: linear-gradient(135deg, #6a3093, #8a4dcc);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-purple:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(106, 48, 147, 0.4);
        color: white;
    }
    
    .btn-outline-purple {
        border: 2px solid #6a3093;
        color: #6a3093;
        background: transparent;
        transition: all 0.3s ease;
    }
    
    .btn-outline-purple:hover {
        background: #6a3093;
        color: white;
        transform: translateY(-2px);
    }
    
    .badge.bg-purple {
        background: linear-gradient(135deg, #6a3093, #8a4dcc) !important;
    }
    
    .featured-article, .article-card, .video-card, .guide-card, .category-card {
        transition: transform 0.3s ease;
    }
    
    .featured-article:hover, .article-card:hover, .video-card:hover, .guide-card:hover, .category-card:hover {
        transform: translateY(-5px);
    }
    
    .nav-pills .nav-link {
        color: #6a3093;
        font-weight: 500;
        margin: 0 5px;
        border: 2px solid #6a3093;
        border-radius: 50px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
    
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #6a3093, #8a4dcc);
        border-color: #6a3093;
    }
    
    .nav-pills .nav-link:not(.active):hover {
        background: rgba(106, 48, 147, 0.1);
    }
    
    .play-btn {
        transition: all 0.3s ease;
        opacity: 0.9;
    }
    
    .play-btn:hover {
        transform: scale(1.1);
        opacity: 1;
    }
    
    .guide-icon, .category-icon {
        transition: transform 0.3s ease;
    }
    
    .guide-card:hover .guide-icon, .category-card:hover .category-icon {
        transform: scale(1.1);
    }
    
    .bg-purple {
        background: linear-gradient(135deg, #6a3093, #8a4dcc) !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab button'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)
        
        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    });
});
</script>
@endsection