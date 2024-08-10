@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Create Distribution</h1>
        <form action="{{ route('distribution.store') }}" method="POST" enctype="multipart/form-data" >
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
            
            <div class="mb-3">
                <label for="image" class="form-label">Distributor Image:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
