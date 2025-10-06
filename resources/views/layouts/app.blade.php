<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
        .hero-section {
            background: linear-gradient(rgba(106, 13, 173, 0.8), rgba(106, 13, 173, 0.8)), 
                        url('https://images.unsplash.com/photo-1450778869180-41d0601e046e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
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
</head>
<body>
    @include('layouts.navbar')
    
    <main>
        @yield('content')
    </main>
    
    @include('layouts.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>