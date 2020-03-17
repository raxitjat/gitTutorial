@extends('layouts.default')

@section('content')

<div class="card uper">
    <div class="card-header">
        Update Shows
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
        <form method="post" action="{{ route('post.update', $post->id) }}">
            <div class="form-group">
                @csrf
                @method('PATCH')
                <label for="name">Post Title:</label>
                <input type="text" class="form-control" name="title" value="{{ $post->title }}" />
            </div>
            <div class="form-group">
                <label for="price">Post Description :</label>
                <input type="text" class="form-control" name="description" value="{{ $post->description }}" />
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
</div>
@endsection