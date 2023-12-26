<!-- resources/views/image/form.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Images</h2>
    <form action="{{ route('image.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="caption">Caption</label>
            <input type="text" name="caption[]" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="images[]" class="form-control-file" accept="image/*" required>
        </div>
        <div class="form-group" id="image-container">
            <!-- Additional image fields will be added here dynamically -->
        </div>
        <button type="button" class="btn btn-primary" onclick="addImageField()">Add More Images</button>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>

<script>
    function addImageField() {
        var container = document.getElementById('image-container');
        var newImageField = document.createElement('div');
        newImageField.innerHTML = `
                <div class="form-group">
                    <label for="caption">Caption</label>
                    <input type="text" name="caption[]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="images[]" class="form-control-file" accept="image/*" required>
                </div>
            `;
        container.appendChild(newImageField);
    }
</script>
@endsection