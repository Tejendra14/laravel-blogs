<!-- resources/views/layouts/sidebar.blade.php -->
<aside class="w-64 bg-white shadow-md hidden md:block">
    <div class="p-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Admin Dashboard</h2>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('superadmin.users.index') }}" class="flex items-center p-2 text-gray-700 hover:bg-blue-50 rounded transition">
                        <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('roles.index') }}" class="flex items-center p-2 text-gray-700 hover:bg-purple-50 rounded transition">
                        <svg class="h-5 w-5 text-purple-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Roles
                    </a>
                </li>
                <li>
                    <a href="{{ route('permissions.index') }}" class="flex items-center p-2 text-gray-700 hover:bg-green-50 rounded transition">
                        <svg class="h-5 w-5 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Permissions
                    </a>
                </li>
                <li>
                    <a href="{{ route('superadmin.posts.index') }}" class="flex items-center p-2 text-gray-700 hover:bg-indigo-50 rounded transition">
                        <svg class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        Posts
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>