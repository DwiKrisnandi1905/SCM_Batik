<form action="{{ route('distribution.store') }}" method="POST">
    @csrf
    <div>
        <label for="craftsman_id">Craftsman ID:</label>
        <input type="number" id="craftsman_id" name="craftsman_id" value="{{ old('craftsman_id') }}" required>
    </div>
    <div>
        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" value="{{ old('destination') }}" required>
    </div>
    <div>
        <label for="quantity">Quantity:</label>
        <input type="number" step="0.01" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
    </div>
    <div>
        <label for="shipment_date">Shipment Date:</label>
        <input type="datetime-local" id="shipment_date" name="shipment_date" value="{{ old('shipment_date') }}" required>
    </div>
    <div>
        <label for="tracking_number">Tracking Number:</label>
        <input type="text" id="tracking_number" name="tracking_number" value="{{ old('tracking_number') }}" required>
    </div>
    <div>
        <label for="received_date">Received Date:</label>
        <input type="datetime-local" id="received_date" name="received_date" value="{{ old('received_date') }}" required>
    </div>
    <div>
        <label for="receiver_name">Receiver Name:</label>
        <input type="text" id="receiver_name" name="receiver_name" value="{{ old('receiver_name') }}" required>
    </div>
    <div>
        <label for="received_condition">Received Condition:</label>
        <input type="text" id="received_condition" name="received_condition" value="{{ old('received_condition') }}" required>
    </div>
    <div>
        <button type="submit">Create</button>
    </div>
</form>