@extends('admin.layouts.app')

@section('title', 'Kelola Dokter')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kelola Dokter</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.doctors.create') }}" class="btn btn-purple">
            <i class="fas fa-plus me-2"></i>Tambah Dokter
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
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Dokter</th>
                        <th>Spesialisasi</th>
                        <th>Jadwal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $doctor->photo_url }}" alt="{{ $doctor->name }}" 
                                 class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>{{ $doctor->name }}</td>
                        <td>{{ $doctor->specialization ?? '-' }}</td>
                        <td>{{ $doctor->schedule }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.doctors.edit', $doctor->id) }}" 
                                   class="btn btn-sm btn-outline-purple">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.doctors.destroy', $doctor->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data dokter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection