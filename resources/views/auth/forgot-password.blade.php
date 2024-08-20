@if(session('status'))
    <div>{{ session('status') }}</div>
@endif

@if($errors->any())
    <div>{{ $errors->first() }}</div>
@endif

<form action="{{ route('password.forgot.email') }}" method="POST">
    @csrf
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <button type="submit">Send Reset Link</button>
</form>
