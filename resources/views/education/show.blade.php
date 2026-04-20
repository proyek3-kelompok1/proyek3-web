@extends('layouts.app')

@section('content')

<style>
    .article-content {
        line-height: 1.9;
        font-size: 17px;
        color: #444;
    }

    .article-content p {
        margin-bottom: 18px;
    }

    .sidebar-card {
        border-radius: 12px;
    }

    .related-item {
        transition: 0.2s;
    }

    .related-item:hover {
        transform: translateX(5px);
    }
</style>

<div class="container py-5">

    <!-- Breadcrumb -->
    <nav class="mb-4">
        <small class="text-muted">
            Beranda / Edukasi / {{ $education->title }}
        </small>
    </nav>

    <div class="row">

        <!-- MAIN -->
        <div class="col-lg-8">

            @if($education->thumbnail)
                <img src="{{ asset("storage/" . $education->thumbnail) }}"
                    class="img-fluid rounded mb-4"
                    style="max-height:400px; width:100%; object-fit:cover;">
            @endif

            <h1 class="fw-bold mb-3">
                {{ $education->title }}
            </h1>

            <div class="mb-3">
                <span class="badge bg-light text-dark">
                    {{ $education->category }}
                </span>

                <span class="badge bg-purple">
                    {{ $education->type }}
                </span>

                <span class="text-muted ms-2">
                    • {{ $education->view }} views
                </span>
            </div>

            <hr>

            <div class="article-content mt-4">
                {!! nl2br(e($education->content)) !!}
            </div>

        </div>

        <!-- SIDEBAR -->
        <div class="col-lg-4">

            <div class="card shadow-sm sidebar-card">
                <div class="card-header bg-white fw-semibold">
                    Artikel Lainnya
                </div>

                <div class="card-body">

                    @foreach($related as $item)
                        <div class="d-flex mb-3 related-item">

                            <img src="{{ asset("storage/" . $item->thumbnail) }}"
                                class="rounded me-3"
                                style="width:70px; height:60px; object-fit:cover;">

                            <div>
                                <a href="{{ route('education.show', $item->id) }}"
                                    class="fw-semibold text-dark text-decoration-none">
                                    {{ Str::limit($item->title, 45) }}
                                </a>

                                <div class="text-muted small">
                                    {{ $item->category }}
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