<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | DV Pets Klinik</title>
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
            padding: 5px 50px;
            width: 100%;
            max-width: 480px;
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
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h2>Buat Akun Baru</h2>

        <!-- Form register tetap sama -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input id="name" type="text" name="name" class="form-control" placeholder="Masukkan nama Anda" required autofocus>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input id="email" type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Masukkan kata sandi" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Daftar Sekarang</button>
        </form>

        <div class="auth-footer">
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
        </div>
    </div>
</div>

</body>
</html>
