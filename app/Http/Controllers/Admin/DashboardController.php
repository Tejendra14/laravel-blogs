<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class DashboardController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,author');
    }

    public function index()
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            $data = $this->getAdminData();
        } else {
            $data = $this->getAuthorData($user);
        }

        return view('admin.dashboard', $data);
    }

    protected function getAdminData()
    {
        return [
            'stats' => [
                'total_users' => [
                    'count' => \App\Models\User::count(),
                    'icon' => 'users',
                    'color' => 'blue'
                ],
                'total_posts' => [
                    'count' => \App\Models\Post::count(),
                    'icon' => 'newspaper',
                    'color' => 'green'
                ],
                'pending_posts' => [
                    'count' => \App\Models\Post::where('status', 'pending')->count(),
                    'icon' => 'clock',
                    'color' => 'yellow'
                ],
                'categories' => [
                    'count' => \App\Models\Category::count(),
                    'icon' => 'tags',
                    'color' => 'purple'
                ]
            ],
            'isAdmin' => true
        ];
    }

    protected function getAuthorData($user)
    {
        return [
            'stats' => [
                'my_posts' => [
                    'count' => $user->posts()->count(),
                    'icon' => 'file-alt',
                    'color' => 'blue'
                ],
                'published_posts' => [
                    'count' => $user->posts()->where('status', 'published')->count(),
                    'icon' => 'check-circle',
                    'color' => 'green'
                ],
                'pending_posts' => [
                    'count' => $user->posts()->where('status', 'pending')->count(),
                    'icon' => 'clock',
                    'color' => 'yellow'
                ],
                'draft_posts' => [
                    'count' => $user->posts()->where('status', 'draft')->count(),
                    'icon' => 'edit',
                    'color' => 'gray'
                ]
            ],
            'isAdmin' => false
        ];
    }
}