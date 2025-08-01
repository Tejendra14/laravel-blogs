@extends('admin.layout.app')

@section('title', $title)

@section('content')
<div class="container py-5">
    <h2 class="mb-4">{{ $title }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $formAction }}" method="POST">
        @csrf
        @method($method)

        <div class="mb-3">
            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control" required 
                   value="{{ old('name', $category->name) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description (optional)</label>
            <textarea id="description" name="description" class="form-control" rows="4">
                {{ old('description', $category->description) }}
            </textarea>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">
                {{ $method === 'POST' ? 'Create' : 'Update' }} Category
            </button>
        </div>
    </form>
</div>
@endsection