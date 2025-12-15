@extends('admin.layouts.app')

@section('title', 'Pesan Masuk - Admin DV Pets')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-inbox me-2"></i>Pesan Masuk - Ulasan Pelanggan
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
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Total Ulasan</h6>
                        <h2 class="mb-0" id="totalMessages">0</h2>
                    </div>
                    <div class="bg-white text-primary rounded-circle p-3">
                        <i class="fas fa-comments fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
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
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0">Ulasan 5 Bintang</h6>
                        <h2 class="mb-0" id="fiveStarMessages">0</h2>
                    </div>
                    <div class="bg-white text-info rounded-circle p-3">
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
            <div class="col-md-3">
                <label for="dateFilter" class="form-label fw-bold">Filter Tanggal</label>
                <div class="input-group">
                    <input type="date" class="form-control" id="startDateFilter">
                    <span class="input-group-text">s/d</span>
                    <input type="date" class="form-control" id="endDateFilter">
                </div>
            </div>
            <div class="col-md-3">
                <label for="ratingFilter" class="form-label fw-bold">Filter Rating</label>
                <select class="form-select" id="ratingFilter">
                    <option value="">Semua Rating</option>
                    <option value="5">★★★★★ (5)</option>
                    <option value="4">★★★★☆ (4)</option>
                    <option value="3">★★★☆☆ (3)</option>
                    <option value="2">★★☆☆☆ (2)</option>
                    <option value="1">★☆☆☆☆ (1)</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sourceFilter" class="form-label fw-bold">Filter Sumber</label>
                <select class="form-select" id="sourceFilter">
                    <option value="">Semua Sumber</option>
                    <option value="consultation">Konsultasi</option>
                    <option value="after_service">Setelah Layanan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="searchInput" class="form-label fw-bold">Cari</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Cari nama atau pesan...">
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
            <i class="fas fa-table me-2"></i>Daftar Ulasan Pelanggan
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
                        <th width="35%">Ulasan</th>
                        <th width="15%">Sumber</th>
                        <th width="15%">Tanggal</th>
                        <th width="4%">Aksi</th>
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
                <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Detail Ulasan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">ID Ulasan:</th>
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
                                <th>Sumber:</th>
                                <td>
                                    <span id="detailSource" class="badge bg-info">-</span>
                                </td>
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
                    <h6><i class="fas fa-comment me-2"></i>Ulasan:</h6>
                    <div class="card bg-light">
                        <div class="card-body">
                            <p id="detailMessage" class="mb-0"></p>
                        </div>
                    </div>
                </div>
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
    
    .badge-consultation {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-service {
        background-color: #28a745;
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

    // Elements
    const messagesTable = document.getElementById('messagesTable');
    const totalMessages = document.getElementById('totalMessages');
    const averageRating = document.getElementById('averageRating');
    const fiveStarMessages = document.getElementById('fiveStarMessages');
    const filteredCount = document.getElementById('filteredCount');
    const showingFrom = document.getElementById('showingFrom');
    const showingTo = document.getElementById('showingTo');
    const totalCount = document.getElementById('totalCount');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const selectAllBtn = document.getElementById('selectAllBtn');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

    // Load messages
    function loadMessages() {
        showLoading();
        
        fetch(messagesApiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                allMessages = data;
                updateStats();
                filterMessages();
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                showError('Gagal memuat pesan. Silakan refresh halaman.');
            });
    }

    // Update statistics
    function updateStats() {
        if (!allMessages || allMessages.length === 0) {
            totalMessages.textContent = '0';
            averageRating.textContent = '0.0';
            fiveStarMessages.textContent = '0';
            return;
        }

        // Total messages
        totalMessages.textContent = allMessages.length;

        // Average rating
        const totalRating = allMessages.reduce((sum, msg) => sum + msg.rating, 0);
        const avg = (totalRating / allMessages.length).toFixed(1);
        averageRating.textContent = avg;

        // 5-star messages
        const fiveStarCount = allMessages.filter(msg => msg.rating === 5).length;
        fiveStarMessages.textContent = fiveStarCount;
    }

    // Filter messages
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
        if (ratingValue) {
            filtered = filtered.filter(msg => msg.rating == ratingValue);
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
                msg.message.toLowerCase().includes(searchTerm)
            );
        }
        
        filteredMessages = filtered;
        renderMessages();
    }

    // Show loading state
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

    // Show error state
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

    // Render messages table
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
            const stars = getStarsHtml(message.rating);
            const preview = message.message.length > 100 
                ? message.message.substring(0, 100) + '...' 
                : message.message;
            
            // Format date
            const date = new Date(message.created_at);
            const formattedDate = date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
            
            // Source badge
            const sourceBadge = getSourceBadge(message.source);
            
            // Check if selected
            const isChecked = selectedMessages.has(message.id);
            
            html += `
                <tr class="message-row">
                    <td>
                        <input type="checkbox" class="message-checkbox" 
                               value="${message.id}" 
                               ${isChecked ? 'checked' : ''}
                               onclick="event.stopPropagation()">
                    </td>
                    <td onclick="viewMessage(${message.id})" style="cursor: pointer;">
                        <div class="fw-bold">${message.name}</div>
                        <small class="text-muted">${message.email || '-'}</small>
                        ${message.phone ? `<br><small class="text-muted">${message.phone}</small>` : ''}
                    </td>
                    <td onclick="viewMessage(${message.id})" style="cursor: pointer;">
                        <div class="rating-stars">${stars}</div>
                        <small class="text-muted">${message.rating}/5</small>
                    </td>
                    <td onclick="viewMessage(${message.id})" style="cursor: pointer;" title="${message.message}">
                        <div class="message-preview">${preview}</div>
                    </td>
                    <td onclick="viewMessage(${message.id})" style="cursor: pointer;">
                        ${sourceBadge}
                    </td>
                    <td onclick="viewMessage(${message.id})" style="cursor: pointer;">
                        <small>${formattedDate}</small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-info" onclick="viewMessage(${message.id})" 
                                    data-bs-toggle="tooltip" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteMessage(${message.id})" 
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

    // Get stars HTML
    function getStarsHtml(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            stars += i <= rating 
                ? '<i class="fas fa-star"></i>' 
                : '<i class="far fa-star"></i>';
        }
        return stars;
    }

    // Get source badge
    function getSourceBadge(source) {
        if (source === 'consultation') {
            return '<span class="badge badge-source badge-consultation">Konsultasi</span>';
        } else if (source === 'after_service') {
            return '<span class="badge badge-source badge-service">Setelah Layanan</span>';
        }
        return '<span class="badge badge-source bg-secondary">Lainnya</span>';
    }

    // Render pagination
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

    // Update pagination info
    function updatePaginationInfo() {
        const startIndex = (currentPage - 1) * perPage + 1;
        const endIndex = Math.min(startIndex + perPage - 1, filteredMessages.length);
        
        showingFrom.textContent = startIndex;
        showingTo.textContent = endIndex;
        totalCount.textContent = filteredMessages.length;
    }

    // Change page
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

    // View message details
    window.viewMessage = function(id) {
        currentViewMessageId = id;
        
        const url = messageDetailUrl.replace(':id', id);
        
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(message => {
                // Populate modal
                document.getElementById('detailId').textContent = message.id;
                document.getElementById('detailName').textContent = message.name;
                document.getElementById('detailEmail').textContent = message.email || '-';
                document.getElementById('detailPhone').textContent = message.phone || '-';
                document.getElementById('detailPetType').textContent = message.pet_type || '-';
                document.getElementById('detailMessage').textContent = message.message;
                document.getElementById('detailSource').innerHTML = getSourceBadge(message.source);
                
                // Format services
                const services = message.services ? message.services.join(', ') : '-';
                document.getElementById('detailServices').textContent = services;
                
                // Rating stars
                const starsHtml = getStarsHtml(message.rating);
                document.getElementById('detailRating').innerHTML = starsHtml + ` (${message.rating}/5)`;
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('viewModal'));
                modal.show();
            })
            .catch(error => {
                console.error('Error loading message details:', error);
                alert('Gagal memuat detail pesan.');
            });
    }

    // Delete single message
    window.deleteMessage = function(id, confirmFirst = true) {
        if (confirmFirst && !confirm('Apakah Anda yakin ingin menghapus ulasan ini?')) {
            return;
        }
        
        const url = deleteMessageUrl.replace(':id', id);
        
        fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Ulasan berhasil dihapus!');
                loadMessages();
                
                // Close modal if open
                const modal = bootstrap.Modal.getInstance(document.getElementById('viewModal'));
                if (modal) {
                    modal.hide();
                }
            } else {
                alert('Gagal menghapus ulasan: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Terjadi kesalahan jaringan.');
        });
    }

    // Select all functionality
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.message-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            if (this.checked) {
                selectedMessages.add(parseInt(checkbox.value));
            } else {
                selectedMessages.delete(parseInt(checkbox.value));
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
            const messageId = parseInt(e.target.value);
            if (e.target.checked) {
                selectedMessages.add(messageId);
            } else {
                selectedMessages.delete(messageId);
                selectAllCheckbox.checked = false;
            }
        }
    });

    // Delete selected messages
    deleteSelectedBtn.addEventListener('click', function() {
        if (selectedMessages.size === 0) {
            alert('Pilih ulasan terlebih dahulu!');
            return;
        }
        
        if (!confirm(`Hapus ${selectedMessages.size} ulasan yang dipilih?`)) {
            return;
        }
        
        const promises = Array.from(selectedMessages).map(id => {
            const url = deleteMessageUrl.replace(':id', id);
            return fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
        });
        
        Promise.all(promises)
            .then(() => {
                alert('Ulasan berhasil dihapus!');
                loadMessages();
                selectedMessages.clear();
                selectAllCheckbox.checked = false;
            })
            .catch(error => {
                console.error('Delete error:', error);
                alert('Terjadi kesalahan saat menghapus ulasan.');
            });
    });

    // Modal button actions
    document.getElementById('deleteSingleBtn').addEventListener('click', function() {
        if (currentViewMessageId) {
            deleteMessage(currentViewMessageId, true);
        }
    });

    // Filter event listeners
    document.getElementById('startDateFilter').addEventListener('change', filterMessages);
    document.getElementById('endDateFilter').addEventListener('change', filterMessages);
    document.getElementById('ratingFilter').addEventListener('change', filterMessages);
    document.getElementById('sourceFilter').addEventListener('change', filterMessages);
    document.getElementById('searchInput').addEventListener('input', filterMessages);
    document.getElementById('searchBtn').addEventListener('click', filterMessages);

    // Refresh button
    document.getElementById('refreshBtn').addEventListener('click', function() {
        loadMessages();
    });

    // Auto refresh every 30 seconds
    setInterval(loadMessages, 30000);

    // Initial load
    loadMessages();
});
</script>
@endsection