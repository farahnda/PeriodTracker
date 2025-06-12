{{-- resources/views/histories/index.blade.php --}}
@extends('layouts.nav')
@section('title', 'Riwayat')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>History</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center my-4" style="color: #3C5294;">Riwayat</h3>
    <hr>
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body" style="color: #3C5294; background-color: #EBDBD3;">
            <table class="table table-bordered"  style="border-bottom: 2px solid #3C5294; color: #3C5294;">
                    @forelse ($histories as $history)
                    <tr>
                        <td style="color: #3C5294; background-color: #EBDBD3;">
                            <strong>{{ $history->cyclelength }} hari</strong><br>
                                <small>
                                    {{ \Carbon\Carbon::parse($history->start_date)->locale('id')->translatedFormat('d F Y') }} - 
                                    {{ \Carbon\Carbon::parse($history->end_date)->locale('id')->translatedFormat('d F Y') }} 
                                    ({{ $history->periodlength }} hari)
                                </small>
                            </td>
                    </tr>  
                    @empty
                    <tr>
                        {{-- #1F2937 --}}
                        <td colspan="4" class="text-center" style="color: #1F2937; background-color: #EBDBD3;">Belum ada history</td>
                    </tr>
                    @endforelse
            </table>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>
</html>
@endsection