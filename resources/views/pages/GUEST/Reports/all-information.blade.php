<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Keluhan</title>
    <link href="https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css" rel="stylesheet" integrity="sha256-V6lu+OdYNKTKTsVFBuQsyIlDiRWiOmtC8VQ8Lzdm2i4=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9e9e9;
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
    @php use Carbon\Carbon; @endphp
    <div class="container mt-5">
        <nav class="navbar mb-5 p-4 rounded-3">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-circle-info"> </i> Informasi Pengaduan ( {{ Auth::user()->email }} )
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary px-5 py-3">Logout</button>
                </form>
            </div>
        </nav>

        @if(Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <div class="accordion" id="accordionExample">
            @if ($reports->isEmpty())
                <h5 class="text-center" style="margin-top: 50px;">Anda belum membuat Pengaduan!</h5>
                <p class="text-center">Pembuatan pengaduan dapat dilakukan pada halaman berikut: <a href="{{ route('reports.create') }}">Ikuti Tautan</a></p>
            @else
                @foreach ($reports as $key => $report)
                <div class="accordion-item p-4 rounded-3">
                    <h2 class="accordion-header" id="heading-{{ $key }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}" aria-expanded="false" aria-controls="collapse-{{ $key }}">
                        Laporan Anda : {{ Carbon::parse($report->created_at)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </button>
                    </h2>
                    <div id="collapse-{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $key }}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ul class="nav nav-fill nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="fill-tab-0-{{ $key }}" data-bs-toggle="tab" href="#fill-tabpanel-0-{{ $key }}" role="tab" aria-controls="fill-tabpanel-0-{{ $key }}" aria-selected="true">Data</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="fill-tab-1-{{ $key }}" data-bs-toggle="tab" href="#fill-tabpanel-1-{{ $key }}" role="tab" aria-controls="fill-tabpanel-1-{{ $key }}" aria-selected="false">Gambar</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="fill-tab-2-{{ $key }}" data-bs-toggle="tab" href="#fill-tabpanel-2-{{ $key }}" role="tab" aria-controls="fill-tabpanel-2-{{ $key }}" aria-selected="false">Status</a>
                        </li>
                        </ul>
                        <div class="tab-content pt-5" id="tab-content-{{ $key }}">
                        <div class="tab-pane active" id="fill-tabpanel-0-{{ $key }}" role="tabpanel" aria-labelledby="fill-tab-0-{{ $key }}">
                            <p><strong>Data:</strong></p>
                            <ul>
                            <li>Tipe: {{ $report->type }}</li>
                            <li>Lokasi: {{ $report->village }}, {{ $report->subdistrict }}, {{ $report->regency }}, {{ $report->province }}</li>
                            <li>Deskripsi: {{ $report->description }}</li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="fill-tabpanel-1-{{ $key }}" role="tabpanel" aria-labelledby="fill-tab-1-{{ $key }}">
                            <p><strong>Gambar:</strong></p>
                            <center><img src="{{ Storage::url($report->image) }}" alt="Gambar Pengaduan" class="img-fluid"></center>
                        </div>
                        <div class="tab-pane" id="fill-tabpanel-2-{{ $key }}" role="tabpanel" aria-labelledby="fill-tab-2-{{ $key }}">
                            <p><strong>Status:</strong></p>

                            @php
                                $response = $report->responses; // Relasi responses diambil
                            @endphp

                            @if ($response && $response->response_status)
                                <p>{{ $response->response_status }}</p>
                            @else
                                <p>Laporan belum ditanggapi!</p>
                                <form action="{{ route('reports.delete', $report->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            @endif
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            @endif
          </div>
          <div class="floating-buttons">
            <button class="btn">
              <a href="{{ Route('home') }}" class="text-white"><i class="fas fa-home"></i></a>
            </button>
            <button class="btn">
              <a href="{{ Route('reports.showAll') }}" class="text-white"><i class="fas fa-exclamation"></i></a>
            </button>
            <button class="btn">
              <a href="{{ Route('reports.create') }}" class="text-white"><i class="fas fa-pen"></i></a>
            </button>
          </div>
    </div>
</body>
</html>
