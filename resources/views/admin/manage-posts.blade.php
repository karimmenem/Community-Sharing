@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1>Manage Posts</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->postId }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->user->username }}</td>
                        <td>
                            <form action="{{ route('admin.deletePost', ['id' => $post->postId]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection