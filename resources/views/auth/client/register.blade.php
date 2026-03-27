<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Create an Account</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-2 rounded mb-3">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-semibold">Name</label>
            <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Password</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" required>
        </div>

        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
            Register
        </button>
    </form>

    <p class="text-sm text-center mt-4">
        Already have an account?
        <a class="text-blue-600" href="{{ route('login') }}">Login</a>
    </p>

</div>
</body>
</html>
