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
                    <h1 class="display-4 fw-bold mb-4 fst-italic">Login</h1>
                    <form id="authForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Masukkan Email :</label>
                            <input type="email" id="email" name="email" class="form-control" style="width: 600px;" required>
                            @if (Session::get('failed'))
                                <div id="emailHelp" class="form-text text-danger">{{ Session::get('failed') }}</div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Masukkan Password :</label>
                            <input type="password" id="password" name="password" class="form-control w-100" required>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <!-- Tombol Buat Akun -->
                            <button type="button" onclick="setAction('register')" class="btn btn-outline-light px-4 py-2 text-black">Buat Akun</button>
                            <!-- Tombol Login -->
                            <button type="button" onclick="setAction('login')" class="btn btn-success px-4 py-2">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h-100 d-flex justify-content-center align-items-center">
                    <img src="assets/login.jpeg" class="img-fluid rounded-5 shadow" alt="Hero Image">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setAction(action) {
            // Mengatur aksi form sesuai dengan tombol yang diklik
            const form = document.getElementById('authForm');
            if (action === 'login') {
                form.action = "{{ route('login') }}";
            } else {
                form.action = "{{ route('register') }}";
            }
            form.submit();
        }
    </script>
</body>
</html>
