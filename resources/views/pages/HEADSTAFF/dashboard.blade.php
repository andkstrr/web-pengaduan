<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Pengaduan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Larapex Charts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #e9e9e9;
    }
</style>
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar mb-5 p-4 rounded-3 bg-white">
            <div class="container">
                <a class="navbar-brand">
                    <i class="fas fa-circle-info"> </i> Kelola Akun
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-secondary px-5 py-3">Logout</button>
                </form>
            </div>
        </nav>
        <div class="main-card d-flex justify-content-center">
            <div class="card bg-white p-5 w-50">
                <h5 class="mb-2 fw-bold">Akun Staff</h5>
                <table class="table table-bordered w-100">
                    <thead>
                    <tr class="">
                        <th scope="col">#</th>
                        <th scope="col">Email</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $index => $staff)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>
                                <form action="" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary">Reset</button>
                                </form>
                                <form action="{{ route('headstaff.delete', $staff->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card bg-white p-5 w-50">
                <h5 class="mb-2 fw-bold">Buat Akun Staff</h5>
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <form action="{{ route('headstaff.store' )}}" method="POST">
                    @csrf
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <label for="password" class="form-label">Password :</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <button type="submit" class="btn btn-success mt-3">Buat Akun</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
