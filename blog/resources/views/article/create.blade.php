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

<form action="/article" method="post">
  @csrf
<div class="form-group">
    <label for="date">Date</label>
    <input type="date" class="form-control" id="date" name="date">
  </div>
  <div class="form-group">
    <label for="name">Title</label>
    <input type="text" class="form-control" id="title" name="title">
  </div>
  <div class="form-group">
    <label for="shortDesc">ShortDesc</label>
    <input type="text" class="form-control" id="shortDesc" name="shortDesc">
  </div>
  <div class="form-group">
    <label for="text">Text</label>
    <textarea name="text" id="text" cols="148" rows="5"></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection