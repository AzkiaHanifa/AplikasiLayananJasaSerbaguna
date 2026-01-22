<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;      // Import Model Job
use App\Models\Category; // Import Model Category (PENTING untuk Tab Filter)
use App\Models\Banner;   // Import Model Banner
use Illuminate\Support\Facades\DB;

class LandingController extends Controller
{
    /**
     * Menampilkan halaman utama website (Root).
     */
    public function index()
    {
        $jobs = Job::with('category')
            ->where('is_active', true)
            ->withAvg([
                'transaksi as avg_rating' => function ($q) {
                    $q->join(
                            'ulasan_jasa',
                            'transaksi_jasa.id',
                            '=',
                            'ulasan_jasa.transaksi_jasa_id'
                        )
                    ->where('transaksi_jasa.status', 'selesai');
                }
            ], 'ulasan_jasa.rating')
            ->latest()->paginate(16)
            ;

        $categories = Category::all();
        $banners = Banner::all();

        return view('landing.index', compact('jobs', 'categories', 'banners'));
    }
    public function show($id)
    {
        $job = Job::with(['category', 'user'])->findOrFail($id);

        $ulasan = \App\Models\UlasanJasa::whereHas('transaksi', function ($q) use ($id) {
                $q->where('job_id', $id)
                ->where('status', 'selesai');
            })
            ->with('transaksi.user')
            ->latest()
            ->get();

        $avgRating = round($ulasan->avg('rating') ?? 0, 1);
        $totalUlasan = $ulasan->count();

        return view('landing.show', compact(
            'job',
            'ulasan',
            'avgRating',
            'totalUlasan'
        ));
    }

    public function search(Request $request)
    {
        $keyword = $request->q;

        $jobs = Job::where('title', 'LIKE', '%' . $keyword . '%')
                    ->latest()
                    ->paginate(16)
                    ->withQueryString();

        return view('landing.search', compact('jobs', 'keyword'));
    }
} // End Class
