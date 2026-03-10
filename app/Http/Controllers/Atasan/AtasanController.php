<?php

namespace App\Http\Controllers\Atasan;

use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AtasanController extends Controller
{
    /**
     * Show atasan dashboard.
     */
    public function dashboard()
    {
        $cutiMenunggu = Cuti::where('status', 'menunggu')->count();
        $cutiDisetujui = Cuti::where('status', 'disetujui')->count();
        $cutiDitolak = Cuti::where('status', 'ditolak')->count();
        $totalPengajuan = Cuti::count();

        // Statistik per jenis cuti
        $cutiTahunan = Cuti::where('jenis_cuti', 'cuti_tahunan')->count();
        $cutiSakit = Cuti::where('jenis_cuti', 'cuti_sakit')->count();
        $izin = Cuti::where('jenis_cuti', 'izin')->count();

        // Pengajuan terbaru
        $pengajuanTerbaru = Cuti::with('user')
            ->where('status', 'menunggu')
            ->latest()
            ->take(5)
            ->get();

        return view('atasan.dashboard', compact(
            'cutiMenunggu',
            'cutiDisetujui',
            'cutiDitolak',
            'totalPengajuan',
            'cutiTahunan',
            'cutiSakit',
            'izin',
            'pengajuanTerbaru'
        ));
    }

    /**
     * Show list of all cuti submissions.
     */
    public function pengajuan(Request $request)
    {
        $query = Cuti::with('user');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis cuti
        if ($request->has('jenis_cuti') && $request->jenis_cuti != '') {
            $query->where('jenis_cuti', $request->jenis_cuti);
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('tanggal_mulai', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_selesai') && $request->tanggal_selesai != '') {
            $query->whereDate('tanggal_selesai', '<=', $request->tanggal_selesai);
        }

        $pengajuan = $query->latest()->paginate(15);

        return view('atasan.pengajuan.index', compact('pengajuan'));
    }

    /**
     * Show detail of cuti submission.
     */
    public function showPengajuan(Cuti $cuti)
    {
        $cuti->load('user', 'approver');
        return view('atasan.pengajuan.show', compact('cuti'));
    }

    /**
     * Approve cuti submission.
     */
    public function approve(Request $request, Cuti $cuti)
    {
        // Validasi: hanya bisa approve jika status masih menunggu
        if ($cuti->status !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Pengajuan ini sudah diproses.');
        }

        // Validasi: cek sisa cuti untuk cuti tahunan
        if ($cuti->jenis_cuti === 'cuti_tahunan') {
            $user = $cuti->user;
            if ($user->sisa_cuti < $cuti->jumlah_hari) {
                return redirect()->back()
                    ->with('error', 'Sisa cuti pegawai tidak mencukupi. Sisa cuti: ' . $user->sisa_cuti . ' hari.');
            }
        }

        $cuti->update([
            'status' => 'disetujui',
            'approved_by' => auth()->id(),
            'catatan_atasan' => $request->catatan,
        ]);

        return redirect()->route('atasan.pengajuan.index')
            ->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    /**
     * Reject cuti submission.
     */
    public function reject(Request $request, Cuti $cuti)
    {
        $request->validate([
            'catatan' => 'required|string|max:500',
        ], [
            'catatan.required' => 'Catatan penolakan wajib diisi.',
        ]);

        // Validasi: hanya bisa reject jika status masih menunggu
        if ($cuti->status !== 'menunggu') {
            return redirect()->back()
                ->with('error', 'Pengajuan ini sudah diproses.');
        }

        $cuti->update([
            'status' => 'ditolak',
            'approved_by' => auth()->id(),
            'catatan_atasan' => $request->catatan,
        ]);

        return redirect()->route('atasan.pengajuan.index')
            ->with('success', 'Pengajuan cuti berhasil ditolak.');
    }
}
