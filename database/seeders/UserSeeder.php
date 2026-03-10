<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@setda.go.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'jabatan' => 'Kepala Bagian Tata Pemerintahan',
            'sisa_cuti' => 0,
        ]);

        // Create Atasan
        User::create([
            'name' => 'Atasan Langsung',
            'email' => 'atasan@setda.go.id',
            'password' => Hash::make('password'),
            'role' => 'atasan',
            'jabatan' => 'Kepala Bidang',
            'sisa_cuti' => 0,
        ]);

        // Create Pegawai
        User::create([
            'name' => 'Pegawai Contoh',
            'email' => 'pegawai@setda.go.id',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'jabatan' => 'Staf Tata Pemerintahan',
            'sisa_cuti' => 12,
        ]);

        // Create additional pegawai
        $pegawaiData = [
            [
                'name' => 'Ahmad Sudirman',
                'email' => 'ahmad.sudirman@setda.go.id',
                'jabatan' => 'Staf Administrasi',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@setda.go.id',
                'jabatan' => 'Staf Keuangan',
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra.dewi@setda.go.id',
                'jabatan' => 'Staf Humas',
            ],
            [
                'name' => 'Dedi Pratama',
                'email' => 'dedi.pratama@setda.go.id',
                'jabatan' => 'Staf IT',
            ],
        ];

        foreach ($pegawaiData as $data) {
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'jabatan' => $data['jabatan'],
                'sisa_cuti' => 12,
            ]);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Default login credentials:');
        $this->command->info('Admin: admin@setda.go.id / password');
        $this->command->info('Atasan: atasan@setda.go.id / password');
        $this->command->info('Pegawai: pegawai@setda.go.id / password');
    }
}
