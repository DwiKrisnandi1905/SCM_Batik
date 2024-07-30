<!-- resources/views/harvests/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Harvests</title>
</head>
<body>
    <div>
        <h1>Harvests</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Material Type</th>
                    <th>Quantity</th>
                    <th>Quality</th>
                    <th>Delivery Info</th>
                    <th>Delivery Date</th>
                    <th>Image</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                @foreach($harvests as $harvest)
                    <tr>
                        <td>{{ $harvest->id }}</td>
                        <td>{{ $harvest->material_type }}</td>
                        <td>{{ $harvest->quantity }}</td>
                        <td>{{ $harvest->quality }}</td>
                        <td>{{ $harvest->delivery_info }}</td>
                        <td>{{ $harvest->delivery_date }}</td>
                        <td>
                            @if($harvest->image)
                                <img src="{{ asset('storage/' . $harvest->image) }}" alt="Harvest Image" width="100">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('harvest.edit', $harvest->id) }}">Edit</a>
                            <form action="{{ route('harvest.destroy', $harvest->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>