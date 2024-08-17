<!DOCTYPE html>
<html>
<head>
    <title>Edit User Profile</title>
</head>
<body>
    <h1>Edit User Profile</h1>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required>
        <br>

        <label for="image">Profile Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <br>
        
        <button type="submit">Update Profile</button>
    </form>
</body>
</html>