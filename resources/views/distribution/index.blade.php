    <a href="{{ route('distribution.create') }}">Create New Record</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Craftsman ID</th>
                <th>Destination</th>
                <th>Quantity</th>
                <th>Shipment Date</th>
                <th>Tracking Number</th>
                <th>Received Date</th>
                <th>Receiver Name</th>
                <th>Received Condition</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($distribution as $distribution)
            <tr>
                <td>{{ $distribution->id }}</td>
                <td>{{ $distribution->user_id }}</td>
                <td>{{ $distribution->craftsman_id }}</td>
                <td>{{ $distribution->destination }}</td>
                <td>{{ $distribution->quantity }}</td>
                <td>{{ $distribution->shipment_date }}</td>
                <td>{{ $distribution->tracking_number }}</td>
                <td>{{ $distribution->received_date }}</td>
                <td>{{ $distribution->receiver_name }}</td>
                <td>{{ $distribution->received_condition }}</td>
                <td>
                    <a href="{{ route('distribution.show', $distribution->id) }}">View</a>
                    <a href="{{ route('distribution.edit', $distribution->id) }}">Edit</a>
                    <form action="{{ route('distribution.destroy', $distribution->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>