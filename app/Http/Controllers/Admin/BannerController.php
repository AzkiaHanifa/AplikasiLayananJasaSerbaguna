<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        // 1. Cek Jumlah Banner
        if (Banner::count() >= 3) {
            return redirect()->back()->with('error', 'Maksimal hanya boleh 3 banner!');
        }

        // 2. Validasi
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
            'title' => 'nullable|string|max:255',
        ]);

        // 3. Upload Gambar
        $imagePath = $request->file('image')->store('banners', 'public');

        // 4. Simpan ke DB
        Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil ditambahkan!');
    }

    public function destroy(Banner $banner)
    {
        // 1. Hapus File Fisik
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        // 2. Hapus dari DB
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('success', 'Banner berhasil dihapus!');
    }
}