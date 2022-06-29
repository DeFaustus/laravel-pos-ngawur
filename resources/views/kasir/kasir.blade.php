 @extends('layouts.app')
 @section('konten')
     <div class="card mb-4 mt-5">
         <div class="card-header text-center">
             <i class="fas fa-table me-1"></i>
             Iyo
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col-4">
                     <select class="form-control barang-select" name="state" id="cari-barang">
                         <option value="">---Pilih Barang---</option>
                     </select>
                     <h3 class="my-3" id="total-cart"></h3>
                     <div id="bayar-btn"></div>
                     <div class="row mt-4" id="daftar-cart">
                     </div>
                 </div>
                 <div class="col-8">
                     <div class="row" id="daftar_barang">

                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
 @push('javascript')
     <script src="{{ asset('js/script.js') }}"></script>
 @endpush
