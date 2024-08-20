@if($errors->any())
    <div>{{ $errors->first() }}</div>
@endif

<form action="{{ route('reset-password.update') }}" method="POST">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>
    <button type="submit">Reset Password</button>
</form>
