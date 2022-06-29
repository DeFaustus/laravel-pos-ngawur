@extends('layouts.app')
@section('konten')
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Primary Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Warning Card</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Penjualan Hari Ini : &nbsp; {{ $hariIni }}</h5>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Penjualan Minggu Ini : &nbsp; {{ $mingguIni }}</h5>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4 mt-5">
        <div class="card-header text-center">
            <i class="fas fa-table me-1"></i>
            Chart
        </div>
        <div class="card-body">
            <div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
@endsection
@push('javascript')
    <script>
        $(document).ready(function() {
            var app = <?php echo json_encode($penMingguIni); ?>;
            const labelsssss = <?php echo json_encode($labels); ?>;
            let jumlah = [];
            app.map(elem => {
                if (labelsssss.indexOf(elem.date) != -1) {
                    jumlah.push(elem.jumlah);
                } else {
                    jumlah.push(0);
                }
            })

            const labels = labelsssss;
            const data = {
                labels: labels,
                datasets: [{
                    label: 'Penjualan 1 Minggu Terakhir',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: jumlah,
                }]
            };
            const config = {
                type: 'line',
                data: data,
                options: {}
            };
            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );
        })
    </script>
@endpush
