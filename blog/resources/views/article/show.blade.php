@extends('layout')
@section('content')

<div class="text-center mt-3">
<div class="card">
  <div class="card-body">
    <h5 class="card-title">{{$article->title}}</h5>
    <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
    <p class="card-text">{{$article->text}}</p>
    @can('create')
    <div class="d-flex">
    <a class="btn btn-info mr-1" href="/article/{{$article->id}}/edit" class="card-link">Edit</a>
    <form action="/article/{{$article->id}}" method="post">
        @csrf
        @METHOD('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    </div>
    @endcan
  </div>
</div>
</div>

<div class="text-center mt-3">
  <h4>Comments</h4>
</div>

@if ($errors->any())
<div class="alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>
</div>
@endif

<form action="/comment" method="post">
  @csrf
  <input type="hidden" name="article_id" value="{{$article->id}}">
  <div class="form-group">
    <label for="name">Title</label>
    <input type="text" class="form-control" id="title" name="title">
  </div>
  <div class="form-group">
    <label for="text">Text</label>
    <textarea name="desc" id="desc" cols="148" rows="3"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>

@foreach ($comments as $comment)
<div class="text-center mt-3">
<div class="card">
  <div class="card-body">
    <h5 class="card-title">{{$comment->title}}</h5>
    <p class="card-text">{{$comment->desc}}</p>
    <div class="d-flex">
      @can('comment', $comment)
      <a class="btn btn-info mr-1" href="/comment/{{$comment->id}}/edit" class="card-link">Edit Comment</a>
      <a class="btn btn-danger mr-1" href="/comment/{{$comment->id}}/delete" class="card-link">Delete Comment</a>
      @endcan
    </div>
  </div>
</div>
</div>
@endforeach

@endsection