@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item"><a href="/education">Edukasi</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $education->title }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">

                <!-- Thumbnail -->
                @if($education->thumbnail)
                    <img src="{{ asset("storage/" . $education->thumbnail) }}" alt="{{ $education->title }}"
                        class="img-fluid rounded shadow-sm mb-4" style="max-height: 420px; object-fit: cover; width: 100%;">
                @endif

                <!-- Title -->
                <h1 class="fw-bold">{{ $education->title }}</h1>
                <p class="text-muted mb-3">
                    {{ $education->description }}
                </p>

                <!-- Meta Info -->
                <div class="d-flex align-items-center gap-3 mb-4">

                    <span class="badge bg-success text-white px-3 py-2">
                        {{ $education->category }}
                    </span>

                    <span class="badge bg-purple text-white px-3 py-2" style="background-color: #6f42c1;">
                        {{ $education->type }}
                    </span>

                    <span class="text-muted">
                        {{ $education->view }} kali dibaca
                    </span>
                </div>

                <hr>

                <!-- Main Content -->
                <div class="article-content mt-4" style="line-height: 1.8; font-size: 18px;">
                    {!! nl2br(e($education->content)) !!}
                </div>
            </div>


            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Informasi Lain -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-bold">
                        Artikel Lainnya
                    </div>
                    <div class="card-body">

                        @foreach($related as $item)
                            <div class="d-flex mb-3">
                                <img src="{{ asset("storage/" . $item->thumbnail) }}" class="rounded me-3"
                                    style="width: 80px; height: 60px; object-fit: cover;">
                                <div>
                                    <a href="{{ route('education.show', $item->id) }}" class="fw-semibold text-dark">
                                        {{ Str::limit($item->title, 50) }}
                                    </a>
                                    <div class="text-muted" style="font-size: 14px;">
                                        {{ $item->category }} • {{ $item->type }}
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection