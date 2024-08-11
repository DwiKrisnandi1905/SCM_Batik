@extends('layout.app')

@section('content')
    <style>
        .btn-warning {
        color: #fff;
        background-color: #ff8c00;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        border: 2px solid #fff;
        }

        .btn-warning:hover {
            color: #ff8c00;
            background-color: #fff;
            border: 2px solid #ff8c00;
        }
    </style>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Edit Harvest</h1>
            <a href="{{ route('harvest.index') }}" class="btn btn-warning">
                Back
            </a>
        </div>
        <form action="{{ route('harvest.update', $harvest->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="material_type" class="form-label">Material Type:</label>
                <input type="text" class="form-control" id="material_type" name="material_type" value="{{ old('material_type', $harvest->material_type) }}" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" step="any" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $harvest->quantity) }}" required>
            </div>

            <div class="mb-3">
                <label for="quality" class="form-label">Quality:</label>
                <input type="text" class="form-control" id="quality" name="quality" value="{{ old('quality', $harvest->quality) }}" required>
            </div>

            <div class="mb-3">
                <label for="delivery_info" class="form-label">Delivery Info:</label>
                <input type="text" class="form-control" id="delivery_info" name="delivery_info" value="{{ old('delivery_info', $harvest->delivery_info) }}" required>
            </div>

            <div class="mb-3">
                <label for="delivery_date" class="form-label">Delivery Date:</label>
                <input type="datetime-local" class="form-control" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $harvest->delivery_date) }}" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                @if($harvest->image)
                    <img src="{{ asset('storage/images/' . $harvest->image) }}" alt="Harvest Image" class="img-thumbnail mb-2" width="100">
                @endif
                <input type="file" class="form-control" id="image" name="image">
            </div>

            <button type="submit" class="btn btn-primary">Update Harvest</button>
        </form>
    </div>
@endsection

