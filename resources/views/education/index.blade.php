@extends('layouts.app')

@section('title', 'Artikel & Edukasi - DV Pets Klinik')

@section('content')

<div class="articles-education-page" style="background:#f7ecff; min-height:100vh;">
    <div class="container py-5">

        {{-- HEADER --}}
        <div class="text-center mb-4">
            <h1 class="fw-bold text-purple" style="font-size:45px;">
                <i class="fas fa-book-open me-2"></i> Edukasi
            </h1>
            <p class="text-muted" style="font-size:18px;">
                Informasi, tips, dan panduan lengkap untuk perawatan hewan peliharaan
            </p>

            {{-- Tombol filter --}}
            <div class="d-flex justify-content-center gap-3 mt-3">
                <a href="/" class="btn btn-purple px-4 py-2">
                    <i class="fas fa-newspaper me-1"></i> Edukasi
                </a>
            </div>
        </div>

        {{-- FEATURED CONTENT --}}
        @if($featuredContent)
        <div class="card mb-5 shadow-lg overflow-hidden" style="border-radius:15px;">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="{{ asset(ltrim($featuredContent->thumbnail, '/')) }}"
     class="img-fluid w-100"
     style="object-fit:cover; height:350px;">

                </div>

                <div class="col-md-6 p-4 d-flex flex-column">
                    
                    <span class="badge bg-purple mb-3">Featured</span>

                    <h2 class="fw-bold text-dark">{{ $featuredContent->title }}</h2>

                    <p class="text-muted flex-grow-1">
                        {{ $featuredContent->description }}
                    </p>

                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-purple text-white d-flex justify-content-center align-items-center"
                             style="width:40px; height:40px;">
                            DW
                        </div>

                        <div class="ms-2">
                            <strong>Dr. Wahyudi</strong>
                            <div class="text-muted small">{{ $featuredContent->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <a href="{{ route('education.show', $featuredContent->id) }}" 
                       class="btn btn-purple mt-auto">
                        Baca Selengkapnya →
                    </a>
                </div>
            </div>
        </div>
        @endif

        {{-- LIST ARTIKEL/Edukasi --}}
        <div class="row">

            @foreach($educations as $item)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100" style="border-radius:12px; overflow:hidden;">

                    {{-- Thumbnail --}}
                    @if($item->thumbnail)
<img src="{{ asset($item->thumbnail) }}" 
     alt="{{ $item->title }}" 
     class="img-fluid rounded shadow-sm mb-4"
     style="max-height: 420px; object-fit: cover; width: 100%;">
@endif


                    <div class="card-body">

                        {{-- Category --}}
                        <span class="badge bg-purple mb-2">{{ $item->category }}</span>

                        <h5 class="fw-bold">{{ $item->title }}</h5>

                        <p class="text-muted small">
                            {{ Str::limit($item->description, 120) }}
                        </p>

                        <div class="text-muted small mt-3">
                            <i class="far fa-clock me-1"></i>
                            {{ $item->created_at->diffForHumans() }}
                        </div>

                    </div>

                    <div class="card-footer bg-white border-0">
                        <a href="{{ route('education.show', $item->id) }}" 
                            class="btn btn-purple w-100 text-white">
                            Baca Selengkapnya →
                        </a>

                    </div>

                </div>
            </div>
            @endforeach

        </div>

    </div>
</div>

@endsection
