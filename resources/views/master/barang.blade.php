 @extends('layouts.app')
 @section('konten')
     <div class="card mb-4 mt-5">
         <div class="card-header text-center">
             <i class="fas fa-table me-1"></i>
             Daftar Barang
         </div>
         <div class="card-body">
             @if ($errors->any())
                 <div class="alert alert-danger">
                     <p><strong>Opps Something went wrong</strong></p>
                     <ul>
                         @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
             @endif
             <!-- Button trigger modal -->
             <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambah-barang">
                 Tambah Barang
             </button>
             @if (session('message'))
                 <div class="alert alert-success" role="alert">
                     {{ session('message') }}
                 </div>
             @endif
             <table class="table table-striped" class="text-center">
                 <thead class="text-center">
                     <tr>
                         <th>No</th>
                         <th>Supplier</th>
                         <th>Gambar</th>
                         <th>Nama Barang</th>
                         <th>Harga beli</th>
                         <th>Harga Jual</th>
                         <th>Kategori</th>
                         <th>Stok</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
                 <tbody class="text-center">
                     @foreach ($data as $key => $item)
                         <tr>
                             <td> {{ $data->firstItem() + $key }} </td>
                             <td> {{ $item->suppliers->nama }} </td>
                             <td><img src=" {{ $item->getGambarBarang() }} " width="100" height="100" alt="" srcset="">
                             </td>
                             <td> {{ $item->nama }} </td>
                             <td> {{ $item->harga_beli }} </td>
                             <td> {{ $item->harga_jual }} </td>
                             <td> {{ $item->kategori->nama }} </td>
                             <td> {{ $item->stok }} </td>
                             <td>
                                 <button type="button" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id }}"
                                     class="btn btn-warning">Edit</button>
                                 <button type="button" data-bs-toggle="modal" data-bs-target="#delete{{ $item->id }}"
                                     class="btn btn-danger">Hapus</button>
                             </td>
                         </tr>
                         <div class="modal fade" id="edit{{ $item->id }}" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog modal-lg">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                         <form action="{{ route('daftar-barang.update', $item->id) }}" method="POST"
                                             enctype="multipart/form-data">
                                             @method('PATCH')
                                             @csrf
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="supplier" class="form-label">supplier : </label>
                                                         <select class="form-control" id="supplier" name="supplier_id">
                                                             <option value="">---select---</option>
                                                             @foreach ($supplier as $sup)
                                                                 <option
                                                                     {{ $sup->id == $item->supplier_id ? 'selected' : '' }}
                                                                     value=" {{ $sup->id }}">
                                                                     {{ $sup->nama }}
                                                                 </option>
                                                             @endforeach
                                                         </select>
                                                         @error('supplier_id')
                                                             <span class="invalid-feedback">
                                                                 {{ $message }}
                                                             </span>
                                                         @enderror
                                                     </div>
                                                     <div class="mb-3">
                                                         <label for="kategori" class="form-label">Kategori : </label>
                                                         <select class="form-control" id="kategori" name="kategori_id">
                                                             <option value="">---select---</option>
                                                             @foreach ($kategori as $kat)
                                                                 <option
                                                                     {{ $item->kategori_id == $kat->id ? 'selected' : '' }}
                                                                     value=" {{ $kat->id }} ">
                                                                     {{ $kat->nama }} </option>
                                                             @endforeach
                                                         </select>
                                                         @error('kategori_id')
                                                             <span class="invalid-feedback">
                                                                 {{ $message }}
                                                             </span>
                                                         @enderror
                                                     </div>
                                                     <div class="mb-3">
                                                         <label for="gambar">Masukkan Gambar</label>
                                                         <input type="file" name="gambar" class="form-control">
                                                         @error('gambar')
                                                             <span class="invalid-feedback">
                                                                 {{ $message }}
                                                             </span>
                                                         @enderror
                                                         <img src=" {{ url('storage/gambar', $item->gambar) }}"
                                                             width="100" height="100" alt="" srcset="">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="kategori" class="form-label">Nama Barang : </label>
                                                         <input type="text" name="nama"
                                                             class="form-control @error('nama') is-invalid @enderror"
                                                             value="{{ old('nama', $item->nama) }}">
                                                         @error('nama')
                                                             <span class="invalid-feedback">
                                                                 {{ $message }}
                                                             </span>
                                                         @enderror
                                                     </div>
                                                     <div class="mb-3">
                                                         <label for="kategori" class="form-label">Harga Beli :
                                                         </label>
                                                         <input type="number" name="harga_beli" id=""
                                                             class="form-control @error('harga_beli') is-invalid @enderror"
                                                             value="{{ old('harga_beli', $item->harga_beli) }}">
                                                         @error('harga_beli')
                                                             <span class="invalid-feedback">
                                                                 {{ $message }}
                                                             </span>
                                                         @enderror
                                                     </div>
                                                     <div class="mb-3">
                                                         <label for="kategori" class="form-label">Harga Jual :
                                                         </label>
                                                         <input type="number" name="harga_jual" id=""
                                                             class="form-control @error('harga_jual') is-invalid @enderror"
                                                             value="{{ old('harga_jual', $item->harga_jual) }}">
                                                         @error('harga_jual')
                                                             <span class="invalid-feedback">
                                                                 {{ $message }}
                                                             </span>
                                                         @enderror
                                                     </div>
                                                     <div class="mb-3">
                                                         <label for="kategori" class="form-label">Stok :
                                                         </label>
                                                         <input type="number" name="stok" id=""
                                                             class="form-control @error('stok') is-invalid @enderror"
                                                             value="{{ old('stok', $item->stok) }}">
                                                         @error('stok')
                                                             <span class="invalid-feedback">
                                                                 {{ $message }}
                                                             </span>
                                                         @enderror
                                                     </div>
                                                 </div>
                                             </div>
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary"
                                             data-bs-dismiss="modal">Close</button>
                                         <button type="submit" class="btn btn-warning">Edit Barang</button>
                                         </form>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabel">Yakin Menghapus ? </h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                         <form action="{{ route('daftar-barang.destroy', $item->id) }}" method="post">
                                             @csrf
                                             @method('DELETE')
                                             {{ $item->nama }}
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary"
                                             data-bs-dismiss="modal">Close</button>
                                         <button type="submit" class="btn btn-danger">Hapus</button>
                                         </form>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     @endforeach
                 </tbody>
             </table>
             {{ $data->links() }}
         </div>
     </div>

     <!-- Modal -->
     <div class="modal fade" id="tambah-barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form action="{{ route('daftar-barang.store') }}" method="POST" enctype="multipart/form-data">
                         @csrf
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="supplier" class="form-label">supplier : </label>
                                     <select class="form-control" id="supplier" name="supplier_id">
                                         <option value="">---select---</option>
                                         @foreach ($supplier as $sup)
                                             <option value=" {{ $sup->id }} "> {{ $sup->nama }} </option>
                                         @endforeach
                                     </select>
                                     @error('supplier_id')
                                         <span class="invalid-feedback">
                                             {{ $message }}
                                         </span>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label for="kategori" class="form-label">Kategori : </label>
                                     <select class="form-control" id="kategori" name="kategori_id">
                                         <option value="">---select---</option>
                                         @foreach ($kategori as $kat)
                                             <option value=" {{ $kat->id }} "> {{ $kat->nama }} </option>
                                         @endforeach
                                     </select>
                                     @error('kategori_id')
                                         <span class="invalid-feedback">
                                             {{ $message }}
                                         </span>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label for="gambar">Masukkan Gambar</label>
                                     <input type="file" name="gambar" class="form-control">
                                     @error('gambar')
                                         <span class="invalid-feedback">
                                             {{ $message }}
                                         </span>
                                     @enderror
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="kategori" class="form-label">Nama Barang : </label>
                                     <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                         value="{{ old('nama') }}">
                                     @error('nama')
                                         <span class="invalid-feedback">
                                             {{ $message }}
                                         </span>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label for="kategori" class="form-label">Harga Beli : </label>
                                     <input type="number" name="harga_beli" id=""
                                         class="form-control @error('harga_beli') is-invalid @enderror"
                                         value="{{ old('harga_beli') }}">
                                     @error('harga_beli')
                                         <span class="invalid-feedback">
                                             {{ $message }}
                                         </span>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label for="kategori" class="form-label">Harga Jual : </label>
                                     <input type="number" name="harga_jual" id=""
                                         class="form-control @error('harga_jual') is-invalid @enderror"
                                         value="{{ old('harga_jual') }}">
                                     @error('harga_jual')
                                         <span class="invalid-feedback">
                                             {{ $message }}
                                         </span>
                                     @enderror
                                 </div>
                                 <div class="mb-3">
                                     <label for="kategori" class="form-label">Stok : </label>
                                     <input type="number" name="stok" id=""
                                         class="form-control @error('stok') is-invalid @enderror"
                                         value="{{ old('stok') }}">
                                     @error('stok')
                                         <span class="invalid-feedback">
                                             {{ $message }}
                                         </span>
                                     @enderror
                                 </div>
                             </div>
                         </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-success">Tambah Barang</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 @endsection
