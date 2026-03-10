<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CutiExport;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $totalPegawai = User::where('role', 'pegawai')->count();
        $totalAtasan = User::where('role', 'atasan')->count();
        $totalCuti = Cuti::count();
        $cutiMenunggu = Cuti::where('status', 'menunggu')->count();
        $cutiDisetujui = Cuti::where('status', 'disetujui')->count();
        $cutiDitolak = Cuti::where('status', 'ditolak')->count();

        $cutiTerbaru = Cuti::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPegawai',
            'totalAtasan',
            'totalCuti',
            'cutiMenunggu',
            'cutiDisetujui',
            'cutiDitolak',
            'cutiTerbaru'
        ));
    }

    /**
     * Show list of all users.
     */
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show form to create new user.
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|unique:users,nip|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,atasan,pegawai',
            'jabatan' => 'nullable|string|max:255',
            'sisa_cuti' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
        ]);

        User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'jabatan' => $request->jabatan,
            'sisa_cuti' => $request->sisa_cuti ?? 12,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pegawai berhasil ditambahkan.');
    }

    /**
     * Show form to edit user.
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,atasan,pegawai',
            'jabatan' => 'nullable|string|max:255',
            'sisa_cuti' => 'nullable|integer|min:0',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'role.required' => 'Role wajib dipilih.',
            'role.in' => 'Role tidak valid.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'jabatan' => $request->jabatan,
            'sisa_cuti' => $request->sisa_cuti ?? $user->sisa_cuti,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user)
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pegawai berhasil dihapus.');
    }

    /**
     * Show all cuti data.
     */
    public function cuti(Request $request)
    {
        $query = Cuti::with('user', 'approver');

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('jenis_cuti') && $request->jenis_cuti != '') {
            $query->where('jenis_cuti', $request->jenis_cuti);
        }

        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_mulai', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_mulai', $request->tahun);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        $cuti = $query->latest()->paginate(15);
        $users = User::where('role', 'pegawai')->get();

        return view('admin.cuti.index', compact('cuti', 'users'));
    }

    /**
     * Export cuti to PDF.
     */
    public function exportPdf(Request $request)
    {
        $query = Cuti::with('user', 'approver');

        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_mulai', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_mulai', $request->tahun);
        }

        if ($request->has('user_id') && $request->user_id != '') {
            $query->where('user_id', $request->user_id);
        }

        $cuti = $query->get();

        $pdf = PDF::loadView('admin.cuti.pdf', compact('cuti'));
        
        $filename = 'laporan-cuti-' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Export cuti to Excel.
     */
    public function exportExcel(Request $request)
    {
        $filters = [
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'user_id' => $request->user_id,
        ];

        $filename = 'laporan-cuti-' . now()->format('Y-m-d') . '.xlsx';
        
        return Excel::download(new CutiExport($filters), $filename);
    }
}
