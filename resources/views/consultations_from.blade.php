{{-- <!DOCTYPE html>
<html>
<head>
    <title>Konsultasi Klinik Hewan</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .invalid { border-color: #dc3545; }
    </style>
</head>
<body>
    <h1>Form Konsultasi Klinik Hewan</h1>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form -->
    <form method="POST" action="/konsultasi">
        @csrf
        
        <div class="form-group">
            <label for="nama">Nama Lengkap *</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
            @error('nama') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="no_hp">Nomor HP/WhatsApp *</label>
            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
            @error('no_hp') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="layanan">Layanan yang Diinginkan *</label>
            <select id="layanan" name="layanan" required>
                <option value="">Pilih Layanan</option>
                @foreach($services as $key => $service)
                    <option value="{{ $key }}" {{ old('layanan') == $key ? 'selected' : '' }}>
                        {{ $service }}
                    </option>
                @endforeach
            </select>
            @error('layanan') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="pesan">Pesan/Keluhan *</label>
            <textarea id="pesan" name="pesan" rows="4" required>{{ old('pesan') }}</textarea>
            @error('pesan') <span style="color: red;">{{ $message }}</span> @enderror
        </div>

        <button type="submit">Kirim Konsultasi</button>
    </form>
</body>
</html> --}}