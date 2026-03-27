<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 min-h-screen p-10">

    <h1 class="text-3xl font-bold mb-4">Client Dashboard</h1>

    <p>Welcome, {{ Auth::user()->name }} (Client)</p>

    <a href="{{ route('profile') }}" class="text-blue-600">View Profile</a>

</body>
</html>
