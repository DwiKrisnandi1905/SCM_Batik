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
            <h1>Create Harvest</h1>
            <a href="{{ route('harvest.index') }}" class="btn btn-warning">
                Back
            </a>
        </div>
        <form action="{{ route('harvest.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="material_type" class="form-label">Material Type:</label>
                <input type="text" class="form-control" id="material_type" name="material_type" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" step="any" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="mb-3">
                <label for="quality" class="form-label">Quality:</label>
                <input type="text" class="form-control" id="quality" name="quality" required>
            </div>
            <div class="mb-3">
                <label for="delivery_info" class="form-label">Delivery Info:</label>
                <input type="text" class="form-control" id="delivery_info" name="delivery_info" required>
            </div>
            <div class="mb-3">
                <label for="delivery_date" class="form-label">Delivery Date:</label>
                <input type="datetime-local" class="form-control" id="delivery_date" name="delivery_date" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

