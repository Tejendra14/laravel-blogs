<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;

class SuperAdminDashboardController extends Controller
{
  public function index()
{
    // Get counts
    $userCount = User::count();
    $pendingPostsCount = Post::where('status', 'pending')->count();
    $publishedPostsCount = Post::where('status', 'published')->count();
    
    // Recent activities
    $recentActivities = [
        [
            'description' => 'New post created',
            'time' => '5 minutes ago',
            'iconPath' => 'M12 6v6m0 0v6m0-6h6m-6 0H6',
            'bgColor' => 'bg-blue-100',
            'iconColor' => 'text-blue-600'
        ],
        [
            'description' => 'User role updated',
            'time' => '1 hour ago',
            'iconPath' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
            'bgColor' => 'bg-purple-100',
            'iconColor' => 'text-purple-600'
        ],
    ];

    return view('superadmin.dashboard', compact(
        'userCount',
        'pendingPostsCount',
        'publishedPostsCount',
        'recentActivities'
    ));
}
}
