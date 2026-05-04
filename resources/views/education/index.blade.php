@extends('layouts.app')

@section('title', 'Artikel & Edukasi - DV Pets Klinik')

@section('content')

<style>
    .text-purple {
        color: #6f42c1;
    }

    .btn-purple {
        background: #6f42c1;
        color: #fff;
        border-radius: 8px;
    }

    .btn-purple:hover {
        background: #5a35a0;
        color: #fff;
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .featured-card {
        border-radius: 18px;
        overflow: hidden;
    }

    .featured-img {
        height: 100%;
        object-fit: cover;
    }
</style>

<div style="background:#f8f6ff; min-height:100vh;">
    <div class="container py-5">

        <!-- HEADER -->
        <div class="text-center mb-5">
            <h1 class="fw-bold text-purple">
                Edukasi Hewan 🐾
            </h1>
            <p class="text-muted">
                Tips, panduan, dan informasi terbaik untuk kesehatan peliharaanmu
            </p>
        </div>

        <!-- FEATURED -->
        @if($featuredContent)
            <div class="card featured-card shadow-sm mb-5 card-hover">
                <div class="row g-0">

                    <div class="col-md-6 position-relative">
                        <img src="{{ asset('storage/' . $featuredContent->thumbnail) }}"
                            class="w-100 featured-img">
                        @if($featuredContent->type == 'video')
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <a href="{{ $featuredContent->video_url }}" target="_blank" class="btn btn-light rounded-circle shadow-lg" style="width: 70px; height: 70px; display: flex; align-items: center; justify-content: center; opacity: 0.9;">
                                    <i class="fas fa-play text-danger fa-2x"></i>
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 p-4 d-flex flex-column">

                        <span class="badge bg-purple mb-2" style="width:max-content;">
                            Highlight • {{ ucfirst($featuredContent->type) }}
                        </span>

                        <h3 class="fw-bold">
                            {{ $featuredContent->title }}
                        </h3>

                        <p class="text-muted flex-grow-1">
                            {{ Str::limit($featuredContent->description, 150) }}
                        </p>

                        <div class="text-muted small mb-3">
                            {{ $featuredContent->created_at->format('d M Y') }}
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('education.show', $featuredContent->id) }}"
                                class="btn btn-outline-purple flex-grow-1">
                                Baca Artikel
                            </a>
                            @if($featuredContent->type == 'video' && $featuredContent->video_url)
                                <a href="{{ $featuredContent->video_url }}" target="_blank" class="btn btn-danger">
                                    <i class="fab fa-youtube me-1"></i> Tonton
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <!-- LIST -->
        <div class="row g-4">
            @foreach($educations as $item)
                <div class="col-md-4">

                    <div class="card h-100 border-0 shadow-sm card-hover">

                        <div class="position-relative">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                    class="w-100"
                                    style="height:200px; object-fit:cover;">
                            @endif
                            @if($item->type == 'video')
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <a href="{{ $item->video_url }}" target="_blank" class="btn btn-light rounded-circle shadow" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; opacity: 0.8;">
                                        <i class="fas fa-play text-danger"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="card-body">

                            <span class="badge bg-light text-dark mb-2">
                                {{ $item->category }}
                            </span>

                            <h5 class="fw-bold">
                                {{ $item->title }}
                            </h5>

                            <p class="text-muted small">
                                {{ Str::limit($item->description, 100) }}
                            </p>

                        </div>

                        <div class="card-footer bg-white border-0 d-flex gap-2">
                            <a href="{{ route('education.show', $item->id) }}"
                                class="btn btn-sm btn-purple flex-grow-1">
                                Detail
                            </a>
                            @if($item->type == 'video' && $item->video_url)
                                <a href="{{ $item->video_url }}" target="_blank" class="btn btn-sm btn-danger">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            @endif
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

    </div>
</div>

@endsection