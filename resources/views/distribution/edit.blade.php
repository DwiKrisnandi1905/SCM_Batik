@extends('layout.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Distribution</h1>
        <a href="{{ route('distribution.index') }}" class="btn btn-warning">
            Back
        </a>
    </div>
    <form action="{{ route('distribution.update', $distribution->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="craftsman_id">Craftsman</label>
            <select id="craftsman_id" name="craftsman_id" class="form-control" required>
                @foreach($craftsmen as $craftsmen)
                <option value="{{ $craftsmen->id }}">{{ $craftsmen->production_details }} - {{$craftsmen->finished_quantity}} - {{$craftsmen->completion_date}}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="destination" class="form-label">Destination:</label>
            <input type="text" class="form-control" id="destination" name="destination" value="{{ old('destination', $distribution->destination) }}" required>
        </div>

        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity:</label>
            <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $distribution->quantity) }}" required>
        </div>

        <div class="mb-3">
            <label for="shipment_date" class="form-label">Shipment Date:</label>
            <input type="datetime-local" class="form-control" id="shipment_date" name="shipment_date" value="{{ old('shipment_date', $distribution->shipment_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="tracking_number" class="form-label">Tracking Number:</label>
            <input type="text" class="form-control" id="tracking_number" name="tracking_number" value="{{ old('tracking_number', $distribution->tracking_number) }}" required>
        </div>

        <div class="mb-3">
            <label for="received_date" class="form-label">Received Date:</label>
            <input type="datetime-local" class="form-control" id="received_date" name="received_date" value="{{ old('received_date', $distribution->received_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="receiver_name" class="form-label">Receiver Name:</label>
            <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="{{ old('receiver_name', $distribution->receiver_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="received_condition" class="form-label">Received Condition:</label>
            <input type="text" class="form-control" id="received_condition" name="received_condition" value="{{ old('received_condition', $distribution->received_condition) }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            @if($distribution->image)
            <img src="{{ asset('storage/images/' . $distribution->image) }}" alt="distribution Image" class="img-thumbnail mb-2" width="100">
            @endif
            <input type="file" class="form-control" id="image" name="image">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection