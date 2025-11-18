@extends('admin.layouts.app')

@section('title', 'Tambah Edukasi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Edukasi Baru</h1>
</div>

<div class="card card-purple">
    <div class="card-body">
        <form action="{{ route('admin.education.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Edukasi</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-control @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="kesehatan" {{ old('category') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="perilaku" {{ old('category') == 'perilaku' ? 'selected' : '' }}>Perilaku</option>
                            <option value="nutrisi" {{ old('category') == 'nutrisi' ? 'selected' : '' }}>Nutrisi</option>
                            <option value="grooming" {{ old('category') == 'grooming' ? 'selected' : '' }}>Grooming</option>
                            <option value="training" {{ old('category') == 'training' ? 'selected' : '' }}>Training</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="type" class="form-label">Tipe Konten</label>
                        <select class="form-control @error('type') is-invalid @enderror" 
                                id="type" name="type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video Edukasi</option>
                            <option value="guide" {{ old('type') == 'guide' ? 'selected' : '' }}>Panduan Lengkap</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="level" class="form-label">Level</label>
                        <select class="form-control @error('level') is-invalid @enderror" 
                                id="level" name="level">
                            <option value="">Pilih Level</option>
                            <option value="Pemula" {{ old('level') == 'Pemula' ? 'selected' : '' }}>Pemula</option>
                            <option value="Menengah" {{ old('level') == 'Menengah' ? 'selected' : '' }}>Menengah</option>
                            <option value="Lanjutan" {{ old('level') == 'Lanjutan' ? 'selected' : '' }}>Lanjutan</option>
                        </select>
                        @error('level')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Singkat</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Konten Lengkap</label>
                <textarea class="form-control @error('content') is-invalid @enderror" 
                          id="content" name="content" rows="6" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" 
                               id="thumbnail" name="thumbnail" accept="image/*">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="reading_time" class="form-label">Waktu Baca/Tonton</label>
                        <input type="text" class="form-control @error('reading_time') is-invalid @enderror" 
                               id="reading_time" name="reading_time" value="{{ old('reading_time') }}"
                               placeholder="Contoh: 10 min read atau 8:30 duration">
                        @error('reading_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="video-fields" style="display: none;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="video_url" class="form-label">URL Video</label>
                            <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                   id="video_url" name="video_url" value="{{ old('video_url') }}"
                                   placeholder="https://youtube.com/embed/...">
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Durasi Video</label>
                            <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" name="duration" value="{{ old('duration') }}"
                                   placeholder="Contoh: 8:30">
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" 
                       {{ old('is_published') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_published">Publikasi Sekarang</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.education.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-purple">Simpan Edukasi</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const videoFields = document.getElementById('video-fields');
    
    function toggleVideoFields() {
        if (typeSelect.value === 'video') {
            videoFields.style.display = 'block';
        } else {
            videoFields.style.display = 'none';
        }
    }
    
    typeSelect.addEventListener('change', toggleVideoFields);
    toggleVideoFields(); // Initial check
});
</script>
@endsection