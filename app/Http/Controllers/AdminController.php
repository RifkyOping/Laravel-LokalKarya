<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SellerProfile;
use App\Models\Produk;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalSeller = User::query()->where('role', 'seller')->count();
        $pendingSeller = SellerProfile::query()->where('status_verifikasi', 'menunggu')->count();
        $pendingProduk = Produk::query()->where('status_verifikasi', 'menunggu')->count();

        // Ambil aktivitas terbaru (5 seller baru & 5 produk baru)
        $recentSellers = User::query()->where('role', 'seller')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'tipe' => 'seller',
                    'judul' => 'Pengguna Baru Mendaftar',
                    'deskripsi' => $user->name . ' mendaftar sebagai kreator baru.',
                    'waktu' => $user->created_at,
                ];
            });

        $recentProduks = Produk::query()->with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($produk) {
                $sellerName = $produk->user ? $produk->user->name : 'Kreator';
                return [
                    'tipe' => 'produk',
                    'judul' => 'Jasa Baru Ditambahkan',
                    'deskripsi' => $produk->nama_produk . ' ditambahkan oleh ' . $sellerName . ' dan menunggu verifikasi.',
                    'waktu' => $produk->created_at,
                ];
            });

        $recentActivities = $recentSellers->concat($recentProduks)
            ->sortByDesc('waktu')
            ->take(5);

        $totalKategori = Category::count();

        return view('admin.dashboard', compact('totalSeller', 'pendingSeller', 'pendingProduk', 'recentActivities', 'totalKategori'));
    }

    public function seller()
    {
        // Menampilkan seller yang memiliki profile, diurutkan dari yang statusnya 'menunggu' terlebih dahulu
        $sellers = SellerProfile::with('user')
            ->orderByRaw("status_verifikasi = 'menunggu' DESC")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.seller', compact('sellers'));
    }

    public function produk()
    {
        // Menampilkan semua produk beserta data user pembuatnya, diurutkan dari 'menunggu'
        $produks = Produk::with('user')
            ->orderByRaw("status_verifikasi = 'menunggu' DESC")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.produk', compact('produks'));
    }

    // Action untuk menyetujui seller
    public function setujuiSeller(SellerProfile $sellerProfile)
    {
        $sellerProfile->update(['status_verifikasi' => 'diterima']);
        return redirect()->back()->with('success', 'Akun Seller berhasil disetujui.');
    }

    // Action untuk menolak seller
    public function tolakSeller(SellerProfile $sellerProfile)
    {
        $sellerProfile->update(['status_verifikasi' => 'ditolak']);
        return redirect()->back()->with('success', 'Akun Seller berhasil ditolak.');
    }

    // Action untuk menghapus akun seller beserta semua datanya
    public function destroySeller(SellerProfile $sellerProfile)
    {
        $user = $sellerProfile->user;

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Hapus semua produk & gambar milik seller ini
        $produkList = Produk::where('user_id', $user->id)->get();
        foreach ($produkList as $produk) {
            if ($produk->gambar_produk
                && !str_starts_with($produk->gambar_produk, 'http')
                && Storage::disk('public')->exists($produk->gambar_produk)) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }
            $produk->delete();
        }

        // Hapus foto profil seller jika ada
        if ($sellerProfile->foto
            && !str_starts_with($sellerProfile->foto, 'http')
            && Storage::disk('public')->exists($sellerProfile->foto)) {
            Storage::disk('public')->delete($sellerProfile->foto);
        }

        $sellerName = $user->name;

        // Hapus SellerProfile & User (cascade)
        $sellerProfile->delete();
        $user->delete();

        return redirect()->route('admin.seller')->with('success', "Akun seller '{$sellerName}' beserta semua datanya berhasil dihapus.");
    }

    // Action untuk menyetujui produk
    public function setujuiProduk(Produk $produk)
    {
        $produk->update(['status_verifikasi' => 'diterima']);
        return redirect()->back()->with('success', 'Jasa atau Produk berhasil disetujui.');
    }

    // Action untuk menolak produk
    public function tolakProduk(Produk $produk)
    {
        $produk->update(['status_verifikasi' => 'ditolak']);
        return redirect()->back()->with('success', 'Jasa atau Produk berhasil ditolak.');
    }

    // Action untuk menghapus produk
    public function destroyProduk(Produk $produk)
    {
        if ($produk->gambar_produk && \Illuminate\Support\Facades\Storage::disk('public')->exists($produk->gambar_produk)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->gambar_produk);
        }
        $produk->delete();
        return redirect()->back()->with('success', 'Jasa atau Produk berhasil dihapus.');
    }

    // ─── Manajemen Kategori ──────────────────────────────────────────

    public function kategori()
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.kategori', compact('categories'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100',
        ]);

        $slug = $request->slug
            ? Str::slug($request->slug, '-')
            : Str::slug($request->nama, '-');

        // Pastikan slug unik
        $originalSlug = $slug;
        $i = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        Category::create(['nama' => $request->nama, 'slug' => $slug, 'is_active' => true]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function updateKategori(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'slug' => 'nullable|string|max:100',
        ]);

        $slug = $request->slug
            ? Str::slug($request->slug, '-')
            : Str::slug($request->nama, '-');

        // Pastikan slug unik (kecuali milik diri sendiri)
        $originalSlug = $slug;
        $i = 1;
        while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        $category->update(['nama' => $request->nama, 'slug' => $slug]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function toggleKategori(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);
        $status = $category->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Kategori berhasil {$status}.");
    }

    public function destroyKategori(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}
