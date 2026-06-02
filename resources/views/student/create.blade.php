<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrinkto-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students Add | Laravel</title>
    <!DOCTYPE html>

    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Students Add | Laravel</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">

    </head>

<body>

    <div class="container">
        <div class="container-fluid mt-4">

            <div class="card">

                <div class="card-header">
                    Tambah Siswa
                    <a href="/student" class="btn btn-danger float-right">Kembali</a>
                </div>

                <form action="/student/add" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        @if(session('notifikasi'))
                            <div class="form-group">
                                <div class="alert alert-{{ session('type') }}">
                                    {{ session('notifikasi') }}
                                </div>
                            </div>
                        @endif


                        <div class="form-group">
                            <label>NIM <b class="text-danger">*</b></label>

                            <input type="text" id="nim" name="nim"
                                class="form-control @error('nim') is-invalid @enderror" placeholder="Masukkan NIM"
                                value="{{ old('nim') }}" required>

                            @error('nim')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>Nama <b class="text-danger">*</b></label>

                            <input type="text" id="nama" name="nama"
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan Nama"
                                value="{{ old('nama') }}" required>

                            @error('nama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label>Email <b class="text-danger">*</b></label>

                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email"
                                value="{{ old('email') }}" required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- New Line --}}
                        <div class="form-group">
                            <label for="nama">Foto <b class="text-danger">*</b></label>

                            <input required placeholder="Upload Foto" type="file" accept=".jpg,.jpeg,.png" id="foto"
                                name="foto" class="form-control @error('foto') is-invalid @enderror">

                            @error('foto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Prodi <b class="text-danger">*</b></label>

                            <select id="prodi" name="prodi" class="form-control @error('prodi') is-invalid @enderror"
                                required>
                                <option value="">- Pilih Prodi -</option>
                                <option>Teknik Informatika</option>
                                <option>Teknik Rekayasa Keamanan Siber</option>
                                <option>Teknik Rekayasa Perangkat Lunak</option>
                            </select>

                            @error('prodi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>


                    <div class="card-footer">
                        <a href="/student" class="btn btn-danger">Batal</a>
                        <button type="reset" class="btn btn-warning">Reset</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('foto').addEventListener('change', function () {

            const file = this.files[0];

            if (!file) {
                return;
            }

            // validasi tipe file
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

            // validasi ukuran file (2 MB)
            const maxSize = 2 * 1024 * 1024;

            // cek tipe file
            if (!allowedTypes.includes(file.type)) {

                alert('File harus berupa JPG, JPEG, atau PNG!');

                this.value = '';

                return;
            }

            // cek ukuran file
            if (file.size > maxSize) {

                alert('Ukuran file maksimal 2 MB!');

                this.value = '';

                return;
            }

        });
    </script>

</body>

</html>