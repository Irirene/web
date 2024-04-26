<!doctype html>
<html lang="en">
  <head>
    <title>Laravel</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

  </head>
  <body class="antialiased">
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/main">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{route('article.index')}}">Article <span class="sr-only">(current)</span></a>
      </li>
      @can('create')
      <li class="nav-item">
        <a class="nav-link" href="/article/create">Create Article</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/comment/index">New Comment</a>
      </li>
      @endcan
      @auth
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          Notify <span>{{auth()->user()->unreadNotifications()->count()}}</span>
        </a>
        <div class="dropdown-menu">
          @foreach(auth()->user()->unreadNotifications as $notify)
          <a class="dropdown-item" href="{{route('article.show', ['article'=>$notify->data['idArticle']])}}">{{$notify->data['titleComment']}}</a>
          @endforeach
        </div>
      </li>
      @endauth
    </ul>
    
    <div class="form-inline my-2 my-lg-0">
      @guest
      <a href="/signin" class="btn btn-outline-success my-2 mr-2 my-sm-0" >Sign In</a>
      <a href="/signup" class="btn btn-outline-success my-2 mr-2 my-sm-0">Sign Up</a>
      @endguest
      @auth
      <a href="/logout" class="btn btn-outline-success my-2 my-sm-0">Sign Out</a>
      @endauth
      </div>   
</div>
  </div>
</nav>
    </header>
    <main>
      <div class="container">
      <div id="app">
        <App />
      </div>
      @yield('content')
      </div>
    </main>
  </body>
</html>