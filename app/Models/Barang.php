<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function scopeCariBarang($query, $id)
    {
        $cart = [];
        foreach (Cart::all(['barang_id']) as $key => $value) {
            array_push($cart, $value->barang_id);
        }
        $query->when($id ?? false, function ($q) use ($id) {
            $q->where('id', $id);
        });
        return $query->whereNotIn('id', $cart);
    }
    public static function scopeFilterBarang($query)
    {
        $cart = [];
        foreach (Cart::all(['barang_id']) as $key => $value) {
            array_push($cart, $value->barang_id);
        }
        return $query->whereNotIn('id', $cart);
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class, 'barang_id');
    }
    public function getGambarBarang()
    {
        return Storage::url('gambar/' . $this->gambar);
    }
}
