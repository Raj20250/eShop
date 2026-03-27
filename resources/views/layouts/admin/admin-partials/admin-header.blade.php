<header class="bg-indigo-700 shadow-md sticky top-0 z-10">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        
        <a href="{{ route('admin.dashboard.index') }}" class="text-2xl font-bold text-white tracking-wider">Admin Panel</a>
        
        <nav class="hidden md:flex items-center space-x-6">
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard.index') }}" class="text-white hover:text-indigo-200 transition duration-150 font-medium">Dashboard</a>
                    <a href="{{ route('admin.queries.index') }}" class="text-white hover:text-indigo-200 transition duration-150 font-medium">Queries</a>
                @endif
            @endauth
        </nav>

        <div class="flex items-center space-x-4">
            @auth
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.profile') }}" class="text-white hover:text-indigo-200 transition duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 6v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2"></path>
                        </svg>
                    </a>

                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white bg-red-500 px-3 py-1 rounded hover:bg-red-600 text-sm transition duration-150">
                            Logout
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</header>