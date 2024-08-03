<!-- resources/views/craftsman/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Craftsmen List</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Craftsmen List</h1>
        <a href="{{ route('craftsman.create') }}" class="btn btn-primary mb-3">Create New Craftsman</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Factory ID</th>
                    <th>Production Details</th>
                    <th>Finished Quantity</th>
                    <th>Completion Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($craftsmen as $craftsman)
                    <tr>
                        <td>{{ $craftsman->id }}</td>
                        <td>{{ $craftsman->user_id }}</td>
                        <td>{{ $craftsman->factory_id }}</td>
                        <td>{{ $craftsman->production_details }}</td>
                        <td>{{ $craftsman->finished_quantity }}</td>
                        <td>{{ $craftsman->completion_date }}</td>
                        <td>
                            <a href="{{ route('craftsman.edit', $craftsman->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('craftsman.destroy', $craftsman->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>