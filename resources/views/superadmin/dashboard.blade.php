@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Super Admin Dashboard</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Stats Cards -->
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-blue-800">Total Users</h3>
                        <p class="mt-2 text-3xl font-bold text-blue-600">3</p>
                    </div>
                    
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-green-800">Pending Posts</h3>
                        <p class="mt-2 text-3xl font-bold text-green-600">{{ $pendingPostsCount }}</p>
                    </div>
                    
                    <div class="bg-purple-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-purple-800">Published Posts</h3>
                        <p class="mt-2 text-3xl font-bold text-purple-600">{{ $publishedPostsCount }}</p>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <ul class="divide-y divide-gray-200">
                            @foreach($recentActivities as $activity)
                            <li class="py-3">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full {{ $activity['bgColor'] }} flex items-center justify-center">
                                            <svg class="h-5 w-5 {{ $activity['iconColor'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $activity['iconPath'] }}" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $activity['description'] }}</p>
                                        <p class="text-sm text-gray-500 truncate">{{ $activity['time'] }}</p>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- View Users -->
                        <a href="{{ route('superadmin.users.index') }}" class="bg-blue-50 p-4 rounded-lg text-center hover:bg-blue-100 transition">
                            <svg class="mx-auto h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900">View Users</p>
                        </a>
                        
                        <!-- View Roles -->
                        <a href="{{ route('roles.index') }}" class="bg-purple-50 p-4 rounded-lg text-center hover:bg-purple-100 transition">
                            <svg class="mx-auto h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900">View Roles</p>
                        </a>
                        
                        <!-- View Permissions -->
                        <a href="{{ route('permissions.index') }}" class="bg-green-50 p-4 rounded-lg text-center hover:bg-green-100 transition">
                            <svg class="mx-auto h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900">View Permissions</p>
                        </a>
                        
                        <!-- View Posts -->
                        <a href="{{ route('superadmin.posts.index') }}" class="bg-indigo-50 p-4 rounded-lg text-center hover:bg-indigo-100 transition">
                            <svg class="mx-auto h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <p class="mt-2 text-sm font-medium text-gray-900">View Posts</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection