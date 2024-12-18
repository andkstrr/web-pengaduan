<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9e9e9;
        }
        .timeline-line {
            border-left: 3px solid #6c757d;
            padding-left: 15px;
        }
        .timeline-item {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar mb-5 p-4 rounded-3 bg-white">
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

        <div class="row">
            <div class="col-md-8">
                <div class="card p-4 mb-3">
                    <h5 class="mb-3"><b>{{ $reports->user->email }}</b></h5>
                    <p class="text-muted">
                        {{ $reports->created_at->format('d F Y') }} | <span class="btn btn-success">ON PROCESS</span>
                    </p>
                    <h6 class="fw-bold">
                        {{ strtoupper($reports->village) }}, {{ strtoupper($reports->subdistrict) }}, {{ strtoupper($reports->regency) }}, {{ strtoupper($reports->province) }}
                    </h6>
                    <p>{{ $reports->description }}</p>
                    <img src="{{ Storage::url($reports->image) }}" alt="Foto Pengaduan" class="img-fluid rounded mt-3">
                    <div class="d-flex mt-5 gap-2">
                        <a href="{{ route('responses.home' )}}" class="btn btn-success">Kembali</a>
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#progressModal">
                            + Tambah Progress
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-3">
                    <h5 class="fw-bold mb-3">Progress Perbaikan</h5>
                    <div class="timeline-line">
                        <div class="timeline-item">
                            <p class="mb-1"><b></b> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="progressModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Progress</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Progress</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success justify-content-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
