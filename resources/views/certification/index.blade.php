
    <h1>Certifications</h1>
    <a href="{{ route('certification.create') }}">Create New Certification</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Craftsman ID</th>
                <th>Test Results</th>
                <th>Certificate Number</th>
                <th>Issue Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($certifications as $certification)
                <tr>
                    <td>{{ $certification->id }}</td>
                    <td>{{ $certification->user_id }}</td>
                    <td>{{ $certification->craftsman_id }}</td>
                    <td>{{ $certification->test_results }}</td>
                    <td>{{ $certification->certificate_number }}</td>
                    <td>{{ $certification->issue_date }}</td>
                    <td>
                        <a href="{{ route('certification.show', $certification->id) }}">Show</a>
                        <a href="{{ route('certification.edit', $certification->id) }}">Edit</a>
                        <form action="{{ route('certification.destroy', $certification->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
