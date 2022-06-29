<?php

namespace App\Http\Controllers;

use App\Models\Supplier as ModelsSupplier;
use Illuminate\Http\Request;

class Supplier extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.supplier', [
            'title'     => 'Daftar Supplier',
            'data'      => ModelsSupplier::with('barang')->paginate(5)
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
    public function store(Request $request)
    {
        $validate = $request->validate([
            'email'     => 'required|email',
            'nama'      => 'required'
        ]);
        ModelsSupplier::create($validate);
        return redirect()->to('/master/daftar-supplier')->with('message', "sukess Input supplier");
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
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama'      => 'required',
            'email'     => 'required|email'
        ]);
        ModelsSupplier::where('id', $id)->update($validate);
        return redirect()->to('/master/daftar-supplier')->with('message', "sukess Edit supplier");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
