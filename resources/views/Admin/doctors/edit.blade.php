@extends('admin.layouts.app')

@section('title', 'Edit Dokter')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Dokter</h1>
</div>

<div class="card card-purple">
    <div class="card-body">
        <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Dokter</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $doctor->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Dokter (untuk Login)</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $doctor->email) }}" required>
                        <div class="form-text text-muted">Gunakan email yang sama dengan yang didaftarkan akun di aplikasi.</div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="specialization" class="form-label">Spesialisasi</label>
                        <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                               id="specialization" name="specialization" value="{{ old('specialization', $doctor->specialization) }}">
                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="schedule" class="form-label">Jadwal Praktek</label>
                <input type="text" class="form-control @error('schedule') is-invalid @enderror" 
                       id="schedule" name="schedule" value="{{ old('schedule', $doctor->schedule) }}" required>
                @error('schedule')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Foto Dokter</label>
                @if($doctor->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $doctor->photo) }}" 
                             alt="{{ $doctor->name }}" 
                             class="rounded" 
                             style="width: 150px; height: 150px; object-fit: cover;"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-doctor.jpg') }}'">
                    </div>
                @endif
                <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                       id="photo" name="photo" accept="image/*">
                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Biarkan kosong jika tidak ingin mengubah foto.</div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $doctor->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-purple">Update Dokter</button>
            </div>
        </form>
    </div>
</div>
@endsection