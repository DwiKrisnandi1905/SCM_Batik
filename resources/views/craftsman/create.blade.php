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
            <h1>Create Craftsman</h1>
            <a href="{{ route('craftsman.index') }}" class="btn btn-warning">
                Back
            </a>
        </div>
        <form action="{{ route('craftsman.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="factory_id">Factory ID:</label>
                <select id="factory_id" name="factory_id" class="form-control" required>
                    @foreach($factories as $factory)
                        <option value="{{ $factory->id }}">{{$factory->received_date}} - {{ $factory->factory_name }} - {{$factory->initial_process}} - {{$factory->semi_finished_quantity}} - {{$factory->semi_finished_quality}}</option>
                    @endforeach
                </select>
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
