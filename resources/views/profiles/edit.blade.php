{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.nav')
@section('title', 'Edit Profile')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body style="background: lightgray">
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card-body" style="color: #3C5294; background-color: #EBDBD3; ">

                <div class="card-body">
                    <form action="{{ route('profiles.update', $profile->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="font-weight-bold">Nama</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $profile->name) }}" placeholder="Masukkan Nama">
                            @error('name')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $profile->email) }}" placeholder="Masukkan Email">
                            @error('email')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Password <small>(Kosongkan jika tidak ingin mengubah)</small></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan Password Baru">
                            @error('password')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                   placeholder="Konfirmasi Password Baru">
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Tanggal Lahir (Opsional)</label>
                            <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror"
                                   value="{{ old('birth_date', $profile->birth_date) }}">
                            @error('birth_date')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                            <div class="mt-4 d-flex justify-content-between">
                                <a href="/profiles/{{ Auth::id() }}" style="background: #f3bdbd; color: #fff; border-radius: 16px; padding: 10px 32px; text-decoration: none; font-weight: bold;">Back</a>
                                <button type="submit" style="background: #f3bdbd; color: #fff; border-radius: 16px; padding: 10px 32px; border: none; font-weight: bold;">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
@endsection