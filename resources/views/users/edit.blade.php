<!DOCTYPE html>
<html>
<head>
    <title>Edit User Profile</title>
</head>
<body>
    <h1>Edit User Profile</h1>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Add your form fields here -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required>
        <br>
        <button type="submit">Update Profile</button>
    </form>
</body>
</html>