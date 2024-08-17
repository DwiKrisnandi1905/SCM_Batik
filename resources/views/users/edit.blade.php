@extends('layout.app')

@section('content')
<style>
    .btn-warning {
        color: #fff;
        background-color: #ff8c00;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        border: 2px solid #fff;
    }

    .btn-warning:hover {
        color: #ff8c00;
        background-color: #fff;
        border: 2px solid #ff8c00;
    }
</style>
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit User Profile</h1>
        <a href="{{ route('profile.index') }}" class="btn btn-warning">Back</a>
    </div>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Profile Image:</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
</div>
@endsection
