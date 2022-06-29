<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang as ModelsBarang;
use App\Models\Kategori;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Barang extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.barang', [
            'title'     => 'Daftar Barang',
            'data'      => ModelsBarang::with(['suppliers', 'kategori'])->latest()->paginate(10),
            'kategori'  => Kategori::all(),
            'supplier'  => Supplier::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarangRequest $request)
    {
        $validated = $request->validated();
        $validated['gambar'] = $request->file('gambar')->hashName();
        Storage::putFileAs('public/gambar', $request->file('gambar'), $validated['gambar']);
        ModelsBarang::create($validated);
        return redirect()->to('/master/daftar-barang')->with('message', "sukess Tambah barang");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBarangRequest $request, $id)
    {
        $validated = $request->validated();
        $barang = ModelsBarang::find($id);
        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'image|mimes:jpg,png,jpeg'
            ]);
            $validated['gambar'] = $request->file('gambar')->hashName();
            Storage::delete('public/gambar/' . $barang->gambar);
            Storage::putFileAs('public/gambar', $request->file('gambar'), $validated['gambar']);
        }
        ModelsBarang::where('id', $id)->update($validated);
        return redirect()->to('/master/daftar-barang')->with('message', "sukess Edit barang");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = ModelsBarang::find($id);
        Storage::delete('public/gambar/' . $barang->gambar);
        $barang->delete();
        return redirect()->to('/master/daftar-barang')->with('message', "sukess Hapus barang");
    }
}
