@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Create Distribution</h1>
        <form action="{{ route('distribution.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="craftsman_id" class="form-label">Craftsman ID:</label>
                <input type="number" class="form-control" id="craftsman_id" name="craftsman_id" value="{{ old('craftsman_id') }}" required>
            </div>
            <div class="mb-3">
                <label for="destination" class="form-label">Destination:</label>
                <input type="text" class="form-control" id="destination" name="destination" value="{{ old('destination') }}" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
            </div>
            <div class="mb-3">
                <label for="shipment_date" class="form-label">Shipment Date:</label>
                <input type="datetime-local" class="form-control" id="shipment_date" name="shipment_date" value="{{ old('shipment_date') }}" required>
            </div>
            <div class="mb-3">
                <label for="tracking_number" class="form-label">Tracking Number:</label>
                <input type="text" class="form-control" id="tracking_number" name="tracking_number" value="{{ old('tracking_number') }}" required>
            </div>
            <div class="mb-3">
                <label for="received_date" class="form-label">Received Date:</label>
                <input type="datetime-local" class="form-control" id="received_date" name="received_date" value="{{ old('received_date') }}" required>
            </div>
            <div class="mb-3">
                <label for="receiver_name" class="form-label">Receiver Name:</label>
                <input type="text" class="form-control" id="receiver_name" name="receiver_name" value="{{ old('receiver_name') }}" required>
            </div>
            <div class="mb-3">
                <label for="received_condition" class="form-label">Received Condition:</label>
                <input type="text" class="form-control" id="received_condition" name="received_condition" value="{{ old('received_condition') }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
