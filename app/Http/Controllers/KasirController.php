<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Cart;
use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index()
    {
        return view('kasir.kasir', [
            'title'     => 'Karepmu',
        ]);
    }
    public function showSelectBarang()
    {
        return response()->json([
            'barang'    => Barang::filterBarang()->get(['id', 'nama'])
        ]);
    }

    public function daftarBarang()
    {
        return response()->json([
            'barang'    => Barang::latest()->cariBarang(request('barang'))->get(['id', 'nama', 'gambar', 'harga_jual', 'stok'])
        ]);
    }
    public function tambahCart(Request $request)
    {
        $barang = Barang::find($request->id);
        try {
            Cart::updateOrCreate(['barang_id' => $barang->id], [
                'jumlah'    => 1,
                'total'     => $barang->harga_jual
            ]);
            return response()->json([
                'status'    => true,
                'message'   => 'sukses'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message'   => $e->getMessage()
            ]);
        }
    }
    public function lihatCart()
    {
        $cart = Cart::with(['barang'])->latest()->get(['id', 'barang_id', 'jumlah', 'total']);
        if ($cart->count() < 0) {
            return response()->json([
                'cart'  => "kosong"
            ]);
        }
        return response()->json([
            'status'    => true,
            'cart'      => $cart,
            'total'     => $cart->map(function ($item) {
                return $item->total;
            })->sum()
        ]);
    }
    public function updateCart(Request $request)
    {
        try {
            $total = Barang::find($request->idBarang)->get(['harga_jual', 'stok']);
            Cart::where('id', $request->idCart)->update([
                'jumlah'    => $request->jumlah,
                'total'     => intval($total[0]->harga_jual) * intval($request->jumlah)
            ]);
            return response()->json([
                'success'   => true,
                'message'   => "sukses"
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'r'     => $total,
                'message'   => $e->getMessage()
            ]);
        }
    }
    public function bayar()
    {
        try {
            $cart = Cart::all(['id', 'barang_id', 'jumlah', 'total']);
            $bayar = [];
            $id =  [];
            $caseBarang =  [];
            $jumlah = [];
            $idBarang = [];
            foreach ($cart as $key => $value) {
                array_push($id, $value->id);
                $caseBarang[] = "WHEN {$value->barang_id} THEN ?";
                $jumlah[] = $value->jumlah;
                $idBarang[] = $value->barang->id;
                $carts = [[
                    'barang_id'     => $value->barang_id,
                    'user_id'       => Auth::user()->id,
                    'jumlah'        => $value->jumlah,
                    'total'         => $value->total,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now()
                ]];
                $bayar = array_merge($carts, $bayar);
            }
            $idBarang = implode(',', $idBarang);
            $caseBarang = implode(" ", $caseBarang);
            DB::update("UPDATE barangs SET stok =  stok - CASE id {$caseBarang} END WHERE id in ({$idBarang})", $jumlah);
            History::insert($bayar);
            Cart::destroy($id);
            return response()->json([
                'sukess'    => true
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'e'     => $e->getMessage()
            ]);
        }
    }
    public function destroy(Request $request)
    {
        try {
            Cart::destroy($request->id);
            return response()->json([
                'status'    => true,
                'message'   => 'sukses'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message'   => $e->getMessage()
            ]);
        }
    }
}
