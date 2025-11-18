@extends('layouts.app')

@section('title', 'Artikel & Edukasi - DV Pets Klinik')

@section('content')
@php
    // Pastikan variabel ada, jika tidak set default value
    $videos = $videos ?? collect();
    $guides = $guides ?? collect();
    $featuredContent = $featuredContent ?? null;
@endphp

<div class="articles-education-page">
    <div class="container py-5">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 fw-bold text-purple mb-3">
                    <i class="fas fa-graduation-cap me-2"></i>Artikel & Edukasi
                </h1>
                <p class="lead text-muted">
                    Video tutorial dan panduan lengkap untuk perawatan hewan peliharaan Anda
                </p>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="row mb-5">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="articles-tab" data-bs-toggle="tab" data-bs-target="#articles" type="button" role="tab" aria-controls="articles" aria-selected="true">
                            <i class="fas fa-newspaper me-2"></i>Semua Edukasi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button" role="tab" aria-controls="videos" aria-selected="false">
                            <i class="fas fa-play-circle me-2"></i>Video Tutorial
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="guides-tab" data-bs-toggle="tab" data-bs-target="#guides" type="button" role="tab" aria-controls="guides" aria-selected="false">
                            <i class="fas fa-book me-2"></i>Panduan Lengkap
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            <!-- Articles Tab (Semua Edukasi) -->
            <div class="tab-pane fade show active" id="articles" role="tabpanel" aria-labelledby="articles-tab">
                <!-- Featured Content -->
                @if($featuredContent)
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="featured-article card border-0 shadow-lg overflow-hidden">
                            <div class="row g-0">
                                <div class="col-md-6">
                                    <img src="{{ $featuredContent->thumbnail_url }}" 
                                         class="img-fluid h-100 w-100" style="object-fit: cover;" alt="{{ $featuredContent->title }}"
                                         onerror="this.src='https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'">
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body p-4 d-flex flex-column h-100">
                                        <span class="badge bg-purple mb-3 align-self-start">
                                            @if($featuredContent->type == 'video')
                                                <i class="fas fa-play-circle me-1"></i>Video
                                            @else
                                                <i class="fas fa-book me-1"></i>Panduan
                                            @endif
                                        </span>
                                        <h2 class="card-title h3 fw-bold text-dark mb-3">
                                            {{ $featuredContent->title }}
                                        </h2>
                                        <p class="card-text text-muted mb-4 flex-grow-1">
                                            {{ $featuredContent->description ?? 'Deskripsi tidak tersedia' }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <img src="https://ui-avatars.com/api/?name=Admin+DV+Pets&background=6a3093&color=fff" 
                                                     class="rounded-circle me-2" width="40" height="40" alt="Author">
                                                <div>
                                                    <small class="fw-bold text-dark">Admin DV Pets</small>
                                                    <br>
                                                    <small class="text-muted">{{ $featuredContent->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <a href="{{ route('articles.show', $featuredContent->id) }}" class="btn btn-purple">
                                                @if($featuredContent->type == 'video')
                                                    Tonton Sekarang
                                                @else
                                                    Baca Selengkapnya
                                                @endif
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- All Educations Grid -->
                <div class="row">
                    @php
                        $allEducations = $videos->merge($guides)->sortByDesc('created_at');
                    @endphp
                    
                    @forelse($allEducations as $education)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="education-card card h-100 border-0 shadow-sm">
                            @if($education->type == 'video')
                            <div class="position-relative">
                                <img src="{{ $education->thumbnail_url }}" class="card-img-top" alt="{{ $education->title }}" style="height: 200px; object-fit: cover;"
                                     onerror="this.src='https://images.unsplash.com/photo-1511044568932-338cba0ad803?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'">
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="play-btn btn btn-purple rounded-circle p-3">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                @if($education->duration)
                                <div class="position-absolute bottom-0 end-0 m-2">
                                    <span class="badge bg-dark bg-opacity-75">{{ $education->duration }}</span>
                                </div>
                                @endif
                            </div>
                            @else
                            <img src="{{ $education->thumbnail_url }}" class="card-img-top" alt="{{ $education->title }}" style="height: 200px; object-fit: cover;"
                                 onerror="this.src='https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'">
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-{{ $education->category_color }}">{{ $education->category }}</span>
                                    <span class="badge bg-light text-purple">
                                        <i class="{{ $education->type_icon }} me-1"></i>
                                        {{ $education->type == 'video' ? 'Video' : 'Panduan' }}
                                    </span>
                                </div>
                                <h5 class="card-title fw-bold text-dark">{{ $education->title }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ $education->description ?? 'Deskripsi tidak tersedia' }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <div class="d-flex align-items-center">
                                        @if($education->reading_time)
                                        <small class="text-muted">{{ $education->reading_time }}</small>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $education->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('articles.show', $education->id) }}" class="btn btn-outline-purple btn-sm w-100">
                                    @if($education->type == 'video')
                                        Tonton Video
                                    @else
                                        Baca Panduan
                                    @endif
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Belum ada konten edukasi yang tersedia.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Videos Tab -->
            <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                <!-- Videos Grid -->
                <div class="row">
                    @forelse($videos as $video)
                    <div class="col-md-4 mb-4">
                        <div class="video-card card border-0 shadow-sm">
                            <div class="position-relative">
                                <img src="{{ $video->thumbnail_url }}" class="card-img-top" alt="{{ $video->title }}" style="height: 200px; object-fit: cover;"
                                     onerror="this.src='https://images.unsplash.com/photo-1511044568932-338cba0ad803?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'">
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div class="play-btn btn btn-purple rounded-circle p-3">
                                        <i class="fas fa-play"></i>
                                    </div>
                                </div>
                                @if($video->duration)
                                <div class="position-absolute bottom-0 end-0 m-2">
                                    <span class="badge bg-dark bg-opacity-75">{{ $video->duration }}</span>
                                </div>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark">{{ $video->title }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    {{ $video->description ?? 'Deskripsi tidak tersedia' }}
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $video->category_color }} me-2">{{ $video->category }}</span>
                                        @if($video->reading_time)
                                        <small class="text-muted">{{ $video->reading_time }}</small>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ $video->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('articles.show', $video->id) }}" class="btn btn-outline-purple btn-sm w-100">
                                    Tonton Video <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Belum ada video tutorial yang tersedia.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Guides Tab -->
            <div class="tab-pane fade" id="guides" role="tabpanel" aria-labelledby="guides-tab">
                <!-- Guides Grid -->
                <div class="row">
                    @forelse($guides as $guide)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="guide-card card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="guide-icon bg-purple text-white rounded-circle p-3 me-3">
                                        <i class="{{ $guide->type_icon }}"></i>
                                    </div>
                                    <div>
                                        @if($guide->level)
                                        <span class="badge bg-light text-purple mb-1">{{ $guide->level }}</span>
                                        <br>
                                        @endif
                                        <small class="text-muted">{{ $guide->reading_time ?? '5 min read' }}</small>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold text-dark">{{ $guide->title }}</h5>
                                <p class="card-text text-muted small">
                                    {{ $guide->description ?? 'Deskripsi tidak tersedia' }}
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0">
                                <a href="{{ route('articles.show', $guide->id) }}" class="btn btn-outline-purple btn-sm w-100">
                                    Pelajari Sekarang <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Belum ada panduan yang tersedia.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS dan JavaScript tetap sama -->
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
    
    .featured-article, .education-card, .video-card, .guide-card {
        transition: transform 0.3s ease;
    }
    
    .featured-article:hover, .education-card:hover, .video-card:hover, .guide-card:hover {
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
    
    .guide-icon {
        transition: transform 0.3s ease;
    }
    
    .guide-card:hover .guide-icon {
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