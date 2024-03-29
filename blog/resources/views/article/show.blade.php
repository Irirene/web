@extends('layout')
@section('content')

<div class="text-center mt-3">
<div class="card">
  <div class="card-body">
    <h5 class="card-title">{{$article->title}}</h5>
    <h6 class="card-subtitle mb-2 text-muted">{{$article->shortDesc}}</h6>
    <p class="card-text">{{$article->text}}</p>
    <div class="d-flex">
    <a class="btn btn-info mr-1" href="/aricle/{{$article->id}}/edit" class="card-link">Edit</a>
    <form action="" method="post">
        @csrf
        @METHOD('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    </div>
    
  </div>
</div>
</div>

@endsection