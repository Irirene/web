@extends('layout')
@section('content')

@if ($errors->any())
<div class="alert-danger">
  <ul>
    @foreach ($errors->all() as $error)
    <li>{{$error}}</li>
    @endforeach
  </ul>
</div>
@endif

<form action="/comment/{{$comment->id}}/update" method="post">
  @METHOD('PUT')
  @csrf
  <div class="form-group">
    <label for="name">Title</label>
    <input type="text" class="form-control" id="title" name="title" value="{{$comment->title}}">
  </div>
  <div class="form-group">
    <label for="text">Text</label>
    <textarea name="desc" id="desc" cols="148" rows="5">{{$comment->desc}}</textarea>
  </div>
  <input type="hidden" name="article_id" value="{{$comment->article_id}}">
  <input type="hidden" name="user_id" value="{{$comment->user_id}}">
  <button type="submit" class="btn btn-primary">Update</button>
</form>

@endsection