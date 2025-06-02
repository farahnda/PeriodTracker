{{-- resources/views/profiles/index.blade.php --}}
@extends('layouts.nav')
@section('title', 'Profiles')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center my-4">Daftar Profile</h3>
    <hr>
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body" style="color: #3C5294; background-color: #EBDBD3; ">
            <a href="{{ route('profiles.create') }}" class="btn btn-success mb-3">TAMBAH PROFILE</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Tanggal Lahir</th>
                        <th>Login Terakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($profiles as $profile)
                    <tr>
                        <td>{{ $profile->id }}</td>
                        <td>{{ $profile->name }}</td>
                        <td>{{ $profile->email }}</td>
                        <td>{{ $profile->birth_date ?? '-' }}</td>
                        <td>{{ $profile->last_login}}</td>
                        <td class="text-center">
                            <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profile ini?');">
                                <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-sm btn-dark">DETAIL</a>
                                <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-sm btn-primary">EDIT</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada profile tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Jika pakai pagination, ganti di controller $profiles = Profile::paginate(10); --}}
            {{-- {{ $profiles->links('vendor.pagination.bootstrap-4') }} --}}
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
@if(session()->has('success'))
    toastr.success('{{ session('success') }}', 'BERHASIL!');
@elseif(session()->has('error'))
    toastr.error('{{ session('error') }}', 'GAGAL!');
@endif
</script>
</body>
</html>
@endsection