@extends('admin.layout.app')

@section('title', 'Categories')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Categories</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
{{-- resources/views/layouts/sidebar.blade.php --}}
@auth
    <div class="card mb-4">
        <div class="card-header">
            <h5>Your Roles & Permissions</h5>
        </div>
        <div class="card-body">
            <h6>Roles:</h6>
            <ul class="list-unstyled">
                @foreach(auth()->user()->getRoleNames() as $role)
                    <li>
                        <span class="badge bg-primary">{{ $role }}</span>
                    </li>
                @endforeach
            </ul>
            
            <h6 class="mt-3">Permissions:</h6>
            <div class="d-flex flex-wrap gap-1">
                @foreach(auth()->user()->getAllPermissions() as $permission)
                    <span class="badge bg-success">{{ $permission->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
@endauth
    @if($categories->count())
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ Str::limit($category->description, 50) }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning me-1">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $categories->links() }}
    @else
        <p>No categories found.</p>
    @endif
</div>
@endsection
