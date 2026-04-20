@extends('layouts.app')

@section('title', 'Layanan')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="fw-bold text-purple mb-4">Layanan Kami</h1>
                    <p class="lead">Berbagai layanan kesehatan hewan yang kami sediakan untuk kebutuhan hewan peliharaan
                        Anda</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Layanan -->
    <section class="py-3 bg-light-purple">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
                        <button type="button" class="btn btn-outline-purple filter-btn active" data-filter="all">
                            Semua Layanan
                        </button>
                        @php
                            // Hapus 'all' dari array karena sudah ada sebagai tombol terpisah
                            $filterTypes = array_diff_key($serviceTypes, ['all' => '']);
                        @endphp
                        @foreach($filterTypes as $key => $type)
                            <button type="button" class="btn btn-outline-purple filter-btn" data-filter="{{ $key }}">
                                {{ $type }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Layanan dari Database -->
    <section class="py-5">
        <div class="container">
            @if($services->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-stethoscope fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">Belum ada layanan tersedia</h3>
                    <p class="text-muted">Silakan kembali lagi nanti</p>
                </div>
            @else
                <div class="row g-4" id="services-container">
                    @foreach($services as $service)
                        <div class="col-md-6 col-lg-4 service-item" data-type="{{ $service->service_type }}">
                            <div class="card service-card h-100" onclick="showServiceDetail('{{ $service->id }}')"
                                style="cursor: pointer;">
                                <div class="card-body p-4">
                                    <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                        style="width: 60px; height: 60px;">
                                        <i class="{{ $service->icon }} text-white fa-lg"></i>
                                    </div>
                                    <h5 class="card-title fw-bold">{{ $service->name }}</h5>
                                    <p class="card-text">{{ $service->description }}</p>

                                    <div class="mt-3">
                                        <span class="badge bg-info mb-2">{{ $service->service_type_label }}</span>
                                        @if($service->price)
                                            <div class="d-flex justify-content-between align-items-center mt-2">
                                                <span class="fw-bold text-purple">{{ $service->formatted_price }}</span>
                                                <span class="text-muted small">{{ $service->formatted_duration }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-3 pt-3 border-top">
                                        <span class="badge bg-light text-purple">Klik untuk detail</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Modal untuk Detail Layanan -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-labelledby="serviceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-purple" id="serviceModalLabel"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="serviceContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ route('online-services.index') }}" class="btn btn-purple">
                        <i class="fas fa-calendar-check me-2"></i>Booking Layanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            padding-top: 80px;
        }

        .service-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(106, 48, 147, 0.2);
            border-color: #6a3093;
        }

        .text-purple {
            color: #6a3093 !important;
        }

        /* .bg-purple {
            background: linear-gradient(135deg, #6a3093, #8a4dcc) !important;
        } */

        .bg-light-purple {
            background-color: #f8f5ff !important;
        }

        .btn-outline-purple {
            color: #6a3093;
            border-color: #6a3093;
        }

        .btn-outline-purple:hover,
        .btn-outline-purple.active {
            background-color: #6a3093;
            color: white;
        }

        .btn-purple {
            background: linear-gradient(135deg, #6a3093, #8a4dcc);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-purple:hover {
            background: linear-gradient(135deg, #8a4dcc, #6a3093);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 48, 147, 0.4);
            color: white;
        }
    </style>

    <script>
        // Filter layanan berdasarkan jenis
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const serviceItems = document.querySelectorAll('.service-item');

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    // Filter items
                    serviceItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-type') === filterValue) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });

        // Fungsi untuk membuka modal detail layanan
        function showServiceDetail(serviceId) {
            fetch(`/services/${serviceId}/detail`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('serviceModalLabel').textContent = data.service.name;

                        let content = `
                                    <div class="service-detail">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="d-flex align-items-center mb-4">
                                                    <div class="bg-purple rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                                        <i class="${data.service.icon} text-white fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-1">${data.service.name}</h5>
                                                        <span class="badge bg-info">${data.service.service_type_label}</span>
                                                    </div>
                                                </div>

                                                <p class="lead">${data.service.description}</p>

                                                <div class="row mb-4">
                                                    ${data.service.price ? `
                                                    <div class="col-md-6">
                                                        <div class="info-box p-3 bg-white border rounded shadow-sm mb-3">
                                                            <div class="d-flex align-items-center fw-bold text-muted text-uppercase" style="font-size: 0.85rem">
                                                                <i class="fas fa-tag me-2 text-purple"></i> Harga Layanan
                                                            </div>
                                                            <div class="fs-4 text-dark fw-bold mt-2">${data.service.formatted_price}</div>
                                                        </div>
                                                    </div>
                                                    ` : ''}

                                                    ${data.service.duration_minutes ? `
                                                    <div class="col-md-6">
                                                        <div class="info-box p-3 bg-white border rounded shadow-sm mb-3">
                                                            <div class="d-flex align-items-center fw-bold text-muted text-uppercase" style="font-size: 0.85rem">
                                                                <i class="fas fa-clock me-2 text-purple"></i> Estimasi Durasi
                                                            </div>
                                                            <div class="fs-4 text-dark fw-bold mt-2">${data.service.formatted_duration}</div>
                                                        </div>
                                                    </div>
                                                    ` : ''}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card bg-light">
                                                    <div class="card-body text-center">
                                                        <i class="${data.service.icon} fa-4x text-purple mb-3"></i>
                                                        <h6>Icon Layanan</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                                <i class="fas fa-file-invoice text-purple me-2"></i>Deskripsi Lengkap
                                            </h5>
                                            <div class="bg-light p-4 rounded">
                                                ${data.service.details.replace(/\n/g, '<br>')}
                                            </div>
                                        </div>
                                    </div>
                                `;

                        document.getElementById('serviceContent').innerHTML = content;
                        const modal = new bootstrap.Modal(document.getElementById('serviceModal'));
                        modal.show();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memuat detail layanan');
                });
        }
    </script>
@endsection