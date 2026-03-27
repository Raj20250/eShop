<footer class="bg-indigo-600 text-white mt-12">
    <div class="container mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4">E-Shop</h3>
                <p class="text-indigo-100">Your one-stop shop for the best electronics and apparel.</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-indigo-100 hover:text-white transition">Shop</a></li>
                    <li><a href="{{ route('about-us') }}" class="text-indigo-100 hover:text-white transition">About Us</a></li>
                    <li><a href="{{ route('client.show-query') }}" class="text-indigo-100 hover:text-white transition">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-indigo-500 mt-8 pt-8 text-center text-indigo-100">
            <p>&copy; {{ date('Y') }} E-Shop. All rights reserved.</p>
        </div>
    </div>
</footer>