@extends('layouts.app')

@section('title', 'Beri Rating - Klinik Hewan')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <!-- Header Section -->
            <div class="text-center mb-5">
                <div class="rating-icon-wrapper mb-4">
                    <div class="rating-icon-circle">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                </div>
                <h1 class="fw-bold text-gradient-primary mb-3">Bagikan Pengalaman Anda</h1>
                <p class="lead text-muted px-3">Ulasan Anda membantu kami memberikan pelayanan terbaik untuk hewan kesayangan</p>
            </div>

            <!-- Main Rating Card -->
            <div class="card rating-card border-0 shadow-lg overflow-hidden">
                <!-- Card Header -->
                <div class="card-header-rating bg-gradient-primary text-white py-4 px-5">
                    <div class="d-flex align-items-center">
                        <div class="rating-header-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-1 fw-bold">Berikan Penilaian Layanan</h4>
                            <p class="mb-0 opacity-75">Pengalaman Anda sangat berarti bagi kami</p>
                        </div>
                    </div>
                </div>

                <!-- Card Body -->
                

                    <form id="afterServiceFeedbackForm" method="POST" action="{{ route('feedback.after-service.store') }}" class="p-5">
                        @csrf
                        <input type="hidden" name="service_type" value="{{ $service_type ?? '' }}">
                        <input type="hidden" name="transaction_id" value="{{ $transaction_id ?? '' }}">
                        
                        <!-- User Info Section -->
                        <div class="section-card mb-5">
                            <div class="section-header mb-4">
                                <div class="section-icon">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                                <h5 class="section-title mb-0">Informasi Anda</h5>
                            </div>
                            
                            <div class="floating-input-group">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control floating-input" 
                                        id="feedback_name" 
                                        name="name" 
                                        placeholder="Nama Anda (Opsional)"
                                        value="{{ old('name') }}"
                                    >
                                    <label for="feedback_name">
                                        <i class="fas fa-user me-2"></i>Nama Anda (Opsional)
                                    </label>
                                </div>
                                <div class="form-text mt-2 ps-1">
                                    <i class="fas fa-info-circle me-1"></i> Kosongkan untuk tampil sebagai "Anonymous"
                                </div>
                            </div>
                        </div>

                        <!-- Rating Section -->
                        <div class="section-card mb-5">
                            <div class="section-header mb-4">
                                <div class="section-icon">
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                                <h5 class="section-title mb-0">Penilaian Layanan</h5>
                            </div>
                            
                            <p class="rating-question text-center mb-4 fw-medium text-dark">
                                "Bagaimana pengalaman Anda menggunakan layanan kami?"
                            </p>
                            
                            <!-- Star Rating -->
                            <div class="rating-container mb-4">
                                <div class="star-rating-wrapper">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{$i}}-after" name="rating" value="{{$i}}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                        <label for="star{{$i}}-after" class="star-label">
                                            <i class="fas fa-star"></i>
                                            <span class="star-number">{{$i}}</span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                            
                            <!-- Rating Labels -->
                            <div class="rating-labels-container">
                                <div class="row g-3">
                                    @foreach([
                                        1 => ['icon' => 'fa-frown', 'text' => 'Tidak Puas', 'color' => 'danger'],
                                        2 => ['icon' => 'fa-meh', 'text' => 'Cukup', 'color' => 'warning'],
                                        3 => ['icon' => 'fa-smile', 'text' => 'Puas', 'color' => 'info'],
                                        4 => ['icon' => 'fa-laugh', 'text' => 'Sangat Puas', 'color' => 'success'],
                                        5 => ['icon' => 'fa-grin-hearts', 'text' => 'Luar Biasa', 'color' => 'primary']
                                    ] as $rating => $data)
                                    <div class="col">
                                        <div class="rating-label-card" data-rating="{{ $rating }}">
                                            <div class="rating-label-icon text-{{ $data['color'] }}">
                                                <i class="fas {{ $data['icon'] }} fa-2x"></i>
                                            </div>
                                            <div class="rating-label-text mt-2">
                                                <small class="fw-semibold">{{ $data['text'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Review Section -->
                        <div class="section-card mb-5">
                            <div class="section-header mb-4">
                                <div class="section-icon">
                                    <i class="fas fa-comment-medical"></i>
                                </div>
                                <h5 class="section-title mb-0">Ulasan Anda</h5>
                            </div>
                            
                            <div class="review-box">
                                <div class="form-floating">
                                    <textarea 
                                        class="form-control review-textarea" 
                                        id="feedback_message" 
                                        name="message" 
                                        placeholder="Ceritakan pengalaman Anda"
                                        style="height: 150px"
                                    >{{ old('message') }}</textarea>
                                    <label for="feedback_message">
                                        <i class="fas fa-edit me-2"></i>Bagikan pengalaman Anda (Opsional)
                                    </label>
                                </div>
                                <div class="review-footer mt-3">
                                    <div class="char-progress">
                                        <div class="progress" style="height: 6px;">
                                            <div id="charProgress" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <div class="char-counter d-flex justify-content-between mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-keyboard me-1"></i> Ulasan Anda
                                        </small>
                                        <small>
                                            <span id="charCount">0</span>/500 karakter
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Error Messages -->
                        @if($errors->any())
                        <div class="alert alert-danger alert-elegant mb-4">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="alert-title mb-1">Perhatian</h6>
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li><small>{{ $error }}</small></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="form-actions text-center pt-3">
                            <button type="submit" class="btn btn-submit-rating btn-lg px-5 py-3 mb-3" id="submitBtn">
                                <span class="btn-content">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <span class="btn-text">Kirim Ulasan</span>
                                </span>
                                <span class="btn-loading" style="display: none;">
                                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                    Mengirim...
                                </span>
                            </button>
                            
                            <div class="mt-4">
                                <a href="{{ url('/') }}" class="btn btn-skip-rating">
                                    <i class="fas fa-clock me-2"></i> Beri Rating Nanti
                                </a>
                            </div>
                        </div>

                        <!-- Privacy Note -->
                        <div class="privacy-note mt-5 pt-4 border-top">
                            <div class="d-flex align-items-start">
                                <div class="privacy-icon me-3">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <p class="mb-2 small text-muted">
                                        <strong>Privasi Terjaga:</strong> Ulasan Anda akan ditampilkan secara publik di halaman konsultasi. Kami menghargai privasi dan tidak akan membagikan informasi pribadi Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Success Message (Hidden by default) -->
            <div class="card success-card border-0 shadow-lg mt-4" id="thankYouMessage" style="display: none;">
                <div class="card-body text-center p-5">
                    <div class="success-animation mb-4">
                        <div class="success-circle">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <h2 class="text-gradient-primary mb-3">Ulasan Terkirim!</h2>
                    <p class="text-muted mb-4 px-3">Terima kasih telah meluangkan waktu untuk berbagi pengalaman. Ulasan Anda sangat berharga bagi perkembangan kami.</p>
                    
                    <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
                        <a href="{{ route('consultations') }}" class="btn btn-primary-gradient">
                            <i class="fas fa-eye me-2"></i> Lihat Ulasan Lainnya
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-outline-primary-gradient">
                            <i class="fas fa-home me-2"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Color Variables */
:root {
    --primary-color: #6f42c1;
    --primary-light: #8a63d2;
    --primary-dark: #5a32a3;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --light-bg: #f8f9fa;
    --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}

/* Gradient Backgrounds */
.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
}

.text-gradient-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Header Icon */
.rating-icon-wrapper {
    position: relative;
    display: inline-block;
}

.rating-icon-circle {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    box-shadow: 0 10px 20px rgba(111, 66, 193, 0.3);
}

/* Main Card */
.rating-card {
    border-radius: 20px;
    overflow: hidden;
}

.card-header-rating {
    position: relative;
    overflow: hidden;
}

.card-header-rating::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.rating-header-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

/* Pet Decorations */
.pet-decorations {
    position: absolute;
    width: 100%;
    top: 20px;
    z-index: 1;
}

.pet-icon {
    position: absolute;
    width: 40px;
    height: 40px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    font-size: 1.2rem;
}

.pet-icon-1 { left: 10%; }
.pet-icon-2 { left: 50%; transform: translateX(-50%); }
.pet-icon-3 { right: 10%; }

/* Section Cards */
.section-card {
    background: var(--light-bg);
    border-radius: 15px;
    padding: 25px;
    border: 1px solid rgba(111, 66, 193, 0.1);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 15px;
}

.section-icon {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.section-title {
    color: var(--primary-dark);
    font-weight: 600;
}

/* Floating Input */
.floating-input-group .form-floating {
    position: relative;
}

.floating-input {
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    transition: all 0.3s ease;
    background: white;
}

.floating-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1);
    background: white;
}

.floating-input:focus + label {
    color: var(--primary-color);
}

/* Star Rating */
.star-rating-wrapper {
    display: flex;
    justify-content: center;
    gap: 5px;
    flex-direction: row-reverse;
}

.star-rating-wrapper input {
    display: none;
}

.star-label {
    position: relative;
    width: 60px;
    height: 60px;
    font-size: 2.5rem;
    color: #e0e0e0;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 12px;
    border: 2px solid transparent;
}

.star-label:hover,
.star-label:hover ~ .star-label {
    color: #ffd700;
    border-color: rgba(255, 215, 0, 0.2);
    transform: translateY(-5px);
    background: rgba(255, 215, 0, 0.05);
}

.star-rating-wrapper input:checked ~ .star-label {
    color: #ffd700;
}

.star-rating-wrapper input:checked + .star-label {
    color: #ffd700;
    border-color: rgba(255, 215, 0, 0.3);
    background: rgba(255, 215, 0, 0.1);
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(255, 215, 0, 0.2);
}

.star-number {
    position: absolute;
    bottom: -20px;
    font-size: 0.75rem;
    font-weight: bold;
    color: #666;
}

/* Rating Labels */
.rating-label-card {
    text-align: center;
    padding: 15px 5px;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    background: white;
}

.rating-label-card:hover {
    transform: translateY(-3px);
    border-color: var(--primary-light);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.rating-label-card.active {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border-color: var(--primary-color);
    color: white;
}

.rating-label-card.active .rating-label-icon {
    color: white !important;
}

.rating-label-card.active .rating-label-text small {
    color: white !important;
}

/* Review Box */
.review-box {
    position: relative;
}

.review-textarea {
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 1.5rem;
    resize: none;
    transition: all 0.3s ease;
    background: white;
}

.review-textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1);
    background: white;
}

.char-progress .progress-bar {
    background: linear-gradient(90deg, var(--success-color), var(--primary-color));
    border-radius: 3px;
}

/* Buttons */
.btn-submit-rating {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    padding: 15px 40px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-submit-rating:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(111, 66, 193, 0.3);
    color: white;
}

.btn-submit-rating:disabled {
    opacity: 0.7;
    transform: none;
}

.btn-skip-rating {
    color: #666;
    text-decoration: none;
    transition: all 0.3s ease;
    padding: 10px 20px;
    border-radius: 8px;
}

.btn-skip-rating:hover {
    color: var(--primary-color);
    background: rgba(111, 66, 193, 0.1);
}

.btn-primary-gradient {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    padding: 12px 30px;
    transition: all 0.3s ease;
}

.btn-primary-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(111, 66, 193, 0.3);
    color: white;
}

.btn-outline-primary-gradient {
    border: 2px solid var(--primary-color);
    border-radius: 12px;
    color: var(--primary-color);
    font-weight: 600;
    padding: 12px 30px;
    transition: all 0.3s ease;
}

.btn-outline-primary-gradient:hover {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
    color: white;
    border-color: transparent;
}

/* Alert */
.alert-elegant {
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #fff5f5, #fef2f2);
}

.alert-icon {
    width: 40px;
    height: 40px;
    background: var(--danger-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.alert-title {
    color: var(--danger-color);
    font-weight: 600;
}

/* Privacy Note */
.privacy-note {
    background: rgba(111, 66, 193, 0.05);
    border-radius: 12px;
    padding: 20px;
}

.privacy-icon {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

/* Success Card */
.success-card {
    border-radius: 20px;
    background: linear-gradient(135deg, #f8f9fa, white);
}

.success-animation {
    display: inline-block;
}

.success-circle {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--success-color), #34d399);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 3rem;
    animation: successPulse 2s infinite;
}

@keyframes successPulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
    70% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .rating-icon-circle {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .star-label {
        width: 50px;
        height: 50px;
        font-size: 2rem;
    }
    
    .section-card {
        padding: 20px;
    }
    
    .pet-icon {
        width: 35px;
        height: 35px;
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .rating-icon-circle {
        width: 70px;
        height: 70px;
        font-size: 1.8rem;
    }
    
    .star-label {
        width: 40px;
        height: 40px;
        font-size: 1.5rem;
    }
    
    .btn-submit-rating {
        width: 100%;
        padding: 15px;
    }
    
    .pet-icon {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('afterServiceFeedbackForm');
    const stars = document.querySelectorAll('.star-rating-wrapper input');
    const starLabels = document.querySelectorAll('.star-label');
    const labelCards = document.querySelectorAll('.rating-label-card');
    const textarea = document.getElementById('feedback_message');
    const charCount = document.getElementById('charCount');
    const charProgress = document.getElementById('charProgress');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    const thankYouMessage = document.getElementById('thankYouMessage');
    const feedbackCard = document.querySelector('.rating-card');

    // Karakter counter dengan progress bar
    if (textarea && charCount && charProgress) {
        textarea.addEventListener('input', function() {
            const length = this.value.length;
            const percentage = (length / 500) * 100;
            
            charCount.textContent = length;
            charProgress.style.width = percentage + '%';
            
            // Update progress bar color
            if (length > 500) {
                charCount.style.color = 'var(--danger-color)';
                charProgress.style.background = 'var(--danger-color)';
                this.style.borderColor = 'var(--danger-color)';
            } else if (length > 400) {
                charCount.style.color = 'var(--warning-color)';
                charProgress.style.background = 'var(--warning-color)';
                this.style.borderColor = 'var(--warning-color)';
            } else {
                charCount.style.color = 'var(--primary-color)';
                charProgress.style.background = 'linear-gradient(90deg, var(--success-color), var(--primary-color))';
                this.style.borderColor = '#e0e0e0';
            }
        });
        
        // Initialize count
        charCount.textContent = textarea.value.length;
        charProgress.style.width = (textarea.value.length / 500) * 100 + '%';
    }

    // Handle click pada label rating cards
    labelCards.forEach(card => {
        card.addEventListener('click', function() {
            const ratingValue = this.getAttribute('data-rating');
            const radioButton = document.querySelector(`#star${ratingValue}-after`);
            
            if (radioButton) {
                radioButton.checked = true;
                updateStarDisplay();
                
                // Update card active state
                labelCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
    
    // Update tampilan bintang
    function updateStarDisplay() {
        const selectedRating = document.querySelector('.star-rating-wrapper input[name="rating"]:checked')?.value || 0;
        
        starLabels.forEach((label, index) => {
            const starValue = 5 - index; // Karena flex-direction: row-reverse
            if (starValue <= selectedRating) {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        });
    }
    
    // Handle perubahan rating dari bintang
    stars.forEach((star) => {
        star.addEventListener('change', function() {
            updateStarDisplay();
            
            // Update card active state
            const ratingValue = this.value;
            labelCards.forEach(card => {
                card.classList.remove('active');
                if (card.getAttribute('data-rating') == ratingValue) {
                    card.classList.add('active');
                }
            });
        });
    });
    
    // Initialize star display
    updateStarDisplay();
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validasi
        const rating = document.querySelector('input[name="rating"]:checked');
        
        if (!rating) {
            // Add shake animation to stars
            starLabels.forEach(star => {
                star.style.animation = 'none';
                setTimeout(() => {
                    star.style.animation = 'shake 0.5s ease';
                }, 10);
            });
            
            setTimeout(() => {
                starLabels.forEach(star => {
                    star.style.animation = '';
                });
            }, 500);
            
            return;
        }
        
        // Tampilkan loading state
        const btnContent = submitBtn.querySelector('.btn-content');
        btnContent.style.display = 'none';
        btnLoading.style.display = 'block';
        submitBtn.disabled = true;
        
        // Kirim form dengan AJAX
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || 'Gagal mengirim ulasan');
                });
            }
            return response.json().catch(() => ({ success: true }));
        })
        .then(data => {
            // Success - tampilkan thank you message dengan animasi
            feedbackCard.style.opacity = '0';
            feedbackCard.style.transform = 'translateY(20px)';
            feedbackCard.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                feedbackCard.style.display = 'none';
                thankYouMessage.style.display = 'block';
                thankYouMessage.style.opacity = '0';
                thankYouMessage.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    thankYouMessage.style.opacity = '1';
                    thankYouMessage.style.transform = 'translateY(0)';
                    thankYouMessage.style.transition = 'all 0.5s ease';
                }, 50);
                
                // Scroll ke atas
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 500);
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Reset button
            btnContent.style.display = 'block';
            btnLoading.style.display = 'none';
            submitBtn.disabled = false;
            
            // Show error with animation
            submitBtn.style.background = 'var(--danger-color)';
            setTimeout(() => {
                submitBtn.style.background = 'linear-gradient(135deg, var(--primary-color), var(--primary-light))';
            }, 1000);
        });
    });
    
    // Validasi real-time saat user memilih rating
    stars.forEach(star => {
        star.addEventListener('change', function() {
            if (this.checked) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
            }
        });
    });
    
    // Add CSS for shake animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection