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

        {!! Form::open(['action' => 'PostController@store','files' => true]) !!}
        @include('post.form', ['submitButtonText' => 'Add New Post'])
        {!! Form::close() !!}


    </div>
</div>
@endsection