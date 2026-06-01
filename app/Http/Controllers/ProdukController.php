<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProdukController extends Controller
{
    /**
     * Simpan gambar upload: resize ke max 800px, konversi ke WebP 80%.
     */
    private function processAndStoreImage($file): string
    {
        $manager  = new ImageManager(new Driver());
        $image    = $manager->read($file->getRealPath());

        // Resize hanya jika lebar > 800px, tinggi proporsional
        $image->scaleDown(width: 800);

        $webpData = $image->toWebp(80)->toString();
        $filename = 'thumbnails/' . uniqid('img_', true) . '.webp';

        Storage::disk('public')->put($filename, $webpData);

        return $filename;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $produksDiterima = Produk::query()->where([
            'user_id' => $userId,
            'status_verifikasi' => 'diterima'
        ])->get();

        $produksMenunggu = Produk::query()->where([
            'user_id' => $userId,
            'status_verifikasi' => 'menunggu'
        ])->get();

        $produksDitolak = Produk::query()->where([
            'user_id' => $userId,
            'status_verifikasi' => 'ditolak'
        ])->get();

        return view('seller.produk', compact('produksDiterima', 'produksMenunggu', 'produksDitolak'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('nama')->get();
        return view('seller.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'thumbnail_url' => 'nullable|url|max:2048',
        ]);

        // Pastikan setidaknya salah satu thumbnail diberikan
        if (!$request->hasFile('thumbnail') && empty($request->thumbnail_url)) {
            return back()->withErrors(['thumbnail' => 'Thumbnail wajib diisi: upload file atau masukkan link URL gambar.'])->withInput();
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            // Proses: resize 800px + konversi ke WebP 80%
            $thumbnailPath = $this->processAndStoreImage($request->file('thumbnail'));
        } elseif ($request->thumbnail_url) {
            // Simpan URL langsung ke database
            $thumbnailPath = $request->thumbnail_url;
        }

        $produk = new Produk();
        $produk->nama_produk = $request->name;
        $produk->kategori = $request->category;
        $produk->harga = $request->price;
        $produk->deskripsi = $request->description;
        $produk->gambar_produk = $thumbnailPath;
        $produk->user_id = Auth::id();
        $produk->status_verifikasi = 'menunggu';
        $produk->save();

        return redirect()->route('produk.seller')->with('success', 'Jasa atau Produk berhasil ditambahkan dan sedang menunggu verifikasi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        if ($produk->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat produk ini.');
        }

        return view('seller.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        if ($produk->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah produk ini.');
        }

        $categories = Category::where('is_active', true)->orderBy('nama')->get();
        return view('seller.edit', compact('produk', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        if ($produk->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah produk ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $produk->nama_produk = $request->name;
        $produk->kategori = $request->category;
        $produk->harga = $request->price;
        $produk->deskripsi = $request->description;

        $produk->status_verifikasi = 'menunggu';

        if ($request->hasFile('thumbnail')) {
            // Hapus gambar lama jika bukan URL eksternal
            if ($produk->gambar_produk
                && !str_starts_with($produk->gambar_produk, 'http')
                && Storage::disk('public')->exists($produk->gambar_produk)) {
                Storage::disk('public')->delete($produk->gambar_produk);
            }

            // Proses: resize 800px + konversi ke WebP 80%
            $produk->gambar_produk = $this->processAndStoreImage($request->file('thumbnail'));
        }

        $produk->save();

        return redirect()->route('produk.seller')->with('success', 'Jasa atau Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        if ($produk->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus produk ini.');
        }

        if ($produk->gambar_produk && Storage::disk('public')->exists($produk->gambar_produk)) {
            Storage::disk('public')->delete($produk->gambar_produk);
        }

        $produk->delete();

        return redirect()->route('produk.seller')->with('success', 'Produk berhasil dihapus.');
    }
}
