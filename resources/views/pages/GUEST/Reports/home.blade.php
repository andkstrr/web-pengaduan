<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Artikel Pengaduan</title>
  <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      background-color: #e9e9e9;
    }
    .card {
      margin-bottom: 20px;
    }
    .info-box {
      background-color: #f8f9fa;
      padding: 15px;
      border-radius: 5px;
    }
    .info-box h5 {
      margin-bottom: 15px;
    }
    .info-box ul {
      padding-left: 20px;
    }
    .info-box ul li {
      margin-bottom: 10px;
    }
    .info-box a {
      color: #007bff;
    }
    .floating-buttons {
        position: fixed;
        bottom: 250px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .floating-buttons .btn {
        background-color: #004d40;
        color: white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  @if(Session::get('success'))
    <div class="alert alert-success">
      {{ Session::get('success') }}
    </div>
  @endif

  <form action="{{ route('search') }}" method="GET">
    <div class="input-group mb-3">
            <select aria-label="Pilih" class="form-select" id="selectProvinces" name="province">
            <option value="" disabled selected>Pilih Provinsi</option>
            </select>
            <button class="btn btn-success" type="submit">Cari</button>
    </div>
  </form>

  <div class="row">
    <div class="col-md-8">
      @foreach ($reports as $report)
      <div class="card mb-3 p-3">
        <div class="row g-0 align-items-center">
          <div class="col-md-4">
            <img src="{{ Storage::url($report->image) }}" alt="Foto Pengaduan" class="img-fluid rounded"/>
          </div>
          <div class="col-md-8">
            <div class="card-body p-3">
              <a class="btn btn-light btn-sm float-end" href="{{ route('reports.vote', $report->id ) }}">
                <i class="fas fa-heart"></i> <br>Vote
              </a>
              <h4 class="card-title">
                <a class="text-dark" href="{{ route('reports.comment', $report->id ) }}">{{ Str::limit($report->description, 50) }}</a>
              </h4>
              <p class="card-text">
                <i class="fas fa-eye"></i> {{ $report->viewers }}
                <i class="fas fa-heart"></i> {{ count(json_decode($report->votes ?? '[]')) }}
              </p>
              <h6 class="card-text">
                <small class="text-muted">{{ $report->user->email }}</small>
              </h6>
              <h6 class="card-text">
                <small class="text-muted">{{ $report->created_at->diffForHumans() }}</small>
              </h6>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="col-md-4">
      <div class="info-box">
        <h5><i class="fas fa-info-circle"></i> Informasi Pembuatan Pengaduan</h5>
        <ul>
          <li>Pengaduan bisa dibuat hanya jika Anda telah membuat akun sebelumnya.</li>
          <li>Keseluruhan data pada pengaduan bernilai BENAR dan DAPAT DIPERTANGGUNG JAWABKAN.</li>
          <li>Seluruh bagian data perlu diisi.</li>
          <li>Pengaduan Anda akan ditanggapi dalam 2x24 Jam.</li>
          <li>Periksa tanggapan kami pada Dashboard setelah Anda login.</li>
          <li>Pembuatan pengaduan dapat dilakukan pada halaman berikut:
            <a href="{{ route('reports.create') }}">Ikuti Tautan</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="floating-buttons">
  <a class="btn btn-success btn-lg" href="{{ route('home') }}"><i class="fas fa-home"></i></a>
  <a class="btn btn-success btn-lg" href="{{ route('reports.showAll')}}"><i class="fas fa-exclamation"></i></a>
  <a class="btn btn-success btn-lg" href="{{ route('reports.create') }}"><i class="fas fa-pen"></i></a>
</div>

<script crossorigin="anonymous" integrity="sha384-oBqDVmMz4fnFO9gybBogGz1p6U2eBz2y5l5/5y5Zp6B4p4p1F8K4l5F5l5F5l5F5" src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script crossorigin="anonymous" integrity="sha384-oBqDVmMz4fnFO9gybBogGz1p6U2eBz2y5l5/5y5Zp6B4p4p1F8K4l5F5l5F5l5F5" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    // Mengambil data dari API
    $.ajax({
      url: "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json",
      type: "GET",
      dataType: "json",
      success: function(data) {
        data.forEach(function(provinsi) {
          $('#selectProvinces').append(
            `<option value="${provinsi.name}">${provinsi.name}</option>`
          );
        });
      },
      error: function() {
        alert('Terjadi kesalahan saat mengambil data API');
      }
    });
  });
</script>
</body>
</html>
