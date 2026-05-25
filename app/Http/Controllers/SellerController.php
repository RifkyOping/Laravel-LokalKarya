<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("seller.dashboard");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("seller.create");
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
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('produk', 'public');
        }

        \App\Models\Produk::create([
            'user_id' => $request->user()->id,
            'nama_produk' => $request->name,
            'kategori' => $request->category,
            'harga' => $request->price,
            'deskripsi' => $request->description,
            'gambar_produk' => $thumbnailPath,
            'status' => 'aktif',
            'status_verifikasi' => 'menunggu',
        ]);

        return redirect()->route('produk.seller')->with('success', 'Jasa berhasil ditambahkan dan sedang menunggu verifikasi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        return view("detailProduk");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seller $seller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seller $seller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller)
    {
        //
    }
}
