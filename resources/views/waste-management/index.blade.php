
    <a href="{{ route('waste.create') }}">Create New Record</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Waste Type</th>
                <th>Management Method</th>
                <th>Management Results</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($wasteManagements as $wasteManagement)
                <tr>
                    <td>{{ $wasteManagement->id }}</td>
                    <td>{{ $wasteManagement->user_id }}</td>
                    <td>{{ $wasteManagement->waste_type }}</td>
                    <td>{{ $wasteManagement->management_method }}</td>
                    <td>{{ $wasteManagement->management_results }}</td>
                    <td>
                        <a href="{{ route('waste.edit', $wasteManagement->id) }}">Edit</a>
                        <form action="{{ route('waste.destroy', $wasteManagement->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>