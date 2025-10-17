@extends('layouts.app')

@section('title', 'Buat Janji Temu - DV Pets')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-purple text-white">
                    <h4 class="mb-0">Buat Janji Temu dengan Dokter Hewan</h4>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('appointments.store') }}" method="POST">
                        @csrf
                        
                        <!-- Data Pemilik -->
                        <h5 class="text-purple mb-3">Data Pemilik</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_pemilik" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" 
                                           value="{{ old('nama_pemilik') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon" class="form-label">Nomor Telepon *</label>
                                    <input type="tel" class="form-control" id="telepon" name="telepon" 
                                           value="{{ old('telepon') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Data Hewan -->
                        <h5 class="text-purple mb-3">Data Hewan Peliharaan</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_hewan" class="form-label">Nama Hewan *</label>
                                    <input type="text" class="form-control" id="nama_hewan" name="nama_hewan" 
                                           value="{{ old('nama_hewan') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_hewan" class="form-label">Jenis Hewan *</label>
                                    <select class="form-control" id="jenis_hewan" name="jenis_hewan" required>
                                        <option value="">Pilih Jenis Hewan</option>
                                        <option value="Anjing" {{ old('jenis_hewan') == 'Anjing' ? 'selected' : '' }}>Anjing</option>
                                        <option value="Kucing" {{ old('jenis_hewan') == 'Kucing' ? 'selected' : '' }}>Kucing</option>
                                        <option value="Burung" {{ old('jenis_hewan') == 'Burung' ? 'selected' : '' }}>Burung</option>
                                        <option value="Kelinci" {{ old('jenis_hewan') == 'Kelinci' ? 'selected' : '' }}>Kelinci</option>
                                        <option value="Hamster" {{ old('jenis_hewan') == 'Hamster' ? 'selected' : '' }}>Hamster</option>
                                        <option value="Lainnya" {{ old('jenis_hewan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ras" class="form-label">Ras *</label>
                                    <input type="text" class="form-control" id="ras" name="ras" 
                                           value="{{ old('ras') }}" required placeholder="Contoh: Persian, Golden Retriever">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="umur" class="form-label">Umur (bulan/tahun) *</label>
                                    <input type="number" class="form-control" id="umur" name="umur" 
                                           value="{{ old('umur') }}" required min="0">
                                </div>
                            </div>
                        </div>

                        <!-- Detail Janji Temu -->
                        <h5 class="text-purple mb-3">Detail Janji Temu</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dokter" class="form-label">Pilih Dokter *</label>
                                    <select class="form-control" id="dokter" name="dokter" required>
                                        <option value="">Pilih Dokter</option>
                                        @foreach($doctors as $key => $doctor)
                                            <option value="{{ $key }}" {{ old('dokter') == $key ? 'selected' : '' }}>
                                                {{ $doctor }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="layanan" class="form-label">Jenis Layanan *</label>
                                    <select class="form-control" id="layanan" name="layanan" required>
                                        <option value="">Pilih Layanan</option>
                                        @foreach($services as $key => $service)
                                            <option value="{{ $key }}" {{ old('layanan') == $key ? 'selected' : '' }}>
                                                {{ $service }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_jam" class="form-label">Tanggal & Jam *</label>
                                    <input type="datetime-local" class="form-control" id="tanggal_jam" name="tanggal_jam" 
                                           value="{{ old('tanggal_jam') }}" required min="{{ date('Y-m-d\TH:i') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="keluhan" class="form-label">Keluhan atau Gejala *</label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="4" 
                                      placeholder="Jelaskan keluhan atau gejala yang dialami hewan peliharaan Anda..." 
                                      required>{{ old('keluhan') }}</textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary me-md-2">Kembali</a>
                            <button type="submit" class="btn btn-purple">Buat Janji Temu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-purple {
    background-color: #6f42c1;
}
.text-purple {
    color: #6f42c1;
}
.btn-purple {
    background-color: #6f42c1;
    border-color: #6f42c1;
    color: white;
}
.btn-purple:hover {
    background-color: #5a32a3;
    border-color: #5a32a3;
    color: white;
}
</style>
@endsection