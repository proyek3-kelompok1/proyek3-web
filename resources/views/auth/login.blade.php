<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | DV Pets Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #7B2CBF, #9D4EDD, #C77DFF);
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }

        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            padding: 40px 50px;
            width: 100%;
            max-width: 420px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        .auth-card h2 {
            text-align: center;
            color: #6A1B9A;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #d1b3ff;
            padding: 12px;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #9D4EDD;
            box-shadow: 0 0 8px rgba(157, 78, 221, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #7B2CBF, #9D4EDD);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #9D4EDD, #C77DFF);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(157, 78, 221, 0.4);
        }

        .btn-outline-purple {
            border: 2px solid #9D4EDD;
            color: #9D4EDD;
            background: transparent;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-purple:hover {
            background: #9D4EDD;
            color: white;
            transform: translateY(-2px);
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .auth-footer a {
            color: #9D4EDD;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .admin-login-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
        }

        .admin-login-section p {
            color: #666;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Login ke Akun Anda</h2>

        <!-- Form login tetap sama -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input id="email" type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>

        <!-- Tambahkan tombol login admin di sini -->
        <div class="admin-login-section">
            <p>Staff atau Admin?</p>
            <a href="{{ url('/admin/login') }}" class="btn btn-outline-purple w-100">
                <i class="fas fa-user-shield me-2"></i>Login sebagai Admin
            </a>
        </div>

        <div class="auth-footer">
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>
        </div>
    </div>
</div>

<!-- Tambahkan Font Awesome untuk icon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

</body>
</html>