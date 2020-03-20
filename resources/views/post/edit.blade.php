@extends('layouts.default')
@section('content')
<div class="card uper">
    <div class="card-header">
        Edit new Post
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


        {!! Form::model($post, ['method' => 'PATCH','files'=>true, 'action' => ['PostController@update',$post->id]])
        !!}
        <img width="200px" height="200px" src="{{asset('storage/'.config('custom.paths.postImage').$post->image)}}" alt="" srcset="">
        @include('post.form', ['submitButtonText' => 'Edit'])
        {!! Form::close() !!}




    </div>
</div>
@endsection