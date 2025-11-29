<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List Lowongan Pekerjaan</title>
</head>
<body>
    <h1>Dashboard Admin - List Lowongan Pekerjaan</h1>

    @if(session('success'))
        <div style="padding: 10px; border: 1px solid green; background-color: #e6ffe6; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
    
    <p><a href="{{ route('admin.jobs.create') }}">Tambah Job Baru</a></p>

    <fieldset style="border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
        <legend>Filter & Pencarian</legend>
        <form method="GET" action="{{ route('admin.jobs.index') }}">
            
            <label for="category">Kategori:</label>
            <select name="category" id="category">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->slug }}" 
                            {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            
            <label for="keyword">Keyword:</label>
            <input type="text" name="keyword" id="keyword" placeholder="Cari Judul..." value="{{ request('keyword') }}">
            
            <button type="submit">Cari / Filter</button>
            <a href="{{ route('admin.jobs.index') }}"><button type="button">Reset Filter</button></a>
        </form>
    </fieldset>

    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul & Perusahaan</th>
                <th>Kategori</th>
                <th>Tipe & Lokasi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jobs as $job)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    <b>{{ $job->title }}</b><br>
                    <small>({{ $job->company }})</small>
                </td>
                <td>{{ $job->category->name ?? 'N/A' }}</td>
                <td>{{ $job->type }} ({{ $job->location }})</td>
                <td style="text-align: center;">
                    @if($job->is_active)
                        <span style="color: green; font-weight: bold;">AKTIF</span>
                    @else
                        <span style="color: red;">TUTUP</span>
                    @endif
                </td>
                <td style="text-align: center;">
                    <a href="{{ route('admin.jobs.edit', $job) }}">Edit</a> |
                    <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" style="color: red; background: none; border: none; cursor: pointer; padding: 0;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Belum ada data pekerjaan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div>
        {{ $jobs->links() }}
    </div>

</body>
</html>