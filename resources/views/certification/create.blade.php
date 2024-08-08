@extends('layout.app')

@section('content')
    <div class="container">
        <h1>Create Certification</h1>
        <form action="{{ route('certification.store') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label for="craftsman_id">Option ID:</label>
                <select id="craftsman_id" name="craftsman_id" class="form-control" required>
                    @foreach($craftsmen as $craftsmen)
                        <option value="{{ $craftsmen->id }}">{{ $craftsmen->id }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="test_results">Certificate test_results:</label>
                <input type="text" id="test_results" name="test_results" class="form-control" value="{{ old('test_results') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="certificate_number">Certificate Number:</label>
                <input type="text" id="certificate_number" name="certificate_number" class="form-control" value="{{ old('certificate_number') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="issue_date">Issue Date:</label>
                <input type="datetime-local" id="issue_date" name="issue_date" class="form-control" value="{{ old('issue_date') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@endsection
