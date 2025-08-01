<div class="vh-100 position-fixed d-flex flex-column" style="width: 16rem; background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%); color: white;">
    <div class="p-4 border-bottom border-white-25">
        <h1 class="h5 fw-bold mb-1">
            @auth
                {{ auth()->user()->isAdmin() ? 'Admin' : 'Author' }} Panel
            @endauth
        </h1>
        <p class="small text-white-50">Welcome, {{ auth()->user()->name }}</p>
    </div>

    <nav class="flex-grow-1 overflow-auto mt-3">
        <ul class="nav flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link text-white px-3 py-2 d-flex align-items-center rounded-3 hover-bg-light">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>

            <!-- Posts Section -->
            <li class="nav-item">
                <a href="{{ route('admin.posts.index') }}" 
                   class="nav-link text-white px-3 py-2 d-flex align-items-center rounded-3 hover-bg-light">
                    <i class="fas fa-newspaper me-2"></i> Posts
                </a>
            </li>

            <!-- Category added here -->
            <li class="nav-item">
                <a href="{{ route('categories.index') }}" 
                   class="nav-link text-white px-3 py-2 d-flex align-items-center rounded-3 hover-bg-light">
                    <i class="fas fa-folder-open me-2"></i> Categories
                </a>
            </li>

            @if(auth()->user()->isAdmin())
                <li class="nav-item">
                    <a href="{{ route('admin.posts.pending') }}" 
                       class="nav-link text-white px-3 py-2 d-flex align-items-center rounded-3 hover-bg-light">
                        <i class="fas fa-clock me-2"></i> Pending Posts
                    </a>
                </li>
            @endif

            <!-- Common Actions -->
            <li class="nav-item">
                <a href="{{ route('admin.posts.create') }}" 
                   class="nav-link text-white px-3 py-2 d-flex align-items-center rounded-3 hover-bg-light">
                    <i class="fas fa-plus me-2"></i> Create Post
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout Button at bottom -->
    <div class="border-top border-white-25 mt-auto">
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" 
                    class="btn btn-link nav-link text-white text-start px-3 py-3 w-100 d-flex align-items-center rounded-3 hover-bg-light">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>
</div>

<style>
    /* Hover background effect */
    .hover-bg-light:hover {
        background-color: rgba(255 255 255 / 0.15);
        text-decoration: none;
    }
    /* Scrollbar styling for overflow if needed */
    nav.overflow-auto::-webkit-scrollbar {
        width: 6px;
    }
    nav.overflow-auto::-webkit-scrollbar-thumb {
        background-color: rgba(255,255,255,0.2);
        border-radius: 3px;
    }
</style>
