<!-- resources/views/image/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Image Gallery</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(count($images) > 0)
    <div class="row">
        @foreach($images as $image)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ asset('storage/' . $image->image_path) }}" class="card-img-top" alt="{{ $image->caption }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $image->caption }}</h5>
                    <a href="{{ route('image.edit', $image->id) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <p>No images available.</p>
    @endif
</div>
@endsection