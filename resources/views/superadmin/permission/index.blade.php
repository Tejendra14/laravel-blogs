@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Permission Management</h1>
            <div class="relative inline-block group">
                <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-400 cursor-not-allowed" disabled>
                    Create New Permission
                </button>
                <div class="absolute z-10 hidden group-hover:block w-48 bg-gray-900 text-white text-xs rounded py-1 px-2 bottom-full left-1/2 transform -translate-x-1/2 mb-2">
                    Creation disabled for demo assessment
                    <svg class="absolute text-gray-900 h-2 w-full left-0 top-full" x="0px" y="0px" viewBox="0 0 255 255">
                        <polygon class="fill-current" points="0,0 127.5,127.5 255,0"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($permissions as $permission)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $permission->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $permission->slug }}</td>
                            <td class="px-6 py-4">{{ $permission->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="relative inline-block group mr-3">
                                    <button class="text-blue-400 hover:text-blue-400 cursor-not-allowed" disabled>
                                        Edit
                                    </button>
                                    <div class="absolute z-10 hidden group-hover:block w-48 bg-gray-900 text-white text-xs rounded py-1 px-2 bottom-full left-1/2 transform -translate-x-1/2 mb-2">
                                        Editing disabled for demo assessment
                                        <svg class="absolute text-gray-900 h-2 w-full left-0 top-full" x="0px" y="0px" viewBox="0 0 255 255">
                                            <polygon class="fill-current" points="0,0 127.5,127.5 255,0"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="relative inline-block group">
                                    <button class="text-red-400 hover:text-red-400 cursor-not-allowed" disabled>
                                        Delete
                                    </button>
                                    <div class="absolute z-10 hidden group-hover:block w-48 bg-gray-900 text-white text-xs rounded py-1 px-2 bottom-full left-1/2 transform -translate-x-1/2 mb-2">
                                        Deletion disabled for demo assessment
                                        <svg class="absolute text-gray-900 h-2 w-full left-0 top-full" x="0px" y="0px" viewBox="0 0 255 255">
                                            <polygon class="fill-current" points="0,0 127.5,127.5 255,0"/>
                                        </svg>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No permissions found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection