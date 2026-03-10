<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    /**
     * Show pegawai dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();
        
        $cutiMenunggu = Cuti::where('user_id', $user->id)
            ->where('status', 'menunggu')
            ->count();
        
        $cutiDisetujui = Cuti::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->count();
        
        $cutiDitolak = Cuti::where('user_id', $user->id)
            ->where('status', 'ditolak')
            ->count();
        
        $totalPengajuan = Cuti::where('user_id', $user->id)->count();
        
        $sisaCuti = $user->sisa_cuti;

        // Riwayat cuti terbaru
        $riwayatTerbaru = Cuti::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pegawai.dashboard', compact(
            'cutiMenunggu',
            'cutiDisetujui',
            'cutiDitolak',
            'totalPengajuan',
            'sisaCuti',
            'riwayatTerbaru'
        ));
    }

    /**
     * Show form to create new cuti submission.
     */
    public function createCuti()
    {
        $user = auth()->user();
        return view('pegawai.cuti.create', compact('user'));
    }

    /**
     * Store new cuti submission.
     */
    public function storeCuti(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'jenis_cuti' => 'required|in:cuti_tahunan,cuti_sakit,izin',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'alasan' => 'required|string|max:1000',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'jenis_cuti.required' => 'Jenis cuti wajib dipilih.',
            'jenis_cuti.in' => 'Jenis cuti tidak valid.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.date' => 'Format tanggal selesai tidak valid.',
            'alasan.required' => 'Alasan cuti wajib diisi.',
            'alasan.max' => 'Alasan maksimal 1000 karakter.',
            'file_pendukung.mimes' => 'File harus berformat PDF, JPG, JPEG, atau PNG.',
            'file_pendukung.max' => 'Ukuran file maksimal 2MB.',
        ]);

        // Validasi tanggal tidak boleh terbalik
        if (!Cuti::validasiTanggal($request->tanggal_mulai, $request->tanggal_selesai)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
        }

        // Validasi tanggal tidak boleh lampau
        if (!Cuti::validasiTanggalLampau($request->tanggal_mulai)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Tanggal mulai tidak boleh tanggal yang sudah lewat.');
        }

        // Hitung jumlah hari
        $jumlahHari = Cuti::hitungJumlahHari($request->tanggal_mulai, $request->tanggal_selesai);

        // Validasi sisa cuti untuk cuti tahunan
        if ($request->jenis_cuti === 'cuti_tahunan') {
            if ($user->sisa_cuti < $jumlahHari) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Sisa cuti Anda tidak mencukupi. Sisa cuti: ' . $user->sisa_cuti . ' hari, sedangkan pengajuan: ' . $jumlahHari . ' hari.');
            }
        }

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('file_pendukung')) {
            $filePath = $request->file('file_pendukung')->store('cuti-files', 'public');
        }

        Cuti::create([
            'user_id' => $user->id,
            'jenis_cuti' => $request->jenis_cuti,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jumlah_hari' => $jumlahHari,
            'alasan' => $request->alasan,
            'file_pendukung' => $filePath,
            'status' => 'menunggu',
        ]);

        return redirect()->route('pegawai.cuti.riwayat')
            ->with('success', 'Pengajuan cuti berhasil dikirim. Silakan tunggu persetujuan atasan.');
    }

    /**
     * Show riwayat cuti.
     */
    public function riwayat(Request $request)
    {
        $user = auth()->user();
        
        $query = Cuti::where('user_id', $user->id);

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis cuti
        if ($request->has('jenis_cuti') && $request->jenis_cuti != '') {
            $query->where('jenis_cuti', $request->jenis_cuti);
        }

        $riwayat = $query->latest()->paginate(10);

        return view('pegawai.cuti.riwayat', compact('riwayat'));
    }

    /**
     * Show detail of cuti submission.
     */
    public function showCuti(Cuti $cuti)
    {
        // Pastikan user hanya bisa melihat cuti miliknya sendiri
        if ($cuti->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $cuti->load('approver');
        return view('pegawai.cuti.show', compact('cuti'));
    }

    /**
     * Show sisa cuti.
     */
    public function sisaCuti()
    {
        $user = auth()->user();
        
        $cutiTerpakai = Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'cuti_tahunan')
            ->where('status', 'disetujui')
            ->sum('jumlah_hari');
        
        $sisaCuti = $user->sisa_cuti;
        $jatahCuti = 12;

        // Riwayat penggunaan cuti tahunan
        $riwayatCutiTahunan = Cuti::where('user_id', $user->id)
            ->where('jenis_cuti', 'cuti_tahunan')
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        return view('pegawai.cuti.sisa', compact(
            'sisaCuti',
            'jatahCuti',
            'cutiTerpakai',
            'riwayatCutiTahunan'
        ));
    }
}
