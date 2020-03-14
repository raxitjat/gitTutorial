@extends('layouts.default')
@section('content')
<div class="card uper">
    <div class="card-header">
        Create new Post
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
        <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
            <div class="form-group">
                @csrf
                <label for="name">Title:</label>
                <input type="text" class="form-control" name="title" />
            </div>
            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" name="image" class="form-control">
                </div>

            <div class="form-group">
                <label for="price">Description :</label>
                <input type="text" class="form-control" name="description" />
            </div>

            <button type="submit" class="btn btn-primary">Add New Post </button>
        </form>
    </div>
</div>
@endsection