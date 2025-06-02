@extends('layouts.nav')
@section('title', 'Prediction')
@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body" style="color: #3C5294; background-color: #EBDBD3;">
                    <h4 class="mb-4 fw-bold" style="font-size: 1.5rem;">Hitung Prediksi</h4>
                    <form action="{{ route('calendars.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold">Start Date</label>
                            <input
                                type="date"
                                name="start_date"
                                class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date') }}"
                            >
                            @error('start_date')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Cycle Length (days)</label>
                            <input
                                type="number"
                                name="cyclelength"
                                class="form-control @error('cyclelength') is-invalid @enderror"
                                value="{{ old('cyclelength') }}"
                                min="1"
                                placeholder="Masukkan Cycle Length"
                            >
                            @error('cyclelength')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Period Length (days)</label>
                            <input
                                type="number"
                                name="periodlength"
                                class="form-control @error('periodlength') is-invalid @enderror"
                                value="{{ old('periodlength') }}"
                                min="1"
                                placeholder="Masukkan Period Length"
                            >
                            @error('periodlength')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <br>
                        <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                        <a href="{{ route('calendars.index') }}" class="btn btn-md btn-danger">KEMBALI</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
