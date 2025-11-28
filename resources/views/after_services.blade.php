@extends('layouts.app')

@section('title', 'Beri Rating - Klinik Hewan')

@section('content')
<div class="feedback-after-service">
    <div class="feedback-card">
        
        {{-- <form id="afterServiceFeedbackForm" method="POST" action="{{ url('/feedback') }}"> --}}
            @csrf
            <input type="hidden" name="service_type" value="{{ $service_type ?? '' }}">
            <input type="hidden" name="transaction_id" value="{{ $transaction_id ?? '' }}">
            
            <div class="rating-section">
                <h3>Bagaimana pengalaman Anda?</h3>
                <p>Beri rating untuk layanan yang baru saja Anda gunakan</p>
                
                <div class="rating-stars">
                    <input type="radio" id="star5-after" name="rating" value="5" required>
                    <label for="star5-after"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" id="star4-after" name="rating" value="4">
                    <label for="star4-after"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" id="star3-after" name="rating" value="3">
                    <label for="star3-after"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" id="star2-after" name="rating" value="2">
                    <label for="star2-after"><i class="fas fa-star"></i></label>
                    
                    <input type="radio" id="star1-after" name="rating" value="1">
                    <label for="star1-after"><i class="fas fa-star"></i></label>
                </div>
                
                <div class="rating-labels">
                    <span class="label-clickable" data-rating="1">Tidak Puas</span>
                    <span class="label-clickable" data-rating="5">Sangat Puas</span>
                </div>
            </div>
            
            <div class="form-group" style="text-align: left; margin: 25px 0;">
                <label for="feedback_message" style="display: block; margin-bottom: 10px; color: #555; font-weight: 500;">
                    <i class="fas fa-comment"></i> Ulasan Anda (opsional)
                </label>
                <textarea 
                    id="feedback_message" 
                    name="message" 
                    class="form-control" 
                    rows="4" 
                    placeholder="Bagikan pengalaman Anda menggunakan layanan ini..."
                    style="width: 100%; padding: 15px; border: 2px solid #e1d5f5; border-radius: 10px; resize: vertical; font-family: inherit;"
                ></textarea>
            </div>
            
            <button type="button" class="btn-submit-feedback"
                onclick="alert('Ulasan berhasil dikirim! ❤️'); window.location.href='/';">
                <i class="fas fa-paper-plane"></i> Kirim Ulasan 
            </button>

            
            <a href="{{ url('/') }}" class="skip-feedback">
                Lewati, beri rating nanti
            </a>
        </form>
    </div>
</div>

<style>
    .rating-labels {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    color: #888;
    font-size: 0.9rem;
}

.label-clickable {
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.label-clickable:hover {
    background-color: #f0f0f0;
    color: #6a3093;
}

.label-clickable.active {
    background-color: #6a3093;
    color: white;
}
    .feedback-after-service {
        background: linear-gradient(135deg, #f8f5ff, #e6f7ff);
        min-height: 100vh;
        padding: 60px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .feedback-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(106, 48, 147, 0.15);
        max-width: 500px;
        width: 100%;
        text-align: center;
    }
    
    .success-icon {
        font-size: 4rem;
        color: #2d8f5d;
        margin-bottom: 20px;
    }
    
    .feedback-title {
        color: #6a3093;
        margin-bottom: 10px;
        font-size: 1.8rem;
    }
    
    .feedback-subtitle {
        color: #666;
        margin-bottom: 30px;
        font-size: 1.1rem;
    }
    
    .service-info {
        background: #f0f9ff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        text-align: left;
    }
    
    .service-info h4 {
        color: #6a3093;
        margin-bottom: 10px;
        font-size: 1.2rem;
    }
    
    .rating-section {
        margin: 30px 0;
    }
    
    .rating-stars {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin: 20px 0;
        flex-direction: row-reverse;
    }
    
    .rating-stars input {
        display: none;
    }
    
    .rating-stars label {
        font-size: 2.5rem;
        color: #ddd;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    /* PERBAIKAN: CSS star rating yang benar */
    .rating-stars input:checked ~ label,
    .rating-stars label:hover,
    .rating-stars label:hover ~ label {
        color: #ffc107;
        transform: scale(1.1);
    }
    
    .rating-stars input:checked + label {
        color: #ffc107;
    }
    
    .rating-labels {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
        color: #888;
        font-size: 0.9rem;
    }
    
    .btn-submit-feedback {
        background: linear-gradient(135deg, #8a4dcc, #6a3093);
        color: white;
        border: none;
        padding: 15px 30px;
        font-size: 1.1rem;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
        width: 100%;
        font-weight: 600;
        margin-top: 20px;
    }
    
    .btn-submit-feedback:hover {
        background: linear-gradient(135deg, #6a3093, #8a4dcc);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(106, 48, 147, 0.3);
    }
    
    .skip-feedback {
        background: transparent;
        color: #666;
        border: 1px solid #ddd;
        padding: 12px 25px;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 15px;
        width: 100%;
        transition: all 0.3s;
        display: inline-block;
        text-decoration: none;
        text-align: center;
    }
    
    .skip-feedback:hover {
        background: #f5f5f5;
        color: #333;
        text-decoration: none;
    }
</style>

<script>
    
    // Handle click pada label rating
const labelClickables = document.querySelectorAll('.label-clickable');
labelClickables.forEach(label => {
    label.addEventListener('click', function() {
        const ratingValue = this.getAttribute('data-rating');
        
        // Set radio button yang sesuai
        const radioButton = document.querySelector(`#star${ratingValue}-after`);
        if (radioButton) {
            radioButton.checked = true;
            
            // Trigger change event untuk update tampilan bintang
            radioButton.dispatchEvent(new Event('change'));
        }
        
        // Add active class ke label yang diklik
        labelClickables.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('afterServiceFeedbackForm');
    const stars = document.querySelectorAll('.rating-stars input');
    const starLabels = document.querySelectorAll('.rating-stars label');
    
    // PERBAIKAN: Handle star selection yang benar
    stars.forEach((star) => {
        star.addEventListener('change', function() {
            const rating = this.value;
            console.log('Rating selected:', rating);
            
            // Hapus class active dari semua label
            starLabels.forEach(label => {
                label.classList.remove('active');
            });
            
            // Tambah class active ke label yang sesuai
            const selectedIndex = Array.from(stars).indexOf(this);
            for (let i = 0; i <= selectedIndex; i++) {
                starLabels[i].classList.add('active');
            }
        });
    });
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        const rating = document.querySelector('input[name="rating"]:checked');
        
        if (!rating) {
            e.preventDefault();
            alert('Silakan beri rating terlebih dahulu');
            return;
        }
        
        // Optional: Add loading state
        const submitBtn = form.querySelector('.btn-submit-feedback');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        submitBtn.disabled = true;
        
        // Data akan otomatis masuk ke halaman konsultasi
        // karena menggunakan route feedback yang sama
    });
    document.getElementById('btnFeedback').addEventListener('click', function() {
    this.innerHTML = '✔️ Berhasil Dikirim';
    this.style.backgroundColor = '#28a745';
    this.style.borderColor = '#28a745';
});
});
</script>
@endsection