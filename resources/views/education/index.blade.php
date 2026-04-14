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

                    <div class="col-md-6">
                        <img src="{{ asset('storage/' . $featuredContent->thumbnail) }}"
                            class="w-100 featured-img">
                    </div>

                    <div class="col-md-6 p-4 d-flex flex-column">

                        <span class="badge bg-purple mb-2" style="width:max-content;">
                            Highlight
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

                        <a href="{{ route('education.show', $featuredContent->id) }}"
                            class="btn btn-purple">
                            Baca Artikel
                        </a>

                    </div>
                </div>
            </div>
        @endif

        <!-- LIST -->
        <div class="row g-4">
            @foreach($educations as $item)
                <div class="col-md-4">

                    <div class="card h-100 border-0 shadow-sm card-hover">

                        @if($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                style="height:200px; object-fit:cover;">
                        @endif

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

                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('education.show', $item->id) }}"
                                class="btn btn-sm btn-purple w-100">
                                Lihat Detail
                            </a>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

    </div>
</div>

@endsection