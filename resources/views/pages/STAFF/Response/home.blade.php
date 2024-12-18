<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Data Keluhan</title>
    <link href="https://cdn.jsdelivr.net/npm/fastbootstrap@2.2.0/dist/css/fastbootstrap.min.css" rel="stylesheet" integrity="sha256-V6lu+OdYNKTKTsVFBuQsyIlDiRWiOmtC8VQ8Lzdm2i4=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9e9e9;
        }
    </style>
</head>
<body>
    @php use Carbon\Carbon; @endphp
    <div class="container mt-5">
        <nav class="navbar mb-5 p-4 rounded-3">
            <div class="container">
                <a class="navbar-brand">
                    <i class="fas fa-circle-info"> </i> Informasi Pengaduan
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary px-5 py-3">Logout</button>
                </form>
            </div>
        </nav>

        @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif

        <div class="table-responsive px-5 py-5 bg-white rounded-3">
            <form action="{{ route('responses.export-all') }}" method="GET">
                <div class="d-flex justify-content-end dropdown">
                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Export (.xlsx)</button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="dropdown-item" href="{{ route('responses.export-all') }}">Seluruh Data</a></li>
                        <li><a type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#byDate">Berdasarkan Tanggal</a></li>
                    </ul>
                </div>
            </form>

            <table class="table table-hover table-borderless">
                <thead>
                    <th>Gambar & Pengirim</th>
                    <th>Lokasi & Tanggal</th>
                    <th>Deskripsi</th>
                    <th>
                        <a href="{{ route('responses.home', ['sort' => $sortOrder === 'desc' ? 'asc' : 'desc']) }}" style="text-description: none; color: black">
                        Jumlah Vote
                        <i class="fa {{ $sortOrder === 'desc' ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                    </th>
                    <thead></th>
                </thead>
                <tbody class="table-group-divider rounded-3">
                    @foreach($reports as $report)
                    <tr>
                        <td class="d-flex align-items-center gap-3">
                            <span class="avatar" data-bs-toggle="modal" data-bs-target="#modalFoto{{ $report->id }}">
                            <img src="{{ Storage::url($report->image) }}" alt="Foto Pengaduan"></span>
                            <a class="text-primary">{{ $report->user->email }}</a>
                        </td>
                        <td>{{ $report->village }}, {{$report->subdistrict }}, {{ $report->regency }}, {{ $report->province }}, <br>
                            {{ Carbon::parse($report->created_at)->locale('id')->isoFormat('D MMMM Y') }}
                        </td>
                        <td>{{ $report->description }}</td>
                        <td>{{ count(json_decode($report->votes ?? '[]')) }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                  Aksi
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                  <li>
                                    <a class="dropdown-item" href="{{ route('responses.status', ['id' => $report->id] )}}">Tindak Lanjut</a>
                                  </li>
                                  <li><a class="dropdown-item" href="#">Tolak</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                    {{-- Modal Foto Pengaduan --}}
                    <div class="modal fade" id="modalFoto{{ $report->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ Storage::url($report->image) }}" alt="Foto Pengaduan" class="img-fluid"></span>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Berdasarkan Tanggal --}}
    <div class="modal fade" tabindex="-1" id="byDate" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Export (.xlsx)</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="{{ route('responses.export-date') }}" method="GET" id="exportForm">
                <div class="mb-3">
                  <label for="date" class="form-label">Pilih Tanggal</label>
                  <input type="date" class="form-control" id="date" name="date" required>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-subtle" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" onclick="closeModalAndExport(this)">Export</button>
                </form>
            </div>
          </div>
        </div>
    </div>

   <script>
        function closeModalAndExport(button) {
            // Tutup modal
            const modal = button.closest('.modal');
            const bootstrapModal = bootstrap.Modal.getInstance(modal);
            bootstrapModal.hide();

            // Tunggu 1 detik sebelum submit form
            setTimeout(() => {
                button.form.submit();
            }, 1000);
    }
   </script>
</body>
</html>
