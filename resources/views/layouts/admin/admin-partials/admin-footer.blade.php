<footer class="bg-indigo-700 text-white mt-auto">
    <div class="container mx-auto px-6 py-10">
        
        <div class="flex flex-col md:flex-row justify-between">
            
            <div class="mb-8 md:mb-0">
                <h3 class="text-xl font-bold mb-4">Admin Panel</h3>
                <p class="text-indigo-100 max-w-sm">
                    Manage products, orders, users, and queries from this centralized control center.
                </p>
            </div>

            <div class="md:w-1/3">
                <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('admin.dashboard.index') }}" class="text-indigo-100 hover:text-white transition">Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}" class="text-indigo-100 hover:text-white transition">Products</a></li>
                    <li><a href="{{ route('admin.categories.index') }}" class="text-indigo-100 hover:text-white transition">Categories</a></li>
                    <li><a href="{{ route('admin.orders.index') }}" class="text-indigo-100 hover:text-white transition">Orders</a></li>
                    <li><a href="{{ route('admin.queries.index') }}" class="text-indigo-100 hover:text-white transition">Queries</a></li>
                </ul>
            </div>
            
        </div>

        <div class="border-t border-indigo-500 mt-8 pt-8 text-center text-indigo-100">
            <p>&copy; {{ date('Y') }} E-Shop Admin. All rights reserved.</p>
        </div>
    </div>
</footer>