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
        <h1>Edit Factory</h1>
        <a href="{{ route('factory.index') }}" class="btn btn-warning">
            Back
        </a>
    </div>
    <form action="{{ route('factory.update', $factory->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="harvest_id" class="form-label">Harvest:</label>
            <select id="harvest_id" name="harvest_id" class="form-select" required>
                @foreach($harvests as $harvest)
                <option value="{{ $harvest->id }}">{{ $harvest->id }} - {{$harvest->material_type}} - {{$harvest->quantity}} - {{$harvest->quality}} - {{$harvest->delivery_info}} - {{$harvest->delivery_date}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="received_date">Received Date:</label>
            <input type="datetime-local" id="received_date" name="received_date" class="form-control" value="{{ $factory->received_date ? (new DateTime($factory->received_date))->format('Y-m-d\TH:i') : '' }}" required>
        </div>

        <div class="form-group">
            <label for="initial_process">Initial Process:</label>
            <input type="text" id="initial_process" name="initial_process" class="form-control" value="{{ $factory->initial_process }}" required>
        </div>

        <div class="form-group">
            <label for="semi_finished_quantity">Semi-Finished Quantity:</label>
            <input type="number" step="0.01" id="semi_finished_quantity" name="semi_finished_quantity" class="form-control" value="{{ $factory->semi_finished_quantity }}" required>
        </div>

        <div class="form-group">
            <label for="semi_finished_quality">Semi-Finished Quality:</label>
            <input type="text" id="semi_finished_quality" name="semi_finished_quality" class="form-control" value="{{ $factory->semi_finished_quality }}" required>
        </div>

        <div class="form-group">
            <label for="factory_name">Factory Name:</label>
            <input type="text" id="factory_name" name="factory_name" class="form-control" value="{{ $factory->factory_name }}" required>
        </div>

        <div class="form-group">
            <label for="factory_address">Factory Address:</label>
            <input type="text" id="factory_address" name="factory_address" class="form-control" value="{{ $factory->factory_address }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            @if($factory->image)
            <img src="{{ asset('storage/images/' . $factory->image) }}" alt="factory Image" class="img-thumbnail mb-2" width="100">
            @endif
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection