@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Create Waste</h1>
        <form action="{{ route('waste.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="waste_type" class="form-label">Waste Type:</label>
                <input type="text" class="form-control" id="waste_type" name="waste_type" value="{{ old('waste_type') }}" required>
            </div>
            <div class="mb-3">
                <label for="management_method" class="form-label">Management Method:</label>
                <input type="text" class="form-control" id="management_method" name="management_method" value="{{ old('management_method') }}" required>
            </div>
            <div class="mb-3">
                <label for="management_results" class="form-label">Management Results:</label>
                <input type="text" class="form-control" id="management_results" name="management_results" value="{{ old('management_results') }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
