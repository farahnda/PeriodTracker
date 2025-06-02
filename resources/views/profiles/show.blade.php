{{-- resources/views/profiles/show.blade.php --}}
@extends('layouts.nav')
@section('title', 'Profile')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body style="background: lightgray">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body" style="color: #3C5294; background-color: #EBDBD3; ">
                    <h4 class="text-center">PROFILE</h4>
                    <img class="size-12 rounded-full d-block mx-auto" src="https://www.shutterstock.com/image-vector/blank-avatar-photo-place-holder-600nw-1114445501.jpg" alt="">
                    <p><strong>Username</strong> <br> {{ $profile->name }}</p>
                    <p><strong>Email</strong> <br> {{ $profile->email }}</p>
                    <p><strong>Tanggal Lahir</strong> <br> {{ $profile->birth_date }}</p>
                </div>
            </div>
            <div class="mt-4 d-flex justify-content-between">
                <a href="/" style="background: #f3bdbd; color: #fff; border-radius: 16px; padding: 10px 32px; text-decoration: none; font-weight: bold;">Back</a>
                <a href="{{ route('profiles.edit', $profile->id) }}" style="background: #f3bdbd; color: #fff; border-radius: 16px; padding: 10px 32px; text-decoration: none; font-weight: bold;">Edit Profile</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
@endsection