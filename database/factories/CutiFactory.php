<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Cuti;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cuti>
 */
class CutiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cuti::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalMulai = fake()->dateTimeBetween('now', '+1 month');
        $tanggalSelesai = Carbon::parse($tanggalMulai)->addDays(fake()->numberBetween(1, 5));
        
        return [
            'user_id' => User::factory(),
            'jenis_cuti' => fake()->randomElement(['cuti_tahunan', 'cuti_sakit', 'izin']),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
            'jumlah_hari' => Cuti::hitungJumlahHari($tanggalMulai, $tanggalSelesai),
            'alasan' => fake()->sentence(10),
            'file_pendukung' => null,
            'status' => fake()->randomElement(['menunggu', 'disetujui', 'ditolak']),
            'catatan_atasan' => null,
            'approved_by' => null,
        ];
    }

    /**
     * Indicate that the cuti is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'menunggu',
            'approved_by' => null,
            'catatan_atasan' => null,
        ]);
    }

    /**
     * Indicate that the cuti is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'disetujui',
            'approved_by' => User::factory()->create(['role' => 'atasan'])->id,
        ]);
    }

    /**
     * Indicate that the cuti is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ditolak',
            'approved_by' => User::factory()->create(['role' => 'atasan'])->id,
            'catatan_atasan' => fake()->sentence(5),
        ]);
    }
}
