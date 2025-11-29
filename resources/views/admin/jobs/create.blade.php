<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Lowongan Pekerjaan Baru</title>
</head>
<body>
    <h1>Dashboard Admin - Tambah Job Baru</h1>

    <form method="POST" action="{{ route('admin.jobs.store') }}">
        @csrf
        
        <div>
            <label for="title">Judul Pekerjaan:</label><br>
            <input type="text" name="title" id="title" required size="50">
            <hr>
        </div>

        <div>
            <label for="company">Nama Perusahaan:</label><br>
            <input type="text" name="company" id="company" required size="50">
            <hr>
        </div>

        <div>
            <label for="category_id">Kategori:</label><br>
            <select name="category_id" id="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <hr>
        </div>
        
        <div>
            <label for="type">Tipe:</label><br>
            <select name="type" id="type">
                <option value="Full Time">Full Time</option>
                <option value="Part Time">Part Time</option>
                <option value="Freelance">Freelance</option>
            </select>
            <hr>
        </div>

        <div>
            <label for="location">Lokasi:</label><br>
            <input type="text" name="location" id="location" required size="50">
            <hr>
        </div>
        
        <div>
            <input type="checkbox" name="is_active" id="is_active" value="1" checked>
            <label for="is_active">Aktif (Langsung dipublikasikan)</label>
            <hr>
        </div>

        <div>
            <button type="submit">Simpan Job</button>
        </div>
    </form>
</body>
</html>