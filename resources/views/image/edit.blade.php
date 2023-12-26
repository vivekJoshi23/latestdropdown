<!-- resources/views/image/edit.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Image</h2>
    <form action="{{ route('image.update', $image->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="caption">Caption</label>
            <input type="text" name="caption" class="form-control" value="{{ $image->caption }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file" accept="image/*">
        </div>

        <!-- Additional Images -->
        <div class="form-group" id="additional-image-container">
            @foreach($image->additionalImages as $additionalImage)
            <div class="additional-image-fields">
                <div class="form-group">
                    <label for="additional_captions">Additional Caption</label>
                    <input type="text" name="additional_captions[{{ $loop->parent->index }}][]" class="form-control" value="{{ $additionalImage->additional_caption }}" required>
                </div>
                <div class="form-group">
                    <label for="additional_images">Additional Image</label>
                    <input type="file" name="additional_images[{{ $loop->parent->index }}][]" class="form-control-file" accept="image/*">
                </div>
                <input type="hidden" name="additional_image_ids[{{ $loop->parent->index }}][]" value="{{ $additionalImage->id }}">
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-primary" onclick="addAdditionalImageField()">Add More Additional Images</button>

        <button type="submit" class="btn btn-primary">Update Image</button>
    </form>
</div>

<script>
    function addAdditionalImageField() {
        var container = document.getElementById('additional-image-container');
        var newAdditionalImageField = document.createElement('div');
        newAdditionalImageField.className = 'additional-image-fields';
        newAdditionalImageField.innerHTML = `
                <div class="form-group">
                    <label for="additional_captions">Additional Caption</label>
                    <input type="text" name="additional_captions[${container.children.length}][]" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="additional_images">Additional Image</label>
                    <input type="file" name="additional_images[${container.children.length}][]" class="form-control-file" accept="image/*">
                </div>
            `;
        container.appendChild(newAdditionalImageField);
    }
</script>
@endsection