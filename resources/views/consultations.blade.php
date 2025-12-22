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

    /* FEEDBACK SECTION */
    .feedback-section {
        background-color: #f0e6ff;
        padding: 40px 0;
        margin-top: 40px;
        border-top: 2px solid #e1d5f5;
    }
    
    .feedback-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .feedback-header h2 {
        color: #6a3093;
        font-size: 2rem;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .feedback-header p {
        color: #777;
        font-size: 1.1rem;
    }
    
    .feedback-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }
    
    @media (max-width: 768px) {
        .feedback-container {
            grid-template-columns: 1fr;
        }
    }
    
    .feedback-form-container, .feedback-list-container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(106, 48, 147, 0.1);
    }
    
    .feedback-form-container h3, .feedback-list-container h3 {
        color: #6a3093;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0e6ff;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .rating-stars {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 5px;
        margin-top: 10px;
    }
    
    .rating-stars input {
        display: none;
    }
    
    .rating-stars label {
        font-size: 1.5rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #ffc107;
    }
    
    .btn-submit-feedback {
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
    
    .btn-submit-feedback:hover {
        background: linear-gradient(135deg, #6a3093, #8a4dcc);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(106, 48, 147, 0.4);
    }
    
    .feedback-list {
        max-height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }
    
    .feedback-item {
        background: #f9f5ff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid #8a4dcc;
        position: relative;
    }
    
    .feedback-item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
    }
    
    .feedbacker-info {
        flex: 1;
    }
    
    .feedbacker-info h4 {
        margin: 0 0 5px 0;
        color: #6a3093;
        font-size: 1.1rem;
    }
    
    .feedback-rating {
        color: #ffc107;
        margin-bottom: 5px;
    }
    
    .feedback-date {
        color: #888;
        font-size: 0.9rem;
        margin-top: 5px;
    }
    
    .feedback-text {
        color: #555;
        line-height: 1.5;
        margin: 10px 0 0 0;
        padding-right: 40px;
    }
    
    .delete-feedback {
        position: absolute;
        top: 20px;
        right: 20px;
        background: none;
        border: none;
        color: #c53030;
        cursor: pointer;
        font-size: 1rem;
        opacity: 0.7;
        transition: opacity 0.3s;
        padding: 5px;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .delete-feedback:hover {
        opacity: 1;
        background-color: rgba(197, 48, 48, 0.1);
    }
    
    .badge-source {
        display: inline-block;
        background: #e1d5f5;
        color: #6a3093;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        margin-left: 10px;
        vertical-align: middle;
    }
    
    .loading-feedback {
        text-align: center;
        padding: 40px;
        color: #6a3093;
    }
    
    .loading-feedback .fa-spinner {
        font-size: 2rem;
        margin-bottom: 15px;
    }
    
    .error-feedback {
        text-align: center;
        padding: 30px;
        background: #fde8e8;
        border-radius: 10px;
        color: #c53030;
    }
    
    .error-feedback small {
        display: block;
        margin: 10px 0;
        color: #777;
        font-size: 0.9rem;
    }
    
    .btn-retry {
        background: #6a3093;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 15px;
        font-size: 0.9rem;
    }
    
    .btn-retry:hover {
        background: #8a4dcc;
    }
    
    .empty-feedback {
        text-align: center;
        padding: 30px;
        color: #888;
    }
    
    .empty-feedback i {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    
    .feedback-list::-webkit-scrollbar {
        width: 8px;
    }
    
    .feedback-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .feedback-list::-webkit-scrollbar-thumb {
        background: #8a4dcc;
        border-radius: 10px;
    }
    
    .feedback-list::-webkit-scrollbar-thumb:hover {
        background: #6a3093;
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
                <form method="POST" action="{{ route('consultations.store') }}">
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
                        <p>Buka Setiap hari</p>
                        <p>08:00 - 20:00 WIB</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-text">
                        <h3>Lokasi Klinik</h3>
                        <p>l. Tj. Pura No.15, Karanganyar, Indramayu</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <div class="info-text">
                        <h3>Kontak Darurat</h3>
                        <p>Telepon: (021) 7654-3210</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="info-text">
                        <h3>Layanan Unggulan</h3>
                        <p>Rawat inap 24 jam, vaksinasi, konsultasi umum, operasi, pemeriksaan lab, scalling gigi, dan penitipan hewan.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FEEDBACK SECTION -->
        <div class="feedback-section">
            <div class="container">
                <div class="feedback-header">
                    <h2><i class="fas fa-comments"></i> Ulasan & Testimoni</h2>
                    <p>Bagikan pengalaman Anda menggunakan layanan kami</p>
                </div>
                
                <div class="feedback-container">
                    <!-- Form Feedback -->
                    <div class="feedback-form-container">
                        <h3><i class="fas fa-edit"></i> Beri Ulasan</h3>
                        <form id="feedbackForm">
                            <div class="form-group">
                                <label for="feedbackName">Nama Anda</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-user"></i>
                                    <input type="text" id="feedbackName" name="name" placeholder="Masukkan nama Anda" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Rating</label>
                                <div class="rating-stars">
                                    <input type="radio" id="star5" name="rating" value="5">
                                    <label for="star5"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star4" name="rating" value="4">
                                    <label for="star4"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star3" name="rating" value="3">
                                    <label for="star3"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star2" name="rating" value="2">
                                    <label for="star2"><i class="fas fa-star"></i></label>
                                    <input type="radio" id="star1" name="rating" value="1">
                                    <label for="star1"><i class="fas fa-star"></i></label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="feedbackMessage">Ulasan Anda</label>
                                <div class="input-with-icon">
                                    <i class="fas fa-comment"></i>
                                    <textarea id="feedbackMessage" name="message" placeholder="Bagikan pengalaman Anda menggunakan layanan klinik kami..." required></textarea>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn-submit-feedback">
                                <i class="fas fa-paper-plane"></i> Kirim Ulasan
                            </button>
                        </form>
                    </div>
                    
                    <!-- Daftar Feedback -->
                    <div class="feedback-list-container">
                        <h3><i class="fas fa-list"></i> Ulasan Pelanggan</h3>
                        <div id="feedbackList" class="feedback-list">
                            <div class="loading-feedback">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Memuat ulasan...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Elemen DOM
    const feedbackForm = document.getElementById('feedbackForm');
    const feedbackList = document.getElementById('feedbackList');
    
    // URLs dari route Laravel
    const feedbackStoreUrl = '{{ route("feedback.consultation.store") }}';
    const feedbackIndexUrl = '{{ route("feedback.index") }}';
    const feedbackDeleteUrl = '{{ route("feedback.destroy", ":id") }}';
    
    console.log('Feedback System Initialized');
    console.log('Store URL:', feedbackStoreUrl);
    console.log('Index URL:', feedbackIndexUrl);

    // ============================================
    // FUNGSI UNTUK MEMUAT FEEDBACK
    // ============================================
    function loadFeedbacks() {
        console.log('Memuat feedback dari:', feedbackIndexUrl);
        
        // Tampilkan loading
        feedbackList.innerHTML = `
            <div class="loading-feedback">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Memuat ulasan...</p>
            </div>
        `;
        
        // Fetch data dari server
        fetch(feedbackIndexUrl, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(feedbacks => {
            console.log('Feedback diterima:', feedbacks);
            updateFeedbackList(feedbacks);
        })
        .catch(error => {
            console.error('Error loading feedbacks:', error);
            
            feedbackList.innerHTML = `
                <div class="error-feedback">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Gagal memuat ulasan</p>
                    <small>${error.message}</small>
                    <button onclick="window.loadFeedbacks()" class="btn-retry">
                        <i class="fas fa-redo"></i> Coba Lagi
                    </button>
                </div>
            `;
        });
    }
    
    // ============================================
    // FUNGSI UNTUK UPDATE DAFTAR FEEDBACK
    // ============================================
    function updateFeedbackList(feedbacks) {
        // Kosongkan list
        feedbackList.innerHTML = '';
        
        // Cek jika feedback kosong atau bukan array
        if (!feedbacks || !Array.isArray(feedbacks)) {
            console.error('Data feedback tidak valid:', feedbacks);
            
            feedbackList.innerHTML = `
                <div class="empty-feedback">
                    <i class="fas fa-comment-slash"></i>
                    <p>Belum ada ulasan. Jadilah yang pertama!</p>
                </div>
            `;
            return;
        }
        
        // Jika tidak ada feedback
        if (feedbacks.length === 0) {
            feedbackList.innerHTML = `
                <div class="empty-feedback">
                    <i class="fas fa-comment-slash"></i>
                    <p>Belum ada ulasan. Jadilah yang pertama!</p>
                </div>
            `;
            return;
        }
        
        // Loop melalui feedback dan buat elemen
        feedbacks.forEach(feedback => {
            const feedbackItem = createFeedbackElement(feedback);
            feedbackList.appendChild(feedbackItem);
        });
    }
    
    // ============================================
    // FUNGSI UNTUK MEMBUAT ELEMEN FEEDBACK
    // ============================================
    function createFeedbackElement(feedback) {
        const feedbackItem = document.createElement('div');
        feedbackItem.className = 'feedback-item';
        feedbackItem.dataset.id = feedback.id;
        
        // Format tanggal
        const date = new Date(feedback.created_at);
        const formattedDate = date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        // Buat bintang rating
        const starsHtml = createStarsHtml(feedback.rating);
        
        // Tampilkan sumber feedback
        const sourceBadge = feedback.source === 'after_service' 
            ? '<span class="badge-source">📋 Dari Layanan</span>' 
            : '<span class="badge-source">💬 Dari Konsultasi</span>';
        
        // HTML untuk feedback item
        feedbackItem.innerHTML = `
            <div class="feedback-item-header">
                <div class="feedbacker-info">
                    <h4>${feedback.name}</h4>
                    <div class="feedback-rating">${starsHtml}</div>
                    ${sourceBadge}
                </div>
                <button class="delete-feedback" data-id="${feedback.id}" title="Hapus ulasan">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <p class="feedback-text">${feedback.message}</p>
            <div class="feedback-footer">
                <small class="feedback-date">${formattedDate}</small>
            </div>
        `;
        
        // Tambahkan event listener untuk tombol hapus
        const deleteBtn = feedbackItem.querySelector('.delete-feedback');
        deleteBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            deleteFeedback(feedback.id);
        });
        
        return feedbackItem;
    }
    
    // ============================================
    // FUNGSI UNTUK MEMBUAT BINTANG RATING
    // ============================================
    function createStarsHtml(rating) {
        let starsHtml = '';
        for (let i = 1; i <= 5; i++) {
            starsHtml += i <= rating 
                ? '<i class="fas fa-star"></i>' 
                : '<i class="far fa-star"></i>';
        }
        return starsHtml;
    }
    
    // ============================================
    // FUNGSI UNTUK MENGHAPUS FEEDBACK
    // ============================================
    function deleteFeedback(feedbackId) {
        if (!confirm('Apakah Anda yakin ingin menghapus ulasan ini?')) {
            return;
        }
        
        const deleteUrl = feedbackDeleteUrl.replace(':id', feedbackId);
        const feedbackItem = document.querySelector(`.feedback-item[data-id="${feedbackId}"]`);
        
        // Tampilkan loading di item yang akan dihapus
        if (feedbackItem) {
            feedbackItem.style.opacity = '0.5';
        }
        
        // Kirim request DELETE
        fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hapus dari DOM
                if (feedbackItem) {
                    feedbackItem.remove();
                }
                
                // Jika tidak ada feedback lagi, tampilkan pesan
                if (feedbackList.children.length === 0) {
                    feedbackList.innerHTML = `
                        <div class="empty-feedback">
                            <i class="fas fa-comment-slash"></i>
                            <p>Belum ada ulasan. Jadilah yang pertama!</p>
                        </div>
                    `;
                }
                
                alert('Ulasan berhasil dihapus!');
            } else {
                alert('Gagal menghapus ulasan: ' + (data.message || 'Unknown error'));
                if (feedbackItem) {
                    feedbackItem.style.opacity = '1';
                }
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Terjadi kesalahan jaringan. Coba lagi.');
            if (feedbackItem) {
                feedbackItem.style.opacity = '1';
            }
        });
    }
    
    // ============================================
    // HANDLE FORM SUBMISSION
    // ============================================
    feedbackForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Ambil data dari form
        const name = document.getElementById('feedbackName').value.trim();
        const message = document.getElementById('feedbackMessage').value.trim();
        const ratingInput = document.querySelector('input[name="rating"]:checked');
        
        // Validasi
        if (!name || !message || !ratingInput) {
            alert('Silakan lengkapi semua field!');
            return;
        }
        
        const rating = parseInt(ratingInput.value);
        
        // Buat data untuk dikirim
        const formData = {
            name: name,
            rating: rating,
            message: message
        };
        
        console.log('Mengirim feedback:', formData);
        
        // Ambil tombol submit
        const submitBtn = feedbackForm.querySelector('.btn-submit-feedback');
        const originalText = submitBtn.innerHTML;
        
        // Tampilkan loading di tombol
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        submitBtn.disabled = true;
        
        // Kirim ke server
        fetch(feedbackStoreUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            
            if (data.success) {
                // Success - reset form
                feedbackForm.reset();
                
                // Reset rating stars
                document.querySelectorAll('input[name="rating"]').forEach(radio => {
                    radio.checked = false;
                });
                
                // Tampilkan pesan sukses
                alert('Terima kasih atas ulasan Anda! ✅');
                
                // Muat ulang daftar feedback
                loadFeedbacks();
            } else {
                // Tampilkan error
                if (data.errors) {
                    let errorMessages = '';
                    Object.values(data.errors).forEach(errors => {
                        errorMessages += errors.join('\n') + '\n';
                    });
                    alert('Validasi gagal:\n' + errorMessages);
                } else {
                    alert('Gagal mengirim ulasan: ' + (data.message || 'Unknown error'));
                }
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Terjadi kesalahan jaringan. Coba lagi.');
        })
        .finally(() => {
            // Reset tombol
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // ============================================
    // INISIALISASI
    // ============================================
    
    // Muat feedback saat halaman dimuat
    loadFeedbacks();
    
    // Auto refresh setiap 30 detik
    setInterval(loadFeedbacks, 30000);
    
    // Expose fungsi ke window untuk debugging
    window.loadFeedbacks = loadFeedbacks;
});
</script>
@endsection