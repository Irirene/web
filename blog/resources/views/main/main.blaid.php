@extends('layout')
@section('content')

<table class="table">
  <thead>
    <tr>
      <th scope="col">Data</th>
      <th scope="col">Name</th>
      <th scope="col">ShortDesc</th>
      <th scope="col">Desc</th>
      <th scope="col">Image</th>
    </tr>
  </thead>
  <tbody>
    @foreach($articles as $article)
    <tr>
      <th scope="row">{{$article->date}}</th>
      <td>{{$article->name}}</td>
      <td>{{$article->desc}}</td>
      <td>{{$article->shortDesc}}</td>
      <td><a href="gallery/{{$article->full_image}}"><img scr="{{URL::asset($article->preview_image)}}"></a></td>
    </tr>
    @endforeach
  </tbody>
</table>

@endsection