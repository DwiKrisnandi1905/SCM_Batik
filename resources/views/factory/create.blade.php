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
        <h1>Create Factory</h1>
        <a href="{{ route('factory.index') }}" class="btn btn-warning">
            Back
        </a>
    </div>
    <form action="{{ route('factory.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="harvest_id" class="form-label">Harvest:</label>
            <select id="harvest_id" name="harvest_id" class="form-select" required>
                @foreach($harvests as $harvest)
                    <option value="{{ $harvest->id }}">{{ $harvest->id }} - {{$harvest->material_type}} - {{$harvest->quantity}} - {{$harvest->quality}} - {{$harvest->delivery_info}} - {{$harvest->delivery_date}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="received_date" class="form-label">Received Date:</label>
            <input type="datetime-local" class="form-control" id="received_date" name="received_date" required>
        </div>
        <div class="mb-3">
            <label for="initial_process" class="form-label">Initial Process:</label>
            <input type="text" class="form-control" id="initial_process" name="initial_process" required>
        </div>
        <div class="mb-3">
            <label for="semi_finished_quantity" class="form-label">Semi-Finished Quantity:</label>
            <input type="number" step="0.01" class="form-control" id="semi_finished_quantity" name="semi_finished_quantity" required>
        </div>
        <div class="mb-3">
            <label for="semi_finished_quality" class="form-label">Semi-Finished Quality:</label>
            <input type="text" class="form-control" id="semi_finished_quality" name="semi_finished_quality" required>
        </div>
        <div class="mb-3">
            <label for="factory_name" class="form-label">Factory Name:</label>
            <input type="text" class="form-control" id="factory_name" name="factory_name" required>
        </div>
        <div class="mb-3">
            <label for="factory_address" class="form-label">Factory Address:</label>
            <input type="text" class="form-control" id="factory_address" name="factory_address" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Factory Image:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
