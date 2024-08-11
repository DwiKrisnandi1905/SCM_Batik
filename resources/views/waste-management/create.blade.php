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
            <h1>Create Waste Management</h1>
            <a href="{{ route('waste.index') }}" class="btn btn-warning">
                Back
            </a>
        </div>
        <form action="{{ route('waste.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="craftsman_id">Craftsman</label>
                <select id="craftsman_id" name="craftsman_id" class="form-control" required>
                    @foreach($craftsmen as $craftsmen)
                        <option value="{{ $craftsmen->id }}">{{ $craftsmen->production_details }} - {{$craftsmen->finished_quantity}} - {{$craftsmen->completion_date}}</option>
                    @endforeach
                </select>
            </div>

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
