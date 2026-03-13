@extends('admin.layouts.app')

@section('title', 'Detail Edukasi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Edukasi</h1>
</div>

<div class="card card-purple">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset("storage/" . $education->thumbnail_url) }}" alt="{{ $education->title }}" 
                     class="img-fluid rounded mb-3" style="max-height: 300px; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <h3>{{ $education->title }}</h3>
                <p class="text-muted">{{ $education->description }}</p>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Kategori:</strong>
                        <span class="badge bg-{{ $education->category_color }}">
                            {{ $education->category }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Tipe:</strong>
                        <span class="badge bg-purple">
                            <i class="{{ $education->type_icon }} me-1"></i>
                            {{ ucfirst($education->type) }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Level:</strong> {{ $education->level ?? '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        @if($education->is_published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-warning">Draft</span>
                        @endif
                    </div>
                </div>

                @if($education->video_url)
                <div class="mb-3">
                    <strong>URL Video:</strong>
                    <a href="{{ $education->video_url }}" target="_blank">{{ $education->video_url }}</a>
                </div>
                @endif

                @if($education->duration)
                <div class="mb-3">
                    <strong>Durasi:</strong> {{ $education->duration }}
                </div>
                @endif

                @if($education->reading_time)
                <div class="mb-3">
                    <strong>Waktu Baca:</strong> {{ $education->reading_time }}
                </div>
                @endif
            </div>
        </div>

        <div class="mt-4">
            <h5>Konten Lengkap</h5>
            <div class="border p-3 rounded bg-light">
                {!! nl2br(e($education->content)) !!}
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('admin.education.index') }}" class="btn btn-secondary">Kembali</a>
            <div>
                <a href="{{ route('admin.education.edit', $education->id) }}" class="btn btn-purple">Edit</a>
                <form action="{{ route('admin.education.destroy', $education->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus edukasi ini?')">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection