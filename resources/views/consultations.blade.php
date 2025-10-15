@extends('layouts.app')

@section('title', 'Konsultasi')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .consultation-container {
        background-color: #f8f5ff;
        color: #333;
        line-height: 1.6;
        padding: 40px 0;
        min-height: calc(100vh - 160px);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .main-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }

    @media (max-width: 768px) {
        .main-content {
            grid-template-columns: 1fr;
        }
    }

    .form-container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(106, 48, 147, 0.1);
    }

    .form-title {
        color: #6a3093;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0e6ff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-title i {
        font-size: 1.5rem;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
    }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #8a4dcc;
    }

    input, textarea, select {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 2px solid #e1d5f5;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #8a4dcc;
        outline: none;
        box-shadow: 0 0 0 3px rgba(138, 77, 204, 0.2);
    }

    textarea {
        min-height: 120px;
        resize: vertical;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-top: 10px;
    }

    @media (max-width: 480px) {
        .services-grid {
            grid-template-columns: 1fr;
        }
    }

    .service-option {
        position: relative;
    }

    .service-option input {
        display: none;
    }

    .service-label {
        display: block;
        padding: 15px;
        background: #f9f5ff;
        border: 2px solid #e1d5f5;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .service-option input:checked + .service-label {
        background: #6a3093;
        color: white;
        border-color: #6a3093;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(106, 48, 147, 0.3);
    }

    .service-icon {
        font-size: 1.5rem;
        margin-bottom: 8px;
        display: block;
    }

    .btn-submit {
        background: linear-gradient(135deg, #8a4dcc, #6a3093);
        color: white;
        border: none;
        padding: 14px 25px;
        font-size: 1.1rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #6a3093, #8a4dcc);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(106, 48, 147, 0.4);
    }

    .info-container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(106, 48, 147, 0.1);
    }

    .info-title {
        color: #6a3093;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0e6ff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .info-title i {
        font-size: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        margin-bottom: 25px;
    }

    .info-icon {
        background: #f0e6ff;
        color: #6a3093;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-text h3 {
        color: #6a3093;
        margin-bottom: 5px;
    }

    .alert {
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-success {
        background-color: #e6f7ee;
        color: #2d8f5d;
        border-left: 4px solid #2d8f5d;
    }

    .alert-error {
        background-color: #fde8e8;
        color: #c53030;
        border-left: 4px solid #c53030;
    }

    .pet-decoration {
        text-align: center;
        margin: 20px 0 40px;
    }

    .pet-decoration i {
        font-size: 2rem;
        color: #8a4dcc;
        margin: 0 10px;
    }
    
    .page-title {
        text-align: center;
        margin-bottom: 30px;
        color: #6a3093;
    }
    
    .page-title h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .page-title p {
        font-size: 1.2rem;
        color: #777;
    }
</style>

<div class="consultation-container">
    <div class="container">
        <div class="page-title">
            <h1>Konsultasi & Kontak</h1>
            <p>Hubungi kami untuk konsultasi mengenai hewan peliharaan Anda</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> 
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="pet-decoration">
            <i class="fas fa-cat"></i>
            <i class="fas fa-dog"></i>
            <i class="fas fa-heart"></i>
            <i class="fas fa-dove"></i>
            <i class="fas fa-kiwi-bird"></i>
        </div>

        <div class="main-content">
            <div class="form-container">
                <h2 class="form-title"><i class="fas fa-edit"></i> Form Konsultasi</h2>
                <form method="POST" action="{{ route('consultations') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Alamat Email</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Nomor Telepon/WhatsApp</label>
                        <div class="input-with-icon">
                            <i class="fas fa-phone"></i>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="pet_type">Jenis Hewan Peliharaan</label>
                        <div class="input-with-icon">
                            <i class="fas fa-paw"></i>
                            <select id="pet_type" name="pet_type" required>
                                <option value="">-- Pilih Jenis Hewan --</option>
                                <option value="kucing" {{ old('pet_type') == 'kucing' ? 'selected' : '' }}>Kucing</option>
                                <option value="anjing" {{ old('pet_type') == 'anjing' ? 'selected' : '' }}>Anjing</option>
                                <option value="burung" {{ old('pet_type') == 'burung' ? 'selected' : '' }}>Burung</option>
                                <option value="kelinci" {{ old('pet_type') == 'kelinci' ? 'selected' : '' }}>Kelinci</option>
                                <option value="hamster" {{ old('pet_type') == 'hamster' ? 'selected' : '' }}>Hamster</option>
                                <option value="lainnya" {{ old('pet_type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Layanan yang Diinginkan</label>
                        <div class="services-grid">
                            <div class="service-option">
                                <input type="checkbox" id="service1" name="services[]" value="rawat-inap" {{ is_array(old('services')) && in_array('rawat-inap', old('services')) ? 'checked' : '' }}>
                                <label for="service1" class="service-label">
                                    <i class="fas fa-procedures service-icon"></i>
                                    Rawat Inap
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service2" name="services[]" value="vaksinasi" {{ is_array(old('services')) && in_array('vaksinasi', old('services')) ? 'checked' : '' }}>
                                <label for="service2" class="service-label">
                                    <i class="fas fa-syringe service-icon"></i>
                                    Vaksinasi
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service3" name="services[]" value="konsultasi-umum" {{ is_array(old('services')) && in_array('konsultasi-umum', old('services')) ? 'checked' : '' }}>
                                <label for="service3" class="service-label">
                                    <i class="fas fa-stethoscope service-icon"></i>
                                    Konsultasi Umum
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service4" name="services[]" value="grooming" {{ is_array(old('services')) && in_array('grooming', old('services')) ? 'checked' : '' }}>
                                <label for="service4" class="service-label">
                                    <i class="fas fa-bath service-icon"></i>
                                    Grooming
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service5" name="services[]" value="operasi" {{ is_array(old('services')) && in_array('operasi', old('services')) ? 'checked' : '' }}>
                                <label for="service5" class="service-label">
                                    <i class="fas fa-cut service-icon"></i>
                                    Operasi
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service6" name="services[]" value="pemeriksaan-lab" {{ is_array(old('services')) && in_array('pemeriksaan-lab', old('services')) ? 'checked' : '' }}>
                                <label for="service6" class="service-label">
                                    <i class="fas fa-microscope service-icon"></i>
                                    Pemeriksaan Lab
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service7" name="services[]" value="dental-care" {{ is_array(old('services')) && in_array('dental-care', old('services')) ? 'checked' : '' }}>
                                <label for="service7" class="service-label">
                                    <i class="fas fa-tooth service-icon"></i>
                                    Perawatan Gigi
                                </label>
                            </div>
                            <div class="service-option">
                                <input type="checkbox" id="service8" name="services[]" value="penitipan" {{ is_array(old('services')) && in_array('penitipan', old('services')) ? 'checked' : '' }}>
                                <label for="service8" class="service-label">
                                    <i class="fas fa-home service-icon"></i>
                                    Penitipan
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Pesan Konsultasi</label>
                        <div class="input-with-icon">
                            <i class="fas fa-comment-dots"></i>
                            <textarea id="message" name="message" placeholder="Jelaskan keluhan atau pertanyaan Anda mengenai hewan peliharaan..." required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Konsultasi
                    </button>
                </form>
            </div>
            
            <div class="info-container">
                <h2 class="info-title"><i class="fas fa-info-circle"></i> Informasi Klinik</h2>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-text">
                        <h3>Jam Operasional</h3>
                        <p>Senin - Jumat: 08:00 - 20:00 WIB</p>
                        <p>Sabtu - Minggu: 09:00 - 17:00 WIB</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-text">
                        <h3>Lokasi Klinik</h3>
                        <p>Jl. Kesehatan Hewan No. 123</p>
                        <p>Jakarta Selatan, 12560</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-text">
                        <h3>Kontak Darurat</h3>
                        <p>Telepon: (021) 7654-3210</p>
                        <p>WhatsApp: 0812-3456-7890</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="info-text">
                        <h3>Layanan Unggulan</h3>
                        <p>Rawat inap 24 jam, vaksinasi, konsultasi umum, grooming, operasi, pemeriksaan lab, perawatan gigi, dan penitipan hewan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection