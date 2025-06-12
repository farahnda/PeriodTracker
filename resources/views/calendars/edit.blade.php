@extends('layouts.nav')
@section('title', 'Edit Prediksi')
@section('content')

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card border-0 rounded-4 shadow overflow-hidden" style="background-color: #EBDBD3;">
                <div class="card-body" style="color: #3C5294; padding: 1rem;">
                    <h4 class="mb-4 fw-bold" style="font-size: 1.5rem;">Edit Prediksi</h4>
                    <form action="{{ route('calendars.update', $calendar->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="fw-semibold">Start Date</label>
                            <input
                                type="text"
                                name="start_date"
                                id="start_date"
                                class="form-control datepicker @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date', \Carbon\Carbon::parse($calendar->start_date)->format('d-m-Y')) }}"
                                placeholder="dd-mm-yyyy"
                            />
                            @error('start_date')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="fw-semibold">Lama Siklus (hari)</label>
                            <input
                                type="number"
                                name="cyclelength"
                                class="form-control @error('cyclelength') is-invalid @enderror"
                                value="{{ old('cyclelength', $calendar->cyclelength) }}"
                                min="1"
                                placeholder="Masukkan lama siklus"
                            >
                            @error('cyclelength')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="fw-semibold">Lama Menstruasi (hari)</label>
                            <input
                                type="number"
                                name="periodlength"
                                class="form-control @error('periodlength') is-invalid @enderror"
                                value="{{ old('periodlength', $calendar->periodlength) }}"
                                min="1"
                                placeholder="Masukkan lama menstruasi"
                            >
                            @error('periodlength')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <br>

                        <div class="d-flex gap-2">
                            <a href="{{ route('calendars.index') }}" 
                            class="btn btn-md text-white fw-bold px-4 py-2 flex-fill text-center bg-[#800000] border-[#660000] hover:bg-[#660000] hover:border-[#4d0000]">
                                Batal
                            </a>
                            <button type="submit" 
                                class="btn btn-md text-white fw-bold px-4 py-2 flex-fill bg-[#3C5294] border-[#2c3d75] hover:bg-[#2c3d75] hover:border-[#1f2a54]">
                                Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Datepicker -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });
</script>

@endsection