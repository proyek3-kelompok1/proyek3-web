@extends('admin.layouts.app')

@section('title', 'Pesan Masuk - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-inbox me-2"></i>Pesan Masuk & Ulasan Pelanggan
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-purple" id="refreshBtn">
                <i class="fas fa-sync-alt me-1"></i>Refresh
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Pesan</h6>
                        <h2 class="mb-0" id="totalMessages">0</h2>
                    </div>
                    <div class="bg-white text-primary rounded-circle p-3">
                        <i class="fas fa-inbox fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Rating Rata-rata</h6>
                        <h2 class="mb-0" id="averageRating">0.0</h2>
                    </div>
                    <div class="bg-white text-success rounded-circle p-3">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Konsultasi</h6>
                        <h2 class="mb-0" id="totalConsultations">0</h2>
                    </div>
                    <div class="bg-white text-info rounded-circle p-3">
                        <i class="fas fa-comments fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Feedback</h6>
                        <h2 class="mb-0" id="totalFeedbacks">0</h2>
                    </div>
                    <div class="bg-white text-warning rounded-circle p-3">
                        <i class="fas fa-star-half-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card card-purple mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-2">
                <label for="dateFilter" class="form-label fw-bold">Filter Tanggal</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="startDateFilter">
                    <span class="input-group-text">s/d</span>
                    <input type="date" class="form-control" id="endDateFilter">
                </div>
            </div>
            <div class="col-md-2">
                <label for="ratingFilter" class="form-label fw-bold">Filter Rating</label>
                <select class="form-select" id="ratingFilter">
                    <option value="">Semua Rating</option>
                    <option value="0">Tanpa Rating (Konsultasi)</option>
                    <option value="5">★★★★★ (5)</option>
                    <option value="4">★★★★☆ (4)</option>
                    <option value="3">★★★☆☆ (3)</option>
                    <option value="2">★★☆☆☆ (2)</option>
                    <option value="1">★☆☆☆☆ (1)</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="typeFilter" class="form-label fw-bold">Jenis Pesan</label>
                <select class="form-select" id="typeFilter">
                    <option value="">Semua Jenis</option>
                    <option value="konsultasi">Konsultasi</option>
                    <option value="feedback_konsultasi">Feedback Konsultasi</option>
                    <option value="feedback_layanan">Feedback Layanan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sourceFilter" class="form-label fw-bold">Sumber</label>
                <select class="form-select" id="sourceFilter">
                    <option value="">Semua Sumber</option>
                    <option value="consultation">Konsultasi</option>
                    <option value="after_service">Setelah Layanan</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="searchInput" class="form-label fw-bold">Cari</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari nama, email, atau pesan...">
                    <button class="btn btn-purple" type="button" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Pesan -->
<div class="card card-purple">
    <div class="card-header bg-purple text-black d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-table me-2"></i>Daftar Pesan & Ulasan
            <span class="badge bg-light text-purple ms-2" id="filteredCount">0</span>
        </h5>
        <div>
            <button class="btn btn-sm btn-light" id="selectAllBtn" data-bs-toggle="tooltip" title="Pilih Semua">
                <i class="fas fa-check-square"></i>
            </button>
            <button class="btn btn-sm btn-light ms-1" id="deleteSelectedBtn" data-bs-toggle="tooltip" title="Hapus Terpilih">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="1%">
                            <input type="checkbox" id="selectAllCheckbox">
                        </th>
                        <th width="20%">Pelanggan</th>
                        <th width="10%">Rating</th>
                        <th width="30%">Pesan/Ulasan</th>
                        <th width="15%">Jenis</th>
                        <th width="15%">Tanggal</th>
                        <th width="9%">Aksi</th>
                    </tr>
                </thead>
                <tbody id="messagesTable">
                    <!-- Data akan diisi via JavaScript -->
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="spinner-border text-purple" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Memuat pesan...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan <span id="showingFrom">0</span> - <span id="showingTo">0</span> dari <span id="totalCount">0</span> pesan
            </div>
            <nav>
                <ul class="pagination" id="pagination">
                    <!-- Pagination akan di-generate oleh JavaScript -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal View Detail -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-purple text-black">
                <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Detail Pesan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">ID Pesan:</th>
                                <td id="detailId">-</td>
                            </tr>
                            <tr>
                                <th>Nama:</th>
                                <td id="detailName">-</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td id="detailEmail">-</td>
                            </tr>
                            <tr>
                                <th>Telepon:</th>
                                <td id="detailPhone">-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Rating:</th>
                                <td id="detailRating">-</td>
                            </tr>
                            <tr>
                                <th>Jenis Hewan:</th>
                                <td id="detailPetType">-</td>
                            </tr>
                            <tr>
                                <th>Jenis Pesan:</th>
                                <td id="detailSource">-</td>
                            </tr>
                            <tr>
                                <th>Layanan:</th>
                                <td id="detailServices">-</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <h6><i class="fas fa-comment me-2"></i>Pesan/Ulasan:</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            <p id="detailMessage" class="mb-0"></p>
                        </div>
                    </div>
                </div>
                <div id="additionalInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-danger" id="deleteSingleBtn">
                    <i class="fas fa-trash me-1"></i>Hapus
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .message-row:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }
    
    .rating-stars {
        color: #ffc107;
        font-size: 0.9rem;
    }
    
    .message-preview {
        max-width: 400px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .badge-source {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85em;
    }
    
    .badge-konsultasi {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-feedback-konsultasi {
        background-color: #20c997;
        color: white;
    }
    
    .badge-feedback-layanan {
        background-color: #fd7e14;
        color: white;
    }
    
    .card-purple {
        border: 1px solid #6a0dad;
    }
    
    .card-purple .card-header {
        background-color: #6a0dad !important;
    }
    
    .bg-purple {
        background-color: #6a0dad !important;
    }
    
    .text-purple {
        color: #6a0dad !important;
    }
    
    .btn-purple {
        background-color: #6a0dad;
        border-color: #6a0dad;
        color: white;
    }
    
    .btn-purple:hover {
        background-color: #5a0b9d;
        border-color: #5a0b9d;
    }
    
    .btn-outline-purple {
        color: #6a0dad;
        border-color: #6a0dad;
    }
    
    .btn-outline-purple:hover {
        background-color: #6a0dad;
        color: white;
    }
    
    .badge-type {
        font-size: 0.75em;
        padding: 3px 8px;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Global variables
    let allMessages = [];
    let filteredMessages = [];
    let currentPage = 1;
    const perPage = 10;
    let selectedMessages = new Set();
    let currentViewMessageId = null;

    // URLs
    const messagesApiUrl = '{{ route("admin.messages.api") }}';
    const messageDetailUrl = '{{ route("admin.messages.show", ":id") }}';
    const deleteMessageUrl = '{{ route("admin.messages.destroy", ":id") }}';
    const messagesStatsUrl = '{{ route("admin.messages.stats") }}';
    
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    console.log('Admin Messages URLs:');
    console.log('API URL:', messagesApiUrl);
    console.log('Detail URL:', messageDetailUrl);
    console.log('Delete URL:', deleteMessageUrl);
    console.log('Stats URL:', messagesStatsUrl);

    // Elements
    const messagesTable = document.getElementById('messagesTable');
    const totalMessages = document.getElementById('totalMessages');
    const averageRating = document.getElementById('averageRating');
    const totalConsultations = document.getElementById('totalConsultations');
    const totalFeedbacks = document.getElementById('totalFeedbacks');
    const filteredCount = document.getElementById('filteredCount');
    const showingFrom = document.getElementById('showingFrom');
    const showingTo = document.getElementById('showingTo');
    const totalCount = document.getElementById('totalCount');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const additionalInfo = document.getElementById('additionalInfo');

    // ============================================
    // FUNGSI UTAMA: LOAD STATISTIK
    // ============================================
    function loadStats() {
        fetch(messagesStatsUrl, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.total_messages !== undefined) {
                totalMessages.textContent = data.total_messages;
                averageRating.textContent = data.average_rating.toFixed(1);
                totalConsultations.textContent = data.messages_by_type.konsultasi || 0;
                totalFeedbacks.textContent = (data.messages_by_type.feedback_konsultasi || 0) + (data.messages_by_type.feedback_layanan || 0);
            }
        })
        .catch(error => console.error('Error loading stats:', error));
    }

    // ============================================
    // FUNGSI UTAMA: LOAD MESSAGES
    // ============================================
    function loadMessages() {
        showLoading();
        
        console.log('Loading messages from:', messagesApiUrl);
        
        fetch(messagesApiUrl, {
            headers: {
                'Accept': 'application/json',
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
        .then(data => {
            console.log('Messages loaded:', data.length, 'items');
            
            // Pastikan data adalah array
            if (Array.isArray(data)) {
                allMessages = data;
            } else if (data.error) {
                throw new Error(data.error);
            } else {
                allMessages = [];
            }
            
            updateStats();
            filterMessages();
        })
        .catch(error => {
            console.error('Error loading messages:', error);
            showError('Gagal memuat pesan. Silakan refresh halaman.');
        });
    }

    // ============================================
    // FUNGSI: UPDATE STATISTIK LOKAL
    // ============================================
    function updateStats() {
        if (!allMessages || allMessages.length === 0) {
            return;
        }

        // Hitung statistik dari data lokal
        const consultations = allMessages.filter(msg => msg.type === 'konsultasi').length;
        const feedbacks = allMessages.filter(msg => msg.type.includes('feedback')).length;
        
        // Hitung rating rata-rata
        const feedbacksWithRating = allMessages.filter(msg => msg.rating !== null && msg.rating > 0);
        let avgRating = 0;
        if (feedbacksWithRating.length > 0) {
            const totalRating = feedbacksWithRating.reduce((sum, msg) => sum + msg.rating, 0);
            avgRating = (totalRating / feedbacksWithRating.length).toFixed(1);
        }
        
        // Hitung 5-star feedbacks
        const fiveStarCount = allMessages.filter(msg => msg.rating === 5).length;
        
        // Update tampilan
        totalMessages.textContent = allMessages.length;
        averageRating.textContent = avgRating;
        totalConsultations.textContent = consultations;
        totalFeedbacks.textContent = feedbacks;
        
        // Update judul five star messages
        const fiveStarElement = document.querySelector('.col-md-3:nth-child(3) .card-title');
        if (fiveStarElement) {
            fiveStarElement.textContent = 'Feedback 5 Bintang';
            document.getElementById('fiveStarMessages').textContent = fiveStarCount;
        }
    }

    // ============================================
    // FUNGSI: FILTER MESSAGES
    // ============================================
    function filterMessages() {
        let filtered = [...allMessages];
        
        // Filter by date
        const startDate = document.getElementById('startDateFilter').value;
        const endDate = document.getElementById('endDateFilter').value;
        
        if (startDate) {
            filtered = filtered.filter(msg => 
                new Date(msg.created_at) >= new Date(startDate)
            );
        }
        
        if (endDate) {
            const endDateTime = new Date(endDate);
            endDateTime.setHours(23, 59, 59, 999);
            filtered = filtered.filter(msg => 
                new Date(msg.created_at) <= endDateTime
            );
        }
        
        // Filter by rating
        const ratingValue = document.getElementById('ratingFilter').value;
        if (ratingValue === "0") {
            // Filter untuk pesan tanpa rating (konsultasi)
            filtered = filtered.filter(msg => msg.rating === null || msg.rating === 0);
        } else if (ratingValue) {
            filtered = filtered.filter(msg => msg.rating == ratingValue);
        }
        
        // Filter by type
        const typeValue = document.getElementById('typeFilter').value;
        if (typeValue) {
            filtered = filtered.filter(msg => msg.type === typeValue);
        }
        
        // Filter by source
        const sourceValue = document.getElementById('sourceFilter').value;
        if (sourceValue) {
            filtered = filtered.filter(msg => msg.source === sourceValue);
        }
        
        // Filter by search
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        if (searchTerm) {
            filtered = filtered.filter(msg => 
                msg.name.toLowerCase().includes(searchTerm) ||
                (msg.email && msg.email.toLowerCase().includes(searchTerm)) ||
                (msg.phone && msg.phone.toLowerCase().includes(searchTerm)) ||
                (msg.message && msg.message.toLowerCase().includes(searchTerm)) ||
                (msg.pet_type && msg.pet_type.toLowerCase().includes(searchTerm))
            );
        }
        
        filteredMessages = filtered;
        renderMessages();
    }

    // ============================================
    // FUNGSI: SHOW LOADING
    // ============================================
    function showLoading() {
        messagesTable.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5">
                    <div class="spinner-border text-purple" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat pesan...</p>
                </td>
            </tr>
        `;
    }

    // ============================================
    // FUNGSI: SHOW ERROR
    // ============================================
    function showError(message) {
        messagesTable.innerHTML = `
            <tr>
                <td colspan="7" class="text-center py-5 text-danger">
                    <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                    <p>${message}</p>
                    <button class="btn btn-sm btn-outline-purple mt-2" onclick="loadMessages()">
                        <i class="fas fa-redo me-1"></i>Coba Lagi
                    </button>
                </td>
            </tr>
        `;
    }

    // ============================================
    // FUNGSI: RENDER MESSAGES TABLE
    // ============================================
    function renderMessages() {
        if (filteredMessages.length === 0) {
            messagesTable.innerHTML = `
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <i class="fas fa-inbox fa-2x mb-3 text-muted"></i>
                        <p>Tidak ada pesan yang ditemukan.</p>
                    </td>
                </tr>
            `;
            renderPagination();
            updatePaginationInfo();
            return;
        }
        
        // Sort by date (newest first)
        filteredMessages.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        
        // Calculate pagination
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = Math.min(startIndex + perPage, filteredMessages.length);
        const pageMessages = filteredMessages.slice(startIndex, endIndex);
        
        let html = '';
        pageMessages.forEach(message => {
            // Tampilkan bintang hanya untuk feedback
            const stars = message.rating ? getStarsHtml(message.rating) : '<span class="text-muted">-</span>';
            
            // Preview pesan
            const preview = message.message && message.message.length > 100 
                ? message.message.substring(0, 100) + '...' 
                : message.message || '-';
            
            // Format tanggal
            const date = new Date(message.created_at);
            const formattedDate = date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Badge tipe pesan
            const typeBadge = getTypeBadge(message.type);
            
            // Check if selected
            const isChecked = selectedMessages.has(message.id);
            
            // Safe email dan phone
            const safeEmail = message.email || '-';
            const safePhone = message.phone || '-';
            
            // Feedback indicator untuk konsultasi
            const feedbackIndicator = message.has_feedback 
                ? `<br><small class="text-success"><i class="fas fa-comment-check"></i> ${message.feedback_count} feedback</small>` 
                : '';
            
            html += `
                <tr class="message-row">
                    <td>
                        <input type="checkbox" class="message-checkbox" 
                               value="${message.id}" 
                               ${isChecked ? 'checked' : ''}
                               onclick="event.stopPropagation()">
                    </td>
                    <td onclick="viewMessage('${message.id}')" style="cursor: pointer;">
                        <div class="fw-bold">${message.name || '-'}</div>
                        <small class="text-muted">${safeEmail}</small>
                        ${safePhone !== '-' ? `<br><small class="text-muted">${safePhone}</small>` : ''}
                        ${feedbackIndicator}
                    </td>
                    <td onclick="viewMessage('${message.id}')" style="cursor: pointer;">
                        <div class="rating-stars">${stars}</div>
                        ${message.rating ? `<small class="text-muted">${message.rating}/5</small>` : ''}
                    </td>
                    <td onclick="viewMessage('${message.id}')" style="cursor: pointer;" title="${message.message || ''}">
                        <div class="message-preview">${preview}</div>
                    </td>
                    <td onclick="viewMessage('${message.id}')" style="cursor: pointer;">
                        ${typeBadge}
                    </td>
                    <td onclick="viewMessage('${message.id}')" style="cursor: pointer;">
                        <small>${formattedDate}</small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-info" onclick="viewMessage('${message.id}')" 
                                    data-bs-toggle="tooltip" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteMessage('${message.id}')" 
                                    data-bs-toggle="tooltip" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
        
        messagesTable.innerHTML = html;
        renderPagination();
        updatePaginationInfo();
        
        // Update filtered count
        filteredCount.textContent = filteredMessages.length;
        
        // Reinitialize tooltips for new buttons
        const newTooltips = [].slice.call(messagesTable.querySelectorAll('[data-bs-toggle="tooltip"]'));
        newTooltips.forEach(tooltipEl => {
            new bootstrap.Tooltip(tooltipEl);
        });
    }

    // ============================================
    // FUNGSI: GET STARS HTML
    // ============================================
    function getStarsHtml(rating) {
        if (!rating) return '<span class="text-muted">-</span>';
        
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += i <= rating 
                ? '<i class="fas fa-star"></i>' 
                : '<i class="far fa-star"></i>';
        }
        return stars;
    }

    // ============================================
    // FUNGSI: GET TYPE BADGE
    // ============================================
    function getTypeBadge(type) {
        switch(type) {
            case 'konsultasi':
                return '<span class="badge badge-type bg-primary">Konsultasi</span>';
            case 'feedback_konsultasi':
                return '<span class="badge badge-type bg-info">Feedback Konsultasi</span>';
            case 'feedback_layanan':
                return '<span class="badge badge-type bg-success">Feedback Layanan</span>';
            default:
                return '<span class="badge badge-type bg-secondary">Lainnya</span>';
        }
    }

    // ============================================
    // FUNGSI: RENDER PAGINATION
    // ============================================
    function renderPagination() {
        const totalPages = Math.ceil(filteredMessages.length / perPage);
        const pagination = document.getElementById('pagination');
        
        if (totalPages <= 1) {
            pagination.innerHTML = '';
            return;
        }
        
        let html = '';
        
        // Previous button
        html += `
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage - 1})">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </li>
        `;
        
        // Page numbers
        const maxVisible = 5;
        let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);
        
        if (endPage - startPage + 1 < maxVisible) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            html += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <button class="page-link" onclick="changePage(${i})">${i}</button>
                </li>
            `;
        }
        
        // Next button
        html += `
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="changePage(${currentPage + 1})">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </li>
        `;
        
        pagination.innerHTML = html;
    }

    // ============================================
    // FUNGSI: UPDATE PAGINATION INFO
    // ============================================
    function updatePaginationInfo() {
        const startIndex = (currentPage - 1) * perPage + 1;
        const endIndex = Math.min(startIndex + perPage - 1, filteredMessages.length);
        
        showingFrom.textContent = startIndex;
        showingTo.textContent = endIndex;
        totalCount.textContent = filteredMessages.length;
    }

    // ============================================
    // FUNGSI: CHANGE PAGE (EXPOSED TO WINDOW)
    // ============================================
    window.changePage = function(page) {
        if (page < 1 || page > Math.ceil(filteredMessages.length / perPage)) {
            return;
        }
        currentPage = page;
        renderMessages();
        // Uncheck select all when changing page
        selectAllCheckbox.checked = false;
        selectedMessages.clear();
    }

    // ============================================
    // FUNGSI: VIEW MESSAGE DETAILS (EXPOSED TO WINDOW)
    // ============================================
    window.viewMessage = function(id) {
        currentViewMessageId = id;
        
        const url = messageDetailUrl.replace(':id', id);
        
        console.log('Fetching message detail:', url);
        
        fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(message => {
            console.log('Message detail loaded:', message);
            
            // Populate modal dengan data yang lebih lengkap
            document.getElementById('detailId').textContent = message.id || '-';
            document.getElementById('detailName').textContent = message.name || '-';
            document.getElementById('detailEmail').textContent = message.email || '-';
            document.getElementById('detailPhone').textContent = message.phone || '-';
            document.getElementById('detailPetType').textContent = message.pet_type_label || message.pet_type || '-';
            document.getElementById('detailMessage').textContent = message.message || '-';
            
            // Tampilkan jenis pesan
            document.getElementById('detailSource').innerHTML = getTypeBadge(message.type) + 
                (message.source === 'consultation' 
                    ? ' <span class="badge bg-secondary">Sumber: Konsultasi</span>' 
                    : ' <span class="badge bg-warning">Sumber: After Service</span>');
            
            // Format services
            let servicesText = '-';
            if (message.services && Array.isArray(message.services) && message.services.length > 0) {
                servicesText = message.services.join(', ');
            } else if (message.service_type) {
                servicesText = message.service_type;
            } else if (message.formatted_services) {
                servicesText = message.formatted_services;
            }
            document.getElementById('detailServices').textContent = servicesText;
            
            // Rating stars - hanya untuk feedback
            if (message.rating) {
                const starsHtml = getStarsHtml(message.rating);
                document.getElementById('detailRating').innerHTML = starsHtml + ` (${message.rating}/5)`;
            } else {
                document.getElementById('detailRating').innerHTML = '<span class="text-muted">Tidak ada rating</span>';
            }
            
            // Clear additional info
            additionalInfo.innerHTML = '';
            
            // Tampilkan data tambahan
            if (message.type === 'konsultasi' && message.has_feedback) {
                let feedbacksHtml = '';
                if (message.feedbacks && message.feedbacks.length > 0) {
                    feedbacksHtml = message.feedbacks.map(fb => `
                        <div class="card bg-light mt-2">
                            <div class="card-body p-2">
                                <div class="d-flex justify-content-between">
                                    <strong>${fb.name}</strong>
                                    <div>${fb.rating_stars || getStarsHtml(fb.rating)}</div>
                                </div>
                                <p class="mb-0 mt-1">${fb.message}</p>
                                <small class="text-muted">${fb.created_at}</small>
                            </div>
                        </div>
                    `).join('');
                } else {
                    feedbacksHtml = '<p class="text-muted">Tidak ada feedback</p>';
                }
                
                additionalInfo.innerHTML = `
                    <hr>
                    <h6><i class="fas fa-comments me-2"></i>Feedback terkait (${message.feedback_count}):</h6>
                    ${feedbacksHtml}
                `;
            } else if (message.type.includes('feedback') && message.related_consultation) {
                additionalInfo.innerHTML = `
                    <hr>
                    <h6><i class="fas fa-link me-2"></i>Konsultasi Terkait:</h6>
                    <div class="card bg-light mt-2">
                        <div class="card-body p-2">
                            <div class="d-flex justify-content-between">
                                <strong>${message.related_consultation.name}</strong>
                            </div>
                            <p class="mb-0 mt-1">${message.related_consultation.message}</p>
                            <small class="text-muted">${message.related_consultation.created_at}</small>
                        </div>
                    </div>
                `;
            }
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('viewModal'));
            modal.show();
            
            // Reset modal content saat ditutup
            modal._element.addEventListener('hidden.bs.modal', function() {
                additionalInfo.innerHTML = '';
            });
        })
        .catch(error => {
            console.error('Error loading message details:', error);
            alert('Gagal memuat detail pesan.');
        });
    }

    // ============================================
    // FUNGSI: DELETE MESSAGE (EXPOSED TO WINDOW)
    // ============================================
    window.deleteMessage = function(id, confirmFirst = true) {
        const messageText = id.startsWith('C-') 
            ? 'Apakah Anda yakin ingin menghapus konsultasi ini dan semua feedback terkait?' 
            : 'Apakah Anda yakin ingin menghapus feedback ini?';
            
        if (confirmFirst && !confirm(messageText)) {
            return;
        }
        
        const url = deleteMessageUrl.replace(':id', id);
        
        console.log('Deleting message:', url);
        
        fetch(url, {
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
                alert(data.message);
                loadMessages(); // Refresh list
                loadStats(); // Refresh statistics dari server
                
                // Close modal if open
                const modal = bootstrap.Modal.getInstance(document.getElementById('viewModal'));
                if (modal) {
                    modal.hide();
                }
            } else {
                alert('Gagal menghapus: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Terjadi kesalahan jaringan.');
        });
    }

    // ============================================
    // EVENT LISTENERS FOR SELECT ALL
    // ============================================
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.message-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            if (this.checked) {
                selectedMessages.add(checkbox.value);
            } else {
                selectedMessages.delete(checkbox.value);
            }
        });
    });

    selectAllBtn.addEventListener('click', function() {
        selectAllCheckbox.checked = !selectAllCheckbox.checked;
        selectAllCheckbox.dispatchEvent(new Event('change'));
    });

    // Handle individual checkbox clicks
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('message-checkbox')) {
            const messageId = e.target.value;
            if (e.target.checked) {
                selectedMessages.add(messageId);
            } else {
                selectedMessages.delete(messageId);
                selectAllCheckbox.checked = false;
            }
        }
    });

    // ============================================
    // DELETE SELECTED MESSAGES
    // ============================================
    deleteSelectedBtn.addEventListener('click', function() {
        if (selectedMessages.size === 0) {
            alert('Pilih pesan terlebih dahulu!');
            return;
        }
        
        if (!confirm(`Hapus ${selectedMessages.size} pesan yang dipilih?`)) {
            return;
        }
        
        const promises = Array.from(selectedMessages).map(id => {
            const url = deleteMessageUrl.replace(':id', id);
            return fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
        });
        
        Promise.all(promises)
            .then(() => {
                alert('Pesan berhasil dihapus!');
                loadMessages();
                loadStats();
                selectedMessages.clear();
                selectAllCheckbox.checked = false;
            })
            .catch(error => {
                console.error('Delete error:', error);
                alert('Terjadi kesalahan saat menghapus pesan.');
            });
    });

    // ============================================
    // MODAL BUTTON ACTIONS
    // ============================================
    document.getElementById('deleteSingleBtn').addEventListener('click', function() {
        if (currentViewMessageId) {
            deleteMessage(currentViewMessageId, true);
        }
    });

    // ============================================
    // FILTER EVENT LISTENERS
    // ============================================
    document.getElementById('startDateFilter').addEventListener('change', filterMessages);
    document.getElementById('endDateFilter').addEventListener('change', filterMessages);
    document.getElementById('ratingFilter').addEventListener('change', filterMessages);
    document.getElementById('typeFilter').addEventListener('change', filterMessages);
    document.getElementById('sourceFilter').addEventListener('change', filterMessages);
    document.getElementById('searchInput').addEventListener('input', filterMessages);
    document.getElementById('searchBtn').addEventListener('click', filterMessages);

    // ============================================
    // REFRESH BUTTON
    // ============================================
    document.getElementById('refreshBtn').addEventListener('click', function() {
        loadMessages();
        loadStats();
    });

    // ============================================
    // AUTO REFRESH EVERY 30 SECONDS
    // ============================================
    setInterval(() => {
        loadMessages();
        loadStats();
    }, 30000);

    // ============================================
    // INITIAL LOAD
    // ============================================
    loadStats();    // Load statistics first
    loadMessages(); // Then load messages
});
</script>
@endsection