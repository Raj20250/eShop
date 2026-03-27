<header class="bg-indigo-700 shadow-md sticky top-0 z-10">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        
        <a href="{{ url('/') }}" class="text-2xl font-bold text-white tracking-wider">E-Shop</a>
        
        <nav class="hidden md:flex items-center space-x-6">

            <a href="{{ url('/') }}" class="text-white hover:text-indigo-200 transition duration-150 font-medium">Shop</a>
            
            @auth
                @if (Auth::user()->role === 'client') 
                    <a href="{{ route('order.history') }}" class="text-white hover:text-indigo-200 transition duration-150 font-medium">My Orders</a>
                    <a href="{{ route('wishlist.index') }}" class="text-white hover:text-indigo-200 transition duration-150 font-medium">Wishlist</a>
                @endif
            @endauth
        </nav>

        <div class="flex items-center space-x-4">
            
                     
@if (Auth::guest() || (Auth::check() && Auth::user()->role === 'client'))
    <a href="{{ route('carts') }}" class="relative text-white hover:text-indigo-200 transition duration-150">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        
        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
            <span class="cart-badge-count">0</span>
        </span>
    </a>
@endif

           

             @auth
                @if (Auth::user()->role === 'client')
                    <a href="{{ route('profile') }}" class="text-white hover:text-indigo-200 transition duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 6v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2"></path></svg>
                    </a>

                @endif
            @endauth

            @guest
                @if (Route::has('login'))
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-4 py-1.5 text-white border border-transparent hover:border-indigo-200 rounded-md text-sm leading-normal transition duration-150"
                    >
                        Log in
                    </a>
                @endif

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-block px-4 py-1.5 bg-indigo-500 text-white border border-transparent hover:bg-indigo-600 rounded-md text-sm leading-normal transition duration-150">
                        Register
                    </a>
                @endif
            @endguest

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white bg-red-500 px-3 py-1 rounded hover:bg-red-600 text-sm transition duration-150">
                        Logout
                    </button>
                </form>
            @endauth

        </div>
    </div>
</header>