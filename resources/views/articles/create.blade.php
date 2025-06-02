{{-- resources/views/article/create.blade.php --}}
@extends('layouts.nav')
@section('title', 'Article')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Artikel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body style="background: lightgray">
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <form action="{{ route('articles.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold">Judul</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}" placeholder="Masukkan Judul Artikel">
                            @error('title')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Isi Konten</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                      rows="6" placeholder="Masukkan Konten Artikel">{{ old('content') }}</textarea>
                            @error('content')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">URL Gambar (Opsional)</label>
                            <input type="text" name="image_url" class="form-control @error('image_url') is-invalid @enderror"
                                   value="{{ old('image_url') }}" placeholder="Masukkan URL Gambar Artikel">
                            @error('image_url')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Penulis</label>
                            <input type="text" name="author" class="form-control @error('author') is-invalid @enderror"
                                   value="{{ old('author') }}" placeholder="Masukkan Nama Penulis">
                            @error('author')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Link (Opsional)</label>
                            <input type="text"
                                name="link"
                                class="form-control @error('link') is-invalid @enderror"
                                value="{{ old('link', $article->link ?? '') }}"
                                placeholder="Masukkan URL/Link artikel">
                            @error('link')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                        <a href="{{ route('articles.index') }}" class="btn btn-md btn-danger">KEMBALI</a>
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