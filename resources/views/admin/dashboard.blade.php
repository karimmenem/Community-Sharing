@extends('layout.master') <!-- Assuming you have a master layout -->

@section('content')
    <div class="container mt-4">
        <h1>Admin Dashboard</h1>
        <div class="dashboard-overview">
            <div class="row">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Users</h5>
                            <p class="card-text">{{ $userCount }}</p>
                            <a href="{{ route('admin.manageUsers') }}" class="btn btn-primary">Manage Users</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Total Posts</h5>
                            <p class="card-text">{{ $postCount }}</p>
                            <a href="{{ route('admin.managePosts') }}" class="btn btn-primary">Manage Posts</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <h2>Quick Actions</h2>
        <div class="quick-actions">
            <a href="{{ route('admin.manageUsers') }}" class="btn btn-outline-secondary">View All Users</a>
            <a href="{{ route('admin.managePosts') }}" class="btn btn-outline-secondary">View All Posts</a>
        </div>
    </div>
@endsection
