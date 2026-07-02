<!DOCTYPE html>
<html lang="id">

<head>
    @stack('styles')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Klinik Hewan DV Pets - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a0dad;
            --secondary-color: #8a2be2;
            --light-purple: #e6e6fa;
            --dark-purple: #4b0082;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding-top: 80px;
        }


        .bg-purple {
            background-color: var(--primary-color) !important;
        }

        .text-purple {
            color: var(--primary-color) !important;
        }

        .btn-purple {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-purple:hover {
            background-color: var(--dark-purple);
            border-color: var(--dark-purple);
        }

        .btn-outline-purple {
            color: var(--primary-color);
            border-color: var(--primary-color);
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-purple:hover {
            color: white;
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .hero-section {
            background: linear-gradient(rgba(106, 13, 173, 0.8), rgba(106, 13, 173, 0.8)),
                url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;

            height: 100vh;
            /* full tinggi layar */
            display: flex;
            align-items: center;
            /* biar isi ke tengah vertikal */
            justify-content: center;
            /* tengah horizontal */
            text-align: center;
        }

        .service-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .service-card:hover {
            transform: translateY(-10px);
        }

        .footer {
            background-color: var(--dark-purple);
            color: white;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- YourTarget Ad Network Loader -->
    <script async src="https://static.servestatic.net/js/ytrgt.js"></script>
    <script>window.ytrgt=window.ytrgt||function(){(window.ytrgt.q=window.ytrgt.q||[]).push(arguments)};</script>
    <!-- EffectiveCPM Ad Network -->
    <script src="https://pl30167073.effectivecpmnetwork.com/e6/8b/ac/e68bacfedde89461b453467db666bde6.js"></script>
</head>

<body>
    @include('layouts.navbar')

    <main>
        <!-- Top Ads Section -->
        <div class="container text-center my-3">
            <div class="row g-3 justify-content-center align-items-center">
                <!-- Banner 468x60 -->
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <div style="overflow: hidden; max-width: 100%;">
                        <script>
                          atOptions = {
                            'key' : 'b946c77c53008e577fe2832189020ee9',
                            'format' : 'iframe',
                            'height' : 60,
                            'width' : 468,
                            'params' : {}
                          };
                        </script>
                        <script src="https://www.highperformanceformat.com/b946c77c53008e577fe2832189020ee9/invoke.js"></script>
                    </div>
                </div>
                <!-- Native Banner -->
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <div style="width: 100%; max-width: 468px; min-height: 60px;">
                        <script async="async" data-cfasync="false" src="https://pl30167341.effectivecpmnetwork.com/471b88d391f06262355b2755898ddc71/invoke.js"></script>
                        <div id="container-471b88d391f06262355b2755898ddc71"></div>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')

        <!-- Bottom Ads Section -->
        <div class="container text-center my-4 py-3 border-top">
            <!-- 300x250 Banners Row -->
            <div class="row g-4 justify-content-center align-items-center mb-4">
                <!-- YourTarget 300x250 -->
                <div class="col-auto">
                    <div class="p-2 bg-light rounded shadow-sm d-inline-block">
                        <div id="ytrgt-fd58a5860b7e47d18057b80773a726f4" style="width: 300px; height: 250px;"></div>
                        <script>
                            (function waitYtrgt() {
                                if (typeof ytrgt === 'function') {
                                    ytrgt('hb:load', '#ytrgt-fd58a5860b7e47d18057b80773a726f4', {
                                        endpoint: 'https://collect.rtb.events/hb',
                                        publisherId: 'fd58a5860b7e47d18057b80773a726f4',
                                        sizes: [[300, 250]],
                                        tmax: 1000,
                                        showAdMark: true
                                    });
                                } else {
                                    setTimeout(waitYtrgt, 100);
                                }
                            })();
                        </script>
                    </div>
                </div>

                <!-- HighPerformance 300x250 -->
                <div class="col-auto">
                    <div class="p-2 bg-light rounded shadow-sm d-inline-block">
                        <script>
                          atOptions = {
                            'key' : '6b11b0ee076597c08a4d41fe04540e00',
                            'format' : 'iframe',
                            'height' : 250,
                            'width' : 300,
                            'params' : {}
                          };
                        </script>
                        <script src="https://www.highperformanceformat.com/6b11b0ee076597c08a4d41fe04540e00/invoke.js"></script>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Banner 728x90 (Desktop & Tablet only) -->
            <div class="d-none d-md-block my-4">
                <div class="d-inline-block" style="overflow: hidden; max-width: 100%;">
                    <script>
                        atOptions = {
                            'key' : '6cf327316751ec86781f14a41c9982da',
                            'format' : 'iframe',
                            'height' : 90,
                            'width' : 728,
                            'params' : {}
                        };
                    </script>
                    <script src="https://www.highperformanceformat.com/6cf327316751ec86781f14a41c9982da/invoke.js"></script>
                </div>
            </div>

            <!-- Mobile Banner 320x50 (Mobile only) -->
            <div class="d-block d-md-none my-3">
                <div class="d-inline-block" style="overflow: hidden; max-width: 100%;">
                    <script>
                        atOptions = {
                            'key' : '092ac736f4dca50cec19ffcc3b414f59',
                            'format' : 'iframe',
                            'height' : 50,
                            'width' : 320,
                            'params' : {}
                        };
                    </script>
                    <script src="https://www.highperformanceformat.com/092ac736f4dca50cec19ffcc3b414f59/invoke.js"></script>
                </div>
            </div>

            <!-- Smartlink -->
            <div class="mt-4">
                <a href="https://www.effectivecpmnetwork.com/y3hj693nb?key=5cf078ef8f129f641ea8e7cffce62abb" class="btn btn-outline-purple px-4 py-2 fw-bold" target="_blank" rel="noopener">
                    <i class="fas fa-external-link-alt me-2"></i>Rekomendasi Layanan & Sponsor
                </a>
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- EffectiveCPM Social Bar -->
    <script src="https://pl30167298.effectivecpmnetwork.com/c4/21/03/c4210348a8592b10a996b244a5b56366.js"></script>
</body>

</html>