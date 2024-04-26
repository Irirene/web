<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use App\Models\User;
use App\Mail\CommentMail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Jobs\VeryLongJob;
//use Illuminate\Notifications\Notification;
use App\Notifications\CommentNotify;

class CommentController extends Controller
{

    public function index()
    {
        $comments = DB::table('comments')
        ->join('articles', 'articles.id', 'comments.article_id')
        ->join('users', 'users.id', 'comments.user_id')
        ->select('comments.*', 'articles.id as article_id', 'articles.title as article', 'users.name')
        ->get();
        return view('comment.index', ['comments'=>$comments]);
    }


    public function store(Request $request){
        $request->validate([
            'title'=> 'required|min:5',
            'desc'=> 'required',
            'article_id' => 'required'
        ]);

        $article = Article::findOrFail($request->article_id);
        $users = User::where('id', '!=', auth()->id())->get();

        $comment = new Comment;
        $comment->title = $request->title;
        $comment->desc = $request->desc;
        $comment->user_id = auth()->id();
        $comment->article_id = $request->article_id;
        $res = $comment->save();
        if ($res) {
            VeryLongJob::dispatch($comment, $article);
            Notification::send($users, new CommentNotify($comment->title));
        }
        return redirect()->route('article.show', ['article'=>$request->article_id])->with(['res'=>$res]);
    }
    
    public function edit(Comment $comment)
    {
        Gate::authorize('comment', ['comment'=>$comment]);
        return view('comment.edit', ['comment'=>$comment]);
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'title' => 'required|min:6',
            'desc' => 'required',
            'article_id' => 'required',
        ]);

        $comment->title = $request->title;
        $comment->desc = $request->desc;
        $comment->user_id = 1;
        $comment->article_id = $request->article_id;
        $comment->save();
        return redirect()->route('article.show', ['article'=>$request->article_id]);
    }

    public function delete(Comment $comment)
    {
        Gate::authorize('comment', ['comment'=>$comment]);
        $comment->delete();
        return redirect()->route('article.show', ['article'=>$comment->article_id]);
    }

    public function accept(Comment $comment){
        $comment->accept = true;
        $users = User::where('id', '!=', auth()->id())->get();
        $res = $comment->save();
        if ($res) Notification::send($users, new CommentNotify($comment->title, $comment->article_id));
        return redirect()->route('comment.index');      
    }

    public function reject(Comment $comment){
        $comment->accept = false;
        $comment->save();
        return redirect()->route('comment.index');      
    }

}
