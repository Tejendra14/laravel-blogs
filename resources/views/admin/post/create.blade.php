@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0">
                            <i class="fas fa-newspaper me-2"></i>
                            {{ isset($post) ? 'Edit Post' : 'Create New Post' }}
                        </h3>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div>
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if(isset($post))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Post Title</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="{{ old('title', $post->title ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea class="form-control" id="content" name="content" rows="10">{{ old('content', $post->content ?? '') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Excerpt (Optional)</label>
                                    <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                                    <small class="text-muted">A short description of your post</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header bg-light text-dark">
                                        <h5 class="mb-0">Post Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select class="form-select" id="category_id" name="category_id" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                        {{ old('category_id', $post->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="pending" {{ old('status', $post->status ?? '') == 'pending' ? 'selected' : '' }}>Pending Review</option>
                                                @unless(auth()->user()->hasRole('author'))
                                                    <option value="published" {{ old('status', $post->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                                                @endunless
                                            </select>
                                        </div>

                                        @if(isset($post) && $post->featured_image)
                                        <div class="mb-3">
                                            <label class="form-label">Current Featured Image</label>
                                            <div class="border p-2 text-center">
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured Image" class="img-fluid mb-2" style="max-height: 150px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image">
                                                    <label class="form-check-label" for="remove_image">
                                                        Remove image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="mb-3">
                                            <label for="featured_image" class="form-label">Featured Image</label>
                                            <input class="form-control" type="file" id="featured_image" name="featured_image">
                                        </div>

                                        <div class="mb-3">
                                            <label for="published_at" class="form-label">Publish Date</label>
                                            <input type="datetime-local" class="form-control" id="published_at" name="published_at" 
                                                   value="{{ old('published_at', isset($post->published_at)) ? $post->published_at->format('Y-m-d\TH:i') : '' }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="tags" class="form-label">Tags</label>
                                            <select class="form-select" id="tags" name="tags[]" multiple>
                                                @foreach($tags as $tag)
                                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', isset($post) ? $post->tags->pluck('id')->toArray() : [])) ? 'selected' : '' }}>
                                                        {{ $tag->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Hold Ctrl (or Cmd on Mac) to select multiple tags</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>
                                        {{ isset($post) ? 'Update Post' : 'Create Post' }}
                                    </button>
                                    
                                    @if(isset($post))
                                    <a href="{{ route('admin.posts.show', $post->id) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i> Cancel
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<style>
    .ck-editor__editable_inline {
        min-height: 400px !important;
    }
</style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('#tags').select2({
            placeholder: "Select tags",
            width: '100%'
        });
    });
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'link', 'bulletedList', 'numberedList', '|',
                    'blockQuote', 'codeBlock', 'insertTable', 'undo', 'redo'
                ]
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });

        // Slug Generator
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        if (titleInput && slugInput) {
            titleInput.addEventListener('keyup', function () {
                const slug = titleInput.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.value = slug;
            });
        }
    });
</script>
@endpush
@endsection