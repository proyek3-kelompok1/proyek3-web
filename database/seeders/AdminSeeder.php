<?php
// database/seeders/AdminSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus data existing jika ada
        DB::table('admins')->delete();

        // Buat admin baru
        Admin::create([
            'name' => 'Admin DV Pets',
            'email' => 'mindvpets@gmail.com', // PASTIKAN EMAIL BENAR
            'password' => Hash::make('pets12345'), // PASTIKAN PASSWORD BENAR
        ]);

        $this->command->info('Admin created successfully!');
        $this->command->info('Email: mindvpets@gmail.com');
        $this->command->info('Password: pets12345');
    }
}