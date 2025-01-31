<form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: auto; background: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    @csrf
    @method('PUT')

    <h2 style="text-align: center; color: #333; margin-bottom: 20px;">Edit Post</h2>

    <div class="mb-3">
        <label for="title" class="form-label" style="font-weight: bold;">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required 
               style="border-radius: 8px; padding: 10px; border: 1px solid #ccc;">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label" style="font-weight: bold;">Description</label>
        <textarea class="form-control" id="description" name="description" rows="4" required 
                  style="border-radius: 8px; padding: 10px; border: 1px solid #ccc;">{{ $post->description }}</textarea>
    </div>

    <div class="mb-3">
        <label for="category" class="form-label" style="font-weight: bold;">Category</label>
        <select class="form-control" id="category" name="categoryId" required 
                style="border-radius: 8px; padding: 10px; border: 1px solid #ccc;">
            @foreach($categories as $category)
                <option value="{{ $category->categoryId }}" {{ $category->categoryId == $post->categoryId ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label" style="font-weight: bold;">Post Image</label>
        <input type="file" class="form-control" id="image" name="image"
               style="border-radius: 8px; padding: 10px; border: 1px solid #ccc;">
    </div>

    <button type="submit" class="btn btn-primary" 
            style="width: 100%; padding: 10px; font-size: 16px; background: #007bff; border: none; border-radius: 8px; cursor: pointer;">
        Update Post
    </button>
</form>
