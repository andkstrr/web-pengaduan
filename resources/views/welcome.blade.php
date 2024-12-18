<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid vh-100 d-flex align-items-center bg-light">
        <div class="row w-100">
            <div class="col-md-6 d-flex align-items-center">
                <div class="px-4" style="margin-left: 90px">
                    <h1 class="display-4 fw-bold fst-italic">Pengaduan Masyarakat</h1>
                    <p class="mt-3">
                        Laporkan masalah di lingkungan Anda dengan mudah dan cepat melalui platform kami. <br>
                        Bersama, kita bisa menciptakan lingkungan yang lebih baik dan nyaman untuk semua. <br>
                        Mari berkontribusi untuk perubahan yang positif di sekitar kita!
                    </p>
                    <a class="btn btn-success px-4 py-2 mt-3" href="{{ url('/login') }}">BERGABUNG!</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 d-flex justify-content-center align-items-center">
                    <img src="assets/welcome.jpeg" class="img-fluid rounded shadow rounded-5" alt="Hero Image">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
