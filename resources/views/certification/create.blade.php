
    <form action="{{ route('certification.store') }}" method="POST">
        @csrf
        <div>
            <label for="user_id">User ID:</label>
            <input type="number" id="user_id" name="user_id" value="{{ old('user_id') }}" required>
        </div>
        <div>
            <label for="craftsman_id">Craftsman ID:</label>
            <input type="number" id="craftsman_id" name="craftsman_id" value="{{ old('craftsman_id') }}" required>
        </div>
        <div>
            <label for="test_results">Test Results:</label>
            <input type="text" id="test_results" name="test_results" value="{{ old('test_results') }}" required>
        </div>
        <div>
            <label for="certificate_number">Certificate Number:</label>
            <input type="text" id="certificate_number" name="certificate_number" value="{{ old('certificate_number') }}" required>
        </div>
        <div>
            <label for="issue_date">Issue Date:</label>
            <input type="date" id="issue_date" name="issue_date" value="{{ old('issue_date') }}" required>
        </div>
        <div>
            <button type="submit">Create</button>
        </div>
    </form>