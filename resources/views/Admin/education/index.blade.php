@extends('admin.layouts.app')

@section('title', 'Kelola Edukasi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Edukasi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.education.create') }}" class="btn btn-purple">
            <i class="fas fa-plus me-2"></i>Tambah Edukasi
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card card-purple">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($educations as $education)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $education->thumbnail_url }}" alt="{{ $education->title }}" 
                                 class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td>
                            <strong>{{ $education->title }}</strong>
                            @if($education->description)
                                <br><small class="text-muted">{{ Str::limit($education->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $education->category_color }}">
                                {{ $education->category }}
                            </span>
                        </td>
                        <td>
                            <i class="{{ $education->type_icon }} me-1"></i>
                            {{ ucfirst($education->type) }}
                        </td>
                        <td>
                            @if($education->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.education.edit', $education->id) }}" 
                                   class="btn btn-sm btn-outline-purple">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.education.destroy', $education->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus edukasi ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data edukasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection