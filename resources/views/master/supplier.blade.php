 @extends('layouts.app')
 @section('konten')
     <div class="card mb-4 mt-5">
         <div class="card-header text-center">
             <i class="fas fa-table me-1"></i>
             Daftar Supplier
         </div>
         <div class="card-body">
             <!-- Button trigger modal -->
             <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambah-supplier">
                 Tambah Supplier
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
                         <th>Nama</th>
                         <th>Email</th>
                         <th>Daftar Barang</th>
                         <th>Aksi</th>
                     </tr>
                 </thead>
                 <tbody class="text-center">
                     @foreach ($data as $key => $item)
                         <tr>
                             <td> {{ $data->firstItem() + $key }} </td>
                             <td> {{ $item->nama }} </td>
                             <td> {{ $item->email }} </td>
                             <td>
                                 <button type="button" data-bs-toggle="modal" data-bs-target="#daftar{{ $item->id }}"
                                     class="btn btn-primary">Daftar Barang</button>
                             </td>
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
                                         <form action="{{ route('daftar-supplier.update', $item->id) }}" method="POST"
                                             enctype="multipart/form-data">
                                             @method('PATCH')
                                             @csrf
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="kategori" class="form-label">Nama Supplier :
                                                         </label>
                                                         <input type="text" name="nama"
                                                             class="form-control @error('nama') is-invalid @enderror"
                                                             value="{{ old('nama', $item->nama) }}">
                                                         @error('nama')
                                                             <span class="invalid-feedback">
                                                                 {{ $message }}
                                                             </span>
                                                         @enderror
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="mb-3">
                                                         <label for="kategori" class="form-label">Email : </label>
                                                         <input type="text" name="email"
                                                             class="form-control @error('email') is-invalid @enderror"
                                                             value="{{ old('email', $item->email) }}">
                                                         @error('email')
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
                                         <button type="submit" class="btn btn-warning">Edit Supplier</button>
                                         </form>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="modal fade" id="daftar{{ $item->id }}" tabindex="-1"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="exampleModalLabel">Daftar Barang
                                             {{ $item->nama }} </h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal"
                                             aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                         <ol>
                                             @foreach ($item->barang as $bar)
                                                 <li> {{ $bar->nama }} </li>
                                             @endforeach
                                         </ol>
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary"
                                             data-bs-dismiss="modal">Close</button>
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
                                         <form action="{{ route('daftar-supplier.destroy', $item->id) }}" method="post">
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
     <div class="modal fade" id="tambah-supplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <form action="{{ route('daftar-supplier.store') }}" method="POST" enctype="multipart/form-data">
                         @csrf
                         <div class="row">
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="kategori" class="form-label">Nama Supplier : </label>
                                     <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                         value="{{ old('nama') }}">
                                     @error('nama')
                                         <span class="invalid-feedback">
                                             {{ $message }}
                                         </span>
                                     @enderror
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="mb-3">
                                     <label for="kategori" class="form-label">Email : </label>
                                     <input type="text" name="email"
                                         class="form-control @error('email') is-invalid @enderror"
                                         value="{{ old('email') }}">
                                     @error('email')
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
                     <button type="submit" class="btn btn-success">Tambah Supplier</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 @endsection
