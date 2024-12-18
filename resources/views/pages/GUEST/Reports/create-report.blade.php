<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Keluhan</title>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e9e9e9;
        }
        .floating-buttons {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            justify-content: center;
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
        <nav aria-label="Breadcrumb bg-white p-4">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <p>Home</p>
              </li>
              <li class="breadcrumb-item">
                <a>Pengaduan</a>
              </li>
            </ol>
        </nav>
        <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-3">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="provinsi">Provinsi*</label>
                        <select class="form-control" id="provinsi" name="provinsi">
                            <option>Pilih</option>
                        </select>
                        <input type="hidden" name="provinsi_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="kota">Kota/Kabupaten*</label>
                        <select class="form-control" id="kota" name="kota">
                            <option>Pilih</option>
                        </select>
                        <input type="hidden" name="kota_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="kecamatan">Kecamatan*</label>
                        <select class="form-control" id="kecamatan" name="kecamatan">
                            <option>Pilih</option>
                        </select>
                        <input type="hidden" name="kecamatan_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="kelurahan">Kelurahan*</label>
                        <select class="form-control" id="kelurahan" name="kelurahan">
                            <option>Pilih</option>
                        </select>
                        <input type="hidden" name="kelurahan_name">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="type">Type*</label>
                        <select class="form-control" id="type" name="type">
                            <option>KEJAHATAN</option>
                            <option>PEMBANGUNAN</option>
                            <option>SOSIAL</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="detail">Detail Keluhan*</label>
                        <textarea class="form-control" id="detail" name="detail" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gambar">Gambar Pendukung*</label>
                        <input class="form-control" id="gambar" name="gambar" type="file" />
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" id="check" name="check" type="checkbox" />
                        <label class="form-check-label" for="check">
                            Laporan yang disampaikan sesuai dengan kebenaran.
                        </label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-success px-4 py-2 mt-3" type="submit">Kirim</button>
            </div>
        </form>
    </div>

    <div class="floating-buttons">
        <button class="btn">
            <a href="{{ Route('home') }}" class="text-white"><i class="fas fa-home"></i></a>
        </button>
        <button class="btn">
            <i class="fas fa-exclamation"></i>
        </button>
        <button class="btn">
            <a href="{{ Route('reports.create') }}" class="text-white"><i class="fas fa-pen"></i></a>
        </button>
    </div>

    <script>
        $(document).ready(function() {
            // Mengambil data dari API
            $.ajax({
                url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
                method: 'GET',
                success: function(provinces) {
                    provinces.forEach(function(province) {
                        $('#provinsi').append(`<option value="${province.id} - ${province.name}">${province.name}</option>`);
                    });
                }
            });

            $('#provinsi').change(function() {
                const provinsiId = $(this).val();
                const idProv = provinsiId.slice(0, 2);
                $('#kota').html('<option>Pilih</option>');
                $('#kecamatan').html('<option>Pilih</option>');
                $('#kelurahan').html('<option>Pilih</option>');

                if (provinsiId) {
                    $.ajax({
                        url: `https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${idProv}.json`,
                        method: 'GET',
                        success: function(regencies) {
                            regencies.forEach(function(regency) {
                                $('#kota').append(`<option value="${regency.id} - ${regency.name}">${regency.name}</option>`);
                            });
                        }
                    });
                }
            });

            $('#kota').change(function() {
                const kotaId = $(this).val();
                const idKota = kotaId.slice(0, 4);
                $('#kecamatan').html('<option>Pilih</option>');
                $('#kelurahan').html('<option>Pilih</option>');

                if (kotaId) {
                    $.ajax({
                        url: `https://www.emsifa.com/api-wilayah-indonesia/api/districts/${idKota}.json`,
                        method: 'GET',
                        success: function(districts) {
                            districts.forEach(function(district) {
                                $('#kecamatan').append(`<option value="${district.id} - ${district.name}">${district.name}</option>`);
                            });
                        }
                    });
                }
            });

            $('#kecamatan').change(function() {
                const kecamatanId = $(this).val();
                const idKec = kecamatanId.slice(0, 7);
                $('#kelurahan').html('<option>Pilih</option>');

                if (kecamatanId) {
                    $.ajax({
                        url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${idKec}.json`,
                        method: 'GET',
                        success: function(villages) {
                            villages.forEach(function(village) {
                                $('#kelurahan').append(`<option value="${village.id} - ${village.name}">${village.name}</option>`);
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
