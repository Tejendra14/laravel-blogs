<nav class="bg-blue-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-xl font-bold">Laravel Blog</a>
        <div class="flex space-x-4">
            @auth
                @if(auth()->guard('superadmin')->check())
                    <a href="{{ route('superadmin.dashboard') }}" class="hover:underline">SuperAdmin Dashboard</a>
                @endif
                
                <form action="{{ route('superadmin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            @else
                <a href="{{ route('superadmin.login') }}" class="hover:underline">Login</a>
            @endauth
        </div>
    </div>
</nav>