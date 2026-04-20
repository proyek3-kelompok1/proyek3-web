<!DOCTYPE html>
<html>
<head>
    <title>Kode Verifikasi DevPets</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #6C63FF; text-align: center;">Verifikasi Akun DevPets</h2>
        <p>Halo,</p>
        <p>Terima kasih telah mendaftar di <strong>DevPets</strong>. Gunakan kode OTP di bawah ini untuk memverifikasi akun Anda:</p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; background: #f4f4f4; padding: 10px 20px; letter-spacing: 5px; border-radius: 5px; color: #333;">
                {{ $otp }}
            </span>
        </div>
        <p>Kode ini berlaku selama 10 menit. Jangan berikan kode ini kepada siapapun.</p>
        <p>Jika Anda tidak merasa mendaftar di DevPets, silakan abaikan email ini.</p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #888; text-align: center;">&copy; {{ date('Y') }} DevPets. All rights reserved.</p>
    </div>
</body>
</html>
