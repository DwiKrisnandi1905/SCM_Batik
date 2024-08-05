<form action="{{ route('certification.store') }}" method="POST">
    @csrf
    <div>
        <label for="test_results">Test Results:</label>
        <input type="text" id="test_results" name="test_results" value="{{ old('test_results') }}" required>
    </div>
    <div>
        <label for="certificate_number">Certificate Number:</label>
        <input type="text" id="certificate_number" name="certificate_number" value="{{ old('certificate_number') }}" required>
    </div>
    <div>
        <div>
            <label for="issue_date">Issue Date:</label>
            <input type="datetime-local" id="issue_date" name="issue_date" value="{{ old('issue_date') }}" required>
        </div>
    </div>
    <div>
        <button type="submit">Create</button>
    </div>
</form>