<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-md bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>

    @if (session('error'))
        <div class="bg-red-100 text-red-600 p-2 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Password</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
        </div>

        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
            Login
        </button>
    </form>

    <p class="text-sm text-center mt-4">
        Don’t have an account?  
        <a class="text-blue-600" href="{{ route('register') }}">Register</a>
    </p>

</div>
</body>
</html>
