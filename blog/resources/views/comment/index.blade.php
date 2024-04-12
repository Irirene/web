@extends('layout')
@section('content')

<table class="table">
  <thead>
    <tr>
      <th scope="col">Title</th>
      <th scope="col">Text</th>
      <th scope="col">Article</th>
      <th scope="col">UserName</th>
      <th scope="col">Approve</th>
    </tr>
  </thead>
  <tbody>
    @foreach($comments as $comment)
    <tr>
      <th scope="row">{{$comment->title}}</th>
      <td>{{$comment->desc}}</td>
      <td><a href="/article/{{$comment->article_id}}">{{$comment->article}}</a></td>
      <td>{{$comment->name}}</td>
      <td>
        <a class="btn-success" href="/comment/{{$comment->id}}/accept">Accept</a>
        <a class="btn-warning" href="/comment/{{$comment->id}}/reject">Reject</a>
    </td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection