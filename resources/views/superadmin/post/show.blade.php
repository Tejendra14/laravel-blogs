@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
                        <div class="flex items-center mt-2 space-x-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 
                                   ($post->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($post->status) }}
                            </span>
                            <span class="text-sm text-gray-500">By {{ $post->author->name }}</span>
                            <span class="text-sm text-gray-500">In {{ $post->category->name }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('superadmin.posts.index') }}" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>

                <div class="prose max-w-none">
                    {!! $post->content !!}
                </div>

                @if($post->status === 'pending')
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                    <form action="{{ route('superadmin.posts.approve', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Approve Post
                        </button>
                    </form>
                    <form action="{{ route('superadmin.posts.reject', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Reject Post
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection