@extends('layout.app')

@section('content')
<div class="container">
    <h1>Edit Craftsman</h1>
    <!-- <form action="{{ route('craftsman.update', ['id' => $craftsman->id]) }}" method="POST"> -->

    @csrf
    @method('PUT')
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
        <input type="text" id="production_details" name="production_details" class="form-control" value="{{ $craftsman->production_details }}" required>
    </div>

    <div class="form-group">
        <label for="finished_quantity">Finished Quantity:</label>
        <input type="number" step="0.01" id="finished_quantity" name="finished_quantity" class="form-control" value="{{ $craftsman->finished_quantity }}" required>
    </div>

    <div class="form-group">
        <label for="completion_date">Completion Date:</label>
        <input type="datetime-local" id="completion_date" name="completion_date" class="form-control" value="{{ $craftsman->completion_date }}" required>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image:</label>
        @if($craftsman->image)
        <img src="{{ asset('storage/images/' . $craftsman->image) }}" alt="craftsman Image" class="img-thumbnail mb-2" width="100">
        @endif
        <input type="file" class="form-control" id="image" name="image">
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection