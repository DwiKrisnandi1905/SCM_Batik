@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Create Craftsman</h1>
        <form action="{{ route('craftsman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="factory_id">Factory ID:</label>
                <input type="number" id="factory_id" name="factory_id" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="production_details">Production Details:</label>
                <input type="text" id="production_details" name="production_details" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="finished_quantity">Finished Quantity:</label>
                <input type="number" step="0.01" id="finished_quantity" name="finished_quantity" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="completion_date">Completion Date:</label>
                <input type="datetime-local" id="completion_date" name="completion_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Craftsman Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
