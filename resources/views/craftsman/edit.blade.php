@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Edit Craftsman</h1>
        <!-- <form action="{{ route('craftsman.update', ['id' => $craftsman->id]) }}" method="POST"> -->

            @csrf
            @method('PUT')
            {{$craftsman->id}}
            <div class="form-group">
                <label for="factory_id">Factory ID:</label>
                <input type="number" id="factory_id" name="factory_id" class="form-control" value="{{ $craftsman->factory_id }}" required>
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

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection