<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Events\ArticleEvent;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentPage = request('page') ? request('page'): 1;
        $articles = Cache::remember('articles'.$currentPage, 3000, function(){
            return Article::latest()->paginate(5);
        });
        if (request()->expectsJson()) return response()->json($articles);
        return view('article.index', ['articles'=>$articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', [self::class]);
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $keys = DB::table('cache')
        ->select('key')
        ->whereRaw('`key` GLOB :key', [':key' => 'articles*[0-9]'])->get();
        foreach($keys as $key){
            Cache::forget($key->key);
        }
        Gate::authorize('create', [self::class]);
        $request->validate([
            'date' => 'required',
            'title' => 'required|min:6',
            'text' => 'required'
        ]);

        $article = new Article();
        $article->date = $request->date;
        $article->title = $request->title;
        $article->shortDesc = $request->shortDesc;
        $article->text = $request->text;
        $article->user_id = 1;
        $res = $article->save();
        if ($res) ArticleEvent::dispatch($article);
        return redirect()->route('article.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        if (isset($_GET['id_notify'])){
            auth()->user()->notifications->where('id', $_GET['id_notify'])->first()->markAsRead();
        }

        $comments = Cache::rememberForever('article_comment'.$article->id, function()use ($article){
            return Comment::where('article_id', $article->id)->where('accept', true)->latest()->get();
        });

        return view('article.show', ['article'=>$article, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        Gate::authorize('create', [self::class]);
        return view('article.edit', ['article'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $keys = DB::table('cache')
        ->select('key')
        ->whereRaw('`key` GLOB :key', [':key' => 'articles*[0-9]'])->get();
        foreach($keys as $key){
            Cache::forget($key->key);
        }

        
        Gate::authorize('create', [self::class]);
        $request->validate([
            'date' => 'required',
            'title' => 'required|min:6',
            'text' => 'required'
        ]);

        $article->date = $request->date;
        $article->title = $request->title;
        $article->shortDesc = $request->shortDesc;
        $article->text = $request->text;
        $article->user_id = 1;
        $article->save();
        return redirect()->route('article.show', ['article'=>$article->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Cache::flush();
        Gate::authorize('create', [self::class]);
        $comments = Comment::where('article_id', $article->id)->latest()->get();
        $article->delete();
        foreach ($comments as $comment){
            $comment->delete();
        }
        return redirect()->route('article.index');
    }
}
