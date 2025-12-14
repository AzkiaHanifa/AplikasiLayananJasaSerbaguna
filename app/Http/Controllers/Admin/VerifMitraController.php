<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra; 
use Illuminate\Http\Request;

class VerifMitraController extends Controller
{
    /**
     * Menampilkan daftar mitra yang statusnya 'pending'.
     */
    public function index()
    {
        // Ambil data mitra yang pending, sertakan data user-nya (Eager Loading)
        $mitras = Mitra::with('user')
                      ->where('status', 'pending')
                      ->latest()
                      ->get();

        return view('admin.mitra.index', compact('mitras'));
    }

    /**
     * Menyetujui (ACC) Mitra.
     */
    public function approve($id)
    {
        // Cari data berdasarkan ID tabel mitra
        $mitra = Mitra::findOrFail($id);

        // Update status sesuai enum di database
        $mitra->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Mitra berhasil disetujui.');
    }

    /**
     * Menolak Mitra.
     */
    public function reject($id)
    {
        $mitra = Mitra::findOrFail($id);

        // Update status sesuai enum di database
        $mitra->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Permohonan Mitra ditolak.');
    }
}