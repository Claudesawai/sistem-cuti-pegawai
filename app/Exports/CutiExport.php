<?php

namespace App\Exports;

use App\Models\Cuti;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CutiExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Cuti::with('user');

        if (!empty($this->filters['bulan'])) {
            $query->whereMonth('tanggal_mulai', $this->filters['bulan']);
        }

        if (!empty($this->filters['tahun'])) {
            $query->whereYear('tanggal_mulai', $this->filters['tahun']);
        }

        if (!empty($this->filters['user_id'])) {
            $query->where('user_id', $this->filters['user_id']);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Pegawai',
            'Jenis Cuti',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Jumlah Hari',
            'Alasan',
            'Status',
            'Catatan Atasan',
            'Tanggal Pengajuan',
        ];
    }

    public function map($cuti): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $cuti->user->name,
            $cuti->jenis_cuti_label,
            $cuti->tanggal_mulai->format('d/m/Y'),
            $cuti->tanggal_selesai->format('d/m/Y'),
            $cuti->jumlah_hari,
            $cuti->alasan,
            $cuti->status_label,
            $cuti->catatan_atasan ?? '-',
            $cuti->created_at->format('d/m/Y H:i'),
        ];
    }
}
