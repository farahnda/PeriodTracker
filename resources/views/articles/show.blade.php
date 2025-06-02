{{-- resources/views/articles/show.blade.php --}}
@extends('layouts.nav')
@section('title', 'Article')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Article</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body style="background: lightgray">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body" style="color: #3C5294; background-color: #EBDBD3; ">
                    <h4>{{ $article->title }}</h4>
                    <p><strong>Author:</strong> {{ $article->author }}</p>
                    <p><small>Created at: {{ $article->created_at }}</small></p>

                    @if ($article->image_url)
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="img-fluid mb-3" />
                    @endif

                    <p>{!! nl2br(e($article->content)) !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
@endsection